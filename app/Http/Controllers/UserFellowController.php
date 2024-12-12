<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserFellowRequest;
use App\Models\Fellow;
use App\Models\UserFellow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFellowController extends Controller
{

    public function index(){
        $userFellows = UserFellow::where('user_id', Auth::user()->id)->withFellow()->get();
        $existingUserFellows = UserFellow::where('user_id', Auth::user()->id)->select('fellow_id');
        $fellows = Fellow::whereNotIn('id', $existingUserFellows)->orderBy('name')->get();
        return view('fellows', compact('userFellows', "fellows"));
    }

    public function temp(){
        $userFellows = UserFellow::where('user_id', Auth::user()->id)->select('fellow_id');
        $fellows = Fellow::whereNotIn('id',$userFellows)->orderBy('name')->get();
        return view('fellow_form', compact('fellows'));
    }

    public function create(Request $request){
        $input = $request->input();
        if (null !== UserFellow::where('fellow_id', $input['fellow_id'])->whereUser()->get()){
            return redirect()->back()->with('error', "Already added this fellow");
        }
        $userFellow = UserFellow::create([
            "fellow_id" => $input['fellow_id'],
            "user_id" => Auth::user()->id,
            "power" => $input['power'],
        ]);
        $fellow = Fellow::where('id', $input['fellow_id'])->first();
        return $this->index()->with('succes', "$fellow->name added with " . number_format($userFellow->power) . " power");
    }

    public function edit(Request $request){
        $input = $request->input();
        // dd($input);
        $userFellow = UserFellow::where('id', $input['id'])->first();
        $userFellow->power = $input['power'];
        // $userFellow->extra = $input['extra'];
        $userFellow->save();
        return $this->index();
    }

    public function apiCreate(CreateUserFellowRequest $request){
        
    }
}
