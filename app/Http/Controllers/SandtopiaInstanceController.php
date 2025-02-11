<?php

namespace App\Http\Controllers;

use App\Models\SandtopiaInstance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SandtopiaInstanceController extends Controller
{
    //

    public function index()
    {
        $sandtopia = SandtopiaInstance::withSandtopia()->where('user_id', Auth::user()->id)->get();
        return view('sandtopia');
    }
}
