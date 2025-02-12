<?php

namespace App\Http\Controllers;

use App\Models\Sandtopia;
use App\Models\SandtopiaInstance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SandtopiaInstanceController extends Controller
{
    //

    public function index(){

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
        $run_id = SandtopiaInstance::getRunId($input['new_run']);
        $explorations = SandtopiaInstance::where('user_id', $user->id)->where('run_id', $run_id)->first();
        $sandtopiaInstance = new SandtopiaInstance;
        $sandtopiaInstance->user_id = Auth::user()->id;
        $sandtopiaInstance->sandtopia_id = $sandtopia->id;
        $sandtopiaInstance->run_id = $run_id;
        $sandtopiaInstance->save();

        // dd($explorations);
        return redirect()->route('explore-sandtopia');
    }
}
