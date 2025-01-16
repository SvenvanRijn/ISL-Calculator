<?php

namespace App\Http\Controllers;

use App\Models\GuildUserFellow;
use App\Models\Monster;
use App\Models\UserFellow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MineInstanceController extends Controller
{
    protected $guildPower = 205000000;//temp

    public $maxFellows = 6;

    protected $lostPower = [];
    protected $targetLevel;
    protected $totalPower;
    protected $monsterPower;
    protected $fellowPower = [];

    public function index(){
        $guildFellows = GuildUserFellow::whereUser()->get();
        return view('mineclearence', compact('guildFellows'));
    }

    public function start(Request $request){
        $input = $request->input();
        $guildFellows = [];
        // dd($input);
        foreach ($input['power'] as $key => $power){
            if ($power == null || $input['name'][$key] == null){
                continue;
            }
            $guildFellows[$key]['power'] = (int) $power;
            $guildFellows[$key]['name'] = $input['name'][$key];

            $guildFellow = null;
            if (array_key_exists('id', $input)){
                $guildFellow = GuildUserFellow::whereUser()->where('id', $input['id'][$key]);

            }
            if ($guildFellow === null){
                $guildFellow = new GuildUserFellow;
                $guildFellow->user_id = Auth::user()->id;
            }
            $guildFellow->power = (int) $power;
            $guildFellow->name = $input['name'][$key];
            $guildFellow->save();
        }

        return $this->startMineInstance($guildFellows, $input['power']);
    }

    public function startWithoutGuild(){

        return $this->startMineInstance([],[]);
    }

    public function startMineInstance($guildFellows, $guildFellowPower){
        $monsters = Monster::all();
        $monsterPower = $this->totalPower($monsters);
        $userfellows = UserFellow::whereUser()->withFellow()->get();
        $power = $this->totalPower($userfellows);
        // array_push($this->fellowPower, ...$guildFellowPower);
        foreach($guildFellowPower as $num => $guildPower){
            $key = $num . "g";
            $this->fellowPower[$key] = $guildPower;
        }
        asort($this->fellowPower);
        asort($power['single']);

        $this->targetLevel($monsterPower, $power);

        $fellows = [];
        foreach($userfellows as $userfellow){
            $fellows[$userfellow->id] = $userfellow;
        }
        foreach($guildFellows as $num => $guildFellow){
            $key = $num . "g";
            $guildFellow['img_src'] = "https://via.placeholder.com/200x200";
            $fellows[$key] = $guildFellow;
        }
        $levels = [];
        foreach($monsterPower['single'] as  $level => $monster){
            if($level >= $this->targetLevel){
                break;
            }
            asort($this->fellowPower);
            // echo "<hr>$level";
            $levels[$level] = $this->bestFellows($monster, $this->fellowPower);
        }

        $perLevel = [];
        foreach($levels as $level => $usedFellows){

            foreach($usedFellows as $id => $usedFellowPower){
                if($id == "auto"){
                    $perLevel[$level][$id] = $usedFellowPower;
                }else{
                    $perLevel[$level][$id] = $fellows[$id];
                }
            }
        }


        // dd($power, $monsterPower,$this->targetLevel, $levels, $this->fellowPower, $this->lostPower);
        // dd(view('all-levels', compact('levels')));
        return view('alllevels', compact('perLevel'));//->with('levels', $levels);
    }

    private function bestFellows($monster, $fellows){
        $count = 0;
        $closestPower = ['totalPower' => 0, 'fellows' => []];
        foreach($fellows as $key => $fellow){
            if($count == 0 ){
                $count++;
                if($fellow > $monster){
                    unset($this->fellowPower[$key]);
                    $this->lostPower[] = $fellow - $monster;
                    if(str_contains($key, "g")){
                        return [$key => $fellow];
                    }
                    return [$key => $fellow , "auto" => true];
                }
            }
            if($fellow > $monster){
                if($fellow < $closestPower['totalPower'] || $closestPower['totalPower'] == 0){
                    $closestPower['totalPower'] = $fellow;
                    $closestPower['fellows'] = [
                        $key => $fellow,
                    ];
                    if($closestPower['totalPower'] != 0 && !str_contains($key, "g")){
                        $closestPower['fellows']['auto'] = true;
                    }
                    continue;
                }else{
                    break;
                }
            }
            $closestPower = $this->multipleFellows($monster, $fellows, $closestPower, [$key => $fellow]);
            // echo "<br>next fellow<br>";
        }
        // echo "<pre> Final ";
        // var_dump($closestPower);
        // echo "</pre>";

        //unset and return
        foreach($closestPower['fellows'] as $key => $fellow){
            unset($this->fellowPower[$key]);
        }
        if($closestPower['totalPower'] != 0){
            $this->lostPower[] = $closestPower['totalPower'] - $monster;
        }
        return $closestPower['fellows'];
    }

    private function multipleFellows($monster, $fellows, $closestPower, $memory = []){
        // var_dump($memory);
        $totalMemoryPower = 0;
        $newClosestPower = ['totalPower' => 0, 'fellows' => []];
        foreach($memory as $power){
            $totalMemoryPower += $power;
        }
        foreach($fellows as $key => $fellow){
            if(array_key_exists($key, $memory)){
                continue;
            }
            if($fellow + $totalMemoryPower > $monster ){if($fellow + $totalMemoryPower < $closestPower['totalPower'] || $closestPower['totalPower'] == 0){
                    $memory[$key] = $fellow;
                    $totalMemoryPower += $fellow;
                    $newClosestPower['totalPower'] = $totalMemoryPower;
                    $newClosestPower['fellows'] = $memory;
                    // echo "<pre>" ;
                    // var_dump($newClosestPower);
                    // echo "</pre>";
                    return $newClosestPower;
                }else{
                    $newClosestPower = $closestPower;
                    break;
                }
            }
            if(count($memory) <= $this->maxFellows){
                $memory[$key] = $fellow;
                $closestPower = $this->multipleFellows($monster, $fellows, $closestPower, $memory);
                unset($memory[$key]);
                // echo "<pre>" . ($totalMemoryPower + $fellow);
                // var_dump($memory);
                // echo "</pre>";
            }
        }
        // var_dump($newClosestPower);
        return $newClosestPower;
    }

    private function targetLevel($monsterPower, $power){
        $totalPower = $power['total'][array_key_last($power['total'])] + $this->guildPower;//temp
        foreach($monsterPower['total'] as $level => $neededPower){
            if($neededPower > $totalPower){
                $this->targetLevel = $level;
                return;
            }
            $lastLevel = $level;
        }
        $this->targetLevel = $lastLevel;
        return;
    }

    private function totalPower($data){
        $power = ['total' => [], 'single' => []];
        foreach ($data as $key => $enitity) {
            $power['total'][$enitity->id] = $enitity->power;
            $power['single'][$enitity->id] = $enitity->power;
            foreach($data as $k => $prevPower){
                if($k >= $key){
                    break;
                }
                $power['total'][$enitity->id] += $prevPower->power;
            }
        }
        // $this->totalPower = $power[array_key_last($power)];
        $this->fellowPower = $power['single'];
        return $power;
    }
}

class MineClearence
{
    public $fellows;
    public $monsters;
    public $currentLevel;
    public $targetLevel;
}
