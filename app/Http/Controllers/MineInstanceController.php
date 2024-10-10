<?php

namespace App\Http\Controllers;

use App\Models\Monster;
use App\Models\UserFellow;
use Illuminate\Http\Request;

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
        return view('mineclearence');
    }

    public function start(){
        $this->startMineInstance([92000000, 60000000, 55000000, 50000000, 40000000]);
    }

    public function startMineInstance($guildFellows){
        $monsters = Monster::all();
        $monsterPower = $this->totalPower($monsters);
        $fellows = UserFellow::whereUser()->get();
        $power = $this->totalPower($fellows);
        array_push($this->fellowPower, ...$guildFellows);
        asort($this->fellowPower);
        asort($power['single']);

        $this->targetLevel($monsterPower, $power);

        $levels = [];
        foreach($monsterPower['single'] as  $level => $monster){
            if($level >= $this->targetLevel){
                break;
            }
            asort($this->fellowPower);
            // echo "<hr>$level";
            $levels[$level] = $this->bestFellows($monster, $this->fellowPower);
        }

        dd($power, $monsterPower,$this->targetLevel, $levels, $this->fellowPower, $this->lostPower);
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
                    return [$key => $fellow];
                }
            }
            if($fellow > $monster){
                if($fellow < $closestPower['totalPower'] || $closestPower['totalPower'] == 0){
                    $closestPower['totalPower'] = $fellow;
                    $closestPower['fellows'] = [
                        $key => $fellow,
                    ];
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
        }
    }

    private function totalPower($data){
        $power = ['total' => [], 'single' => []];
        foreach ($data as $key => $enitity) {
            $power['total'][$key] = $enitity->power;
            $power['single'][$key] = $enitity->power;
            foreach($data as $k => $prevPower){
                if($k >= $key){
                    break;
                }
                $power['total'][$key] += $prevPower->power;
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
