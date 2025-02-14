<?php

namespace App\Http\Controllers;

use App\Models\Sandtopia;
use App\Models\SandtopiaInstance;
use App\Models\UserFellow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SandtopiaInstanceController extends Controller
{
    //

    public function index(){
        if (Sandtopia::where('user_id', Auth::user()->id)->first() == null)
            return $this->editSandtopiaPower();
        // $sandtopia = SandtopiaInstance::withSandtopia()->where('user_id', Auth::user()->id)->get();
        return view('sandtopia');
    }

    public function editSandtopiaPower(){
        $user = Auth::user();
        if(Sandtopia::where('user_id', $user->id)->count() == 0){
            foreach(Sandtopia::$rewards as $reward){
                $sandtopia = new Sandtopia;
                $sandtopia->user_id = $user->id;
                $sandtopia->reward = $reward;
                $sandtopia->save();
            }
        }
        $sandtopia = Sandtopia::where('user_id', $user->id)->get();

        return view('edit_sandtopia', compact('sandtopia'));
    }

    public function submitSandtopiaPower(Request $request){
        $input = $request->input();
        foreach($input['power'] as $key => $power){
            $sandtopia = Sandtopia::where('id', $key)->first();
            $sandtopia->power = $power;
            $sandtopia->save();
        }
        return redirect()->route('explore-sandtopia');
    }

    public function exploreSandtopia(){
        $user = Auth::user();
        $sandtopia = Sandtopia::where('user_id', $user->id)->get();
        $run_id = SandtopiaInstance::getRunId();


        return view('explore_sandtopia', compact('sandtopia', 'run_id'));
    }

    public function newSandtopiaRun(Request $request){

        $sandtopiaInstance = new SandtopiaInstance;
        $sandtopiaInstance->user_id = Auth::user()->id;
        $sandtopiaInstance->run_id = SandtopiaInstance::getNewRunId();
        $sandtopiaInstance->save();

        return redirect()->route('explore-sandtopia');
    }

    public function explore(Request $request){
        $user = Auth::user();
        $input = $request->input();
        $sandtopia = Sandtopia::where('id', $input['sandtopia_id'])->where('user_id', $user->id)->first();
        $run_id = SandtopiaInstance::getRunId($input['new_run'] ?? false);
        $explorations = SandtopiaInstance::where('user_id', $user->id)->where('run_id', $run_id)->get();
        $usedFellows = $this->getUsedFellows($explorations);

        $unusedFellows = UserFellow::withFellow()->where('user_id', $user->id)->whereNotIn('id', $usedFellows)->orderBy('power', 'desc')->get();

        $neededPower = $sandtopia->parsePower();


        dd($neededPower, $unusedFellows, UserFellow::getHighestPowerBelow(100_000_000));


        // dd($explorations);
        return redirect()->route('explore-sandtopia');
    }

    public function submitExploration(Request $request){
        $input = $request->input();

        $sandtopiaInstance = new SandtopiaInstance;
        $sandtopiaInstance->user_id = Auth::user()->id;
        $sandtopiaInstance->sandtopia_id = $input['sandtopia_id'];
        $sandtopiaInstance->run_id = $input['run_id'];
        $sandtopiaInstance->fellows = $input['fellows'];
        $sandtopiaInstance->save();
    }

    public function getUsedFellows($explorations){
        $usedFellows = [];
        foreach($explorations as $exploration){
            $fellows = json_decode($exploration->fellows) ?? [];
            array_merge($fellows, $usedFellows);
        }
        return $usedFellows;
    }

    public function getOptimalFellows($fellows, $neededPower){
        $return = [];
        $possibleChoises = [];
        $bestChoise = ['totalPower' => 0, 'fellows' =>[]];
        $memory = ['totalPower' => 0, 'fellows' =>[]];
        foreach($fellows as $fellow){
            if ($fellow->power > $neededPower){
                if ($bestChoise['totalPower'] != 0 && $bestChoise['totalPower'] > $fellow->power ){
                    $bestChoise['totalPower'] = $fellow->power;
                    $bestChoise['fellows'] = [$fellow->id];
                    // $bestChoise = [
                    //     'totalPower' => $fellow->power,
                    //     'fellows' => [$fellow->id],
                    // ];
                    $possibleChoises[$bestChoise['totalPower']] = $bestChoise;
                }
                continue;
            }
            if ($memory['totalPower'] == 0){
                $memory['totalPower'] += $fellow->power;
                $memory['fellows'][] = $fellow->id;
                $lowestPower = UserFellow::getLowestPowerAbove($neededPower - $fellow->power);
                if ($lowestPower != null){
                    $memory['totalPower'] += $lowestPower->power;
                    $memory['fellows'][] = $lowestPower->id;
                    $possibleChoises[$memory['totalPower']] = $memory;
                    $this->getBestCoise($bestChoise, $memory);
                    $this->emptyMemory($memory);
                }
            }else{

            }
        }

        return $return;
    }

    public function getBestCoise(&$bestChoise, $memory){
        if ($memory['totalPower'] < $bestChoise['totalPower'] || $bestChoise['totalPower'] == 0){
            $bestChoise = $memory;
        }
    }

    public function emptyMemory(&$memory){
        $memory['totalPower'] = 0;
        $memory['fellows'] = [];
    }
}
