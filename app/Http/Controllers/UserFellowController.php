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
        $userFellows = UserFellow::where('user_id', Auth::user()->id)->withFellow()->orderBy('power', 'desc')->get();
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

    public function apiEdit(Request $request){
        $input = $request->input();
        // dd($input);
        $userFellow = UserFellow::where('id', $input['id'])->first();
        $userFellow->power = $input['power'];
        // $userFellow->extra = $input['extra'];
        $userFellow->save();
        return response()->json([
            'message' => "fellow changed to " . number_format($userFellow->power) . " power",
            'power' => $userFellow->power,
            'id' => $userFellow->id,
        ]);
    }

    public function apiCreate(Request $request){
        $input = $request->input();
        if (null !== UserFellow::where('fellow_id', $input['fellow_id'])->whereUser()->first()){
            // return print_r($input, true);
            return response()->json(['msg' => "Already added this Fellow"], 400);
        }
        $userFellow = UserFellow::create([
            "fellow_id" => $input['fellow_id'],
            "user_id" => Auth::user()->id,
            "power" => $input['power'],
        ]);
        $fellow = Fellow::where('id', $input['fellow_id'])->first();
        return response()->json([
            'id' => $userFellow->id, 
            'power' => $userFellow->power, 
            'fellow_id' => $fellow->id, 
            'name' => $fellow->name, 
            "img_src" => $fellow->img_src,
            'message' => "$fellow->name added with " . number_format($userFellow->power) . " power",
        ]);
    }

    public function massEdit(){
        $userFellows = UserFellow::where('user_id', Auth::user()->id)->withFellow()->orderBy('power', 'desc')->get();
        return view('mass_edit', compact('userFellows'));
    }

    public function massUpdate(Request $request){

        $input = $request->all();

        foreach($input['fellow'] as $fellow_id => $power){
            $userFellow = UserFellow::where('id', $fellow_id)->first();
            $userFellow->power = $power;
            $userFellow->save();
        }
        
        return redirect(route('my-fellows'));
    }
}
