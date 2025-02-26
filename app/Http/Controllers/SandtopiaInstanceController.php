<?php

namespace App\Http\Controllers;

use App\Models\Sandtopia;
use App\Models\SandtopiaInstance;
use App\Models\UserFellow;
use Exception;
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

        $unusedFellows = UserFellow::withFellow()->where('user_id', $user->id)->whereNotIn('user_fellows.id', $usedFellows)->orderBy('power', 'desc')->get();

        $neededPower = $sandtopia->parsePower();

        $options = $this->test3($unusedFellows->toArray(), $neededPower);
        ksort($options['options']);
        // foreach($options[0] as $key => &$option){
        //     ksort($option['fellows']);
        // }
        return response()->json($options);
        dd($options);
        $fellowPower = $this->getOptimalFellows($unusedFellows, $neededPower);
        dd($fellowPower);

        // dd($explorations);
        return redirect()->route('explore-sandtopia');
    }

    public function submitExploration(Request $request){
        $input = $request->input();

        $sandtopiaInstance = new SandtopiaInstance;
        $sandtopiaInstance->user_id = Auth::user()->id;
        $sandtopiaInstance->sandtopia_id = $input['sandtopia_id'];
        $sandtopiaInstance->run_id = SandtopiaInstance::getRunId();
        $sandtopiaInstance->fellow_ids = $input['fellows'];
        $sandtopiaInstance->save();

        return response()->json($sandtopiaInstance->toArray());
    }

    public function getUsedFellows($explorations){
        $usedFellows = [];
        foreach($explorations as $exploration){
            $fellows = json_decode($exploration->fellow_ids);
            $usedFellows = array_merge($fellows, $usedFellows);
        }
        return $usedFellows;
    }

    public function getOptimalFellows($fellows, $neededPower){
        $return = [];
        $possibleChoises = [];
        $bestSingleFellowPower = UserFellow::getLowestPowerAbove($neededPower);
        $bestChoise = ['totalPower' => 0, 'fellows' =>[]];
        $lowestPowerUsed = 0;
        if ($bestSingleFellowPower != null){
            $this->getBestCoise($bestChoise, $bestSingleFellowPower, $neededPower);
            $possibleChoises[$bestSingleFellowPower->id] = $bestChoise;
        }
        $memory = ['totalPower' => 0, 'fellows' =>[]];
        foreach($fellows as $fellow){
            if ($fellow->power > $neededPower){
                continue;
            }
            $lowestPowerUsed = $fellow->power;
            $memory['totalPower'] += $fellow->power;
            $memory['fellows'][$fellow->id] = $fellow;
            $lowestPower = UserFellow::getLowestPowerBetween($lowestPowerUsed, $neededPower - $memory['totalPower']);
            if ($lowestPower != null){
                $memory['totalPower'] += $lowestPower->power;
                $memory['fellows'][$lowestPower->id] = $lowestPower;
                $possibleChoises[$memory['totalPower']] = $memory;
                $this->getBestCoise($bestChoise, $memory, $neededPower);
                $this->emptyMemory($memory);
            }
        }

        $optimalChoises = $this->optimizePossibleFellows($possibleChoises, $neededPower, $bestChoise);

        $return = $bestChoise['fellows'];

        ksort($possibleChoises);
        ksort($optimalChoises);
        return ['bestChoise' => $bestChoise, 'possibleChoises' => $possibleChoises, 'return' => $optimalChoises];
    }

    public function optimizePossibleFellows($possibleChoises, $neededPower, &$bestChoise){
        $return = $possibleChoises;
        foreach($possibleChoises as $power => $memory){
            if (count($memory['fellows']) == 1){
                continue;
            }
            foreach($memory['fellows'] as $fellow){

                $lowestPower = UserFellow::getLowestPowerAbove($neededPower - $power + $fellow->power);
                if ($lowestPower->power < $fellow->power){
                    $newChoise['totalPower'] = $power - $fellow->power + $lowestPower->power;
                    $newChoise['fellows'] = $memory['fellows'];
                    unset($newChoise['fellows'][$fellow->id]);
                    $newChoise['fellows'][$lowestPower->id] = $lowestPower;
                    $this->getBestCoise($bestChoise, $newChoise, $neededPower);
                    $return[$newChoise['totalPower']] = $newChoise;
                }
            }
        }

        return $return;
    }

    public function getBestCoise(&$bestChoise, $memory, $neededPower){
        if ($memory['totalPower'] < $bestChoise['totalPower'] || $bestChoise['totalPower'] == 0){
            $bestChoise = $memory;
            $bestChoise['neededPower'] = $memory['totalPower'] > $neededPower * 1.001 ? $memory['totalPower'] : $neededPower * 1.001;
        }
    }

    public function emptyMemory(&$memory){
        $memory['totalPower'] = 0;
        $memory['fellows'] = [];
    }

    public function addFellowToMemory(&$memory, $fellow){
        $memory['totalPower'] += $fellow->power;
        $memory['fellows'][$fellow->id] = $fellow;
    }

    public function test($fellows, $neededPower){
        $options = [];
        $memory = ['totalPower' => 0, 'fellows' => []];
        $lowestPowerUsed = 0;
        foreach($fellows as $fellow){
            if ($fellow['power'] > $neededPower){
                continue;
            }
            $lowestPowerUsed = $fellow['power'];
            $memory['totalPower'] += $fellow['power'];
            $memory['fellows'][$fellow['power']] = $fellow;
            $this->test2($options, $memory, $fellows, $neededPower, $lowestPowerUsed);
            $this->emptyMemory($memory);
        }
        return $options;
    }

    public function test2(&$options, $memory, $fellows, $neededPower, $lowestPowerUsed = 0, $depth = 0){
        if ($depth > 3){
            return;
        }
        if ($lowestPowerUsed == $fellows[array_key_last($fellows)]['power']){
            return;
        }
        $intMemory = $memory;
        if ($lowestPowerUsed > $neededPower - $memory['totalPower']){
            $lowestFellow = UserFellow::getLowestPowerBetween($lowestPowerUsed, $neededPower - $memory['totalPower']);
            if ($lowestFellow != null){
                $intMemory['totalPower'] += $lowestFellow->power;
                $intMemory['fellows'][$lowestFellow->power] = $lowestFellow;
                if ($intMemory['totalPower'] >= $neededPower){
                    $options[$intMemory['totalPower']] = $intMemory;
                    $intMemory = $memory;
                    return;
                } else {
                    throw new Exception($intMemory);
                }
            }
        }
        foreach($fellows as $fellow){
            if ($fellow['power'] >= $lowestPowerUsed){
                continue;
            }
            $lowestPowerUsed = $fellow['power'];
            $intMemory['totalPower'] += $fellow['power'];
            $intMemory['fellows'][$fellow['power']] = $fellow;
            if ($intMemory['totalPower'] >= $neededPower){
                $options[$intMemory['totalPower']] = $intMemory;
                $intMemory = $memory;
                return;
            } else {
                $this->test2($options, $intMemory, $fellows, $neededPower, $lowestPowerUsed, $depth + 1);
                $intMemory = $memory;
            }
        }
        return;
    }

    public function test3($fellows, $neededPower){

        $options = [];
        $memory = ['totalPower' => 0, 'fellows' => []];
        $bestSingleFellowPower = UserFellow::getLowestPowerAbove($neededPower);
        $bestChoise = ['totalPower' => 0, 'fellows' =>[], 'neededPower' => $neededPower * 1.1];
        $lowestPowerUsed = 0;
        if ($bestSingleFellowPower != null){
            $bestSingleFellowPower = $bestSingleFellowPower->toArray();
            $options[$bestSingleFellowPower['power']] = ['totalPower' => $bestSingleFellowPower['power'], 'fellows' => [$bestSingleFellowPower['id'] => $bestSingleFellowPower]];
            $this->getBestCoise($bestChoise, $options[$bestSingleFellowPower['power']], $neededPower);
        }
        foreach($fellows as $fellow){
            if ($fellow['power'] >= $neededPower){
                continue;
            }
            $lowestPowerUsed = $fellow['power'];
            $memory['totalPower'] += $fellow['power'];
            $memory['fellows'][$fellow['id']] = $fellow;

            $this->test4($options, $bestChoise, $memory, $fellows, $neededPower, $lowestPowerUsed);
            $this->emptyMemory($memory);
        }
        return ['options' => $options, 'best' => $bestChoise];
    }

    public function test4(&$options, &$bestChoise, $memory, $fellows, $neededPower, $lowestPowerUsed = 0, $depth = 0){
        if ($depth > 60){
            return;
        }
        if ($lowestPowerUsed == $fellows[array_key_last($fellows)]['power']){
            return;
        }
        $intMemory = $memory;
        if ($lowestPowerUsed > $neededPower - $memory['totalPower']){
            $lowestFellow = UserFellow::getLowestPowerBetween($lowestPowerUsed, $neededPower - $memory['totalPower']);
            if ($lowestFellow != null){
                $lowestFellow = $lowestFellow->toArray();
                $lowestPowerUsed = $lowestFellow['power'];
                $intMemory['totalPower'] += $lowestFellow['power'];
                $intMemory['fellows'][$lowestFellow['id']] = $lowestFellow;
                if ($intMemory['totalPower'] >= $neededPower){
                    // if ($intMemory['totalPower'] <= $neededPower * 1.01){
                    // if ($intMemory['totalPower'] <= $bestChoise['neededPower']){
                        $options[$intMemory['totalPower']] = $intMemory;
                        $this->getBestCoise($bestChoise, $intMemory, $neededPower);
                    // }
                    $intMemory = $memory;
                } else {
                    throw new Exception($intMemory);
                }
            }
        }
        foreach($fellows as $fellow){
            if ($fellow['power'] >= $lowestPowerUsed){
                continue;
            }
            $lowestPowerUsed = $fellow['power'];
            $intMemory['totalPower'] += $fellow['power'];
            $intMemory['fellows'][$fellow['id']] = $fellow;
            if ($intMemory['totalPower'] >= $neededPower){
                // $options[$intMemory['totalPower']] = $intMemory;
                // $intMemory = $memory;
                // return;
            } else {
                return $this->test4($options, $bestChoise, $intMemory, $fellows, $neededPower, $lowestPowerUsed, $depth + 1);
                $intMemory = $memory;
            }
        }
        return;
    }


    public function testPage(Request $request){
        $user = Auth::user();
        $input = $request->input();
        $sandtopia = Sandtopia::where('id', $input['sandtopia_id'])->where('user_id', $user->id)->first();
        $run_id = SandtopiaInstance::getRunId($input['new_run'] ?? false);
        $explorations = SandtopiaInstance::where('user_id', $user->id)->where('run_id', $run_id)->get();
        $usedFellows = $this->getUsedFellows($explorations);

        $unusedFellows = UserFellow::withFellow()->where('user_id', $user->id)->whereNotIn('id', $usedFellows)->orderBy('power', 'desc')->get();

        $neededPower = $sandtopia->parsePower();

        return view('test', compact('unusedFellows', 'neededPower'));
    }
}
