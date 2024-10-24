<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserFellowRequest;
use App\Models\Fellow;
use App\Models\UserFellow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserFellowController extends Controller
{

    public function temp(){
        $userFellows = UserFellow::where('user_id', Auth::user()->id)->withFellow()->get();
        return view('fellows', compact('userFellows'));
    }

    public function index(){
        $userFellows = UserFellow::where('user_id', Auth::user()->id)->select('fellow_id');
        $fellows = Fellow::whereNotIn('id',$userFellows)->orderBy('name')->get();
        return view('fellow_form', compact('fellows'));
    }

    public function create(Request $request){
        $input = $request->input();
        $userFellow = UserFellow::create([
            "fellow_id" => $input['fellow_id'],
            "user_id" => Auth::user()->id,
            "power" => $input['power'],
        ]);
        $fellow = Fellow::where('id', $input['fellow_id'])->first();
        return redirect('add-fellow')->with('succes', "$fellow->name added with " . number_format($userFellow->power) . " power");
    }

    public function edit(Request $request){
        $input = $request->input();
        $userFellow = UserFellow::where('id', $input['id'])->first();
        $userFellow->power = $input['power'];
        $userFellow->save();
        return $this->temp();
    }

    public function apiCreate(CreateUserFellowRequest $request){
        
    }
}
