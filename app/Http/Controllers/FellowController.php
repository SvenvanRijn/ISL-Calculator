<?php

namespace App\Http\Controllers;

use App\Models\Fellow;
use Illuminate\Http\Request;

class FellowController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function names(){
        $names = [
            "Fiffi",
            "Maxim",
            "Reir",
            "Pump",
            "Knivi",
            "Arake",
            "Mirac",
            "Boater",
            "Geast",
            "Björnson",
            "Guarg",
            "Woolf",
            "Hawker",
            "Rogile",
            "Belle",
            "Dr.Doctor",
            "Kaity",
            "Meaden",
            "Lincale",
            "Spipi",
            "Witty",
            "Rani",
            "Angie",
            "Denisa",
            "Brotein",
            "Grayce",
            "Liz",
            "Quenchy",
            "Cimitir",
            "Elise",
            "Adeline",
            "Avril",
            "Ira",
            "Super",
            "Avar",
            "Anne",
            "Salvo",
            "Trady",
            "Augustine",
            "Mescal",
            "Kaye",
            "Loya",
            "Emosen",
            "Jewlry",
            "Ida",
            "Lux",
            "Stephanie",
            "Mammon",
            "Acedie",
            "Nip",
            "Shlomo",
            "Paat",
            "Iori",
            "Tigirl",
            "Hermes",
            "Neptune",
            "Leon",
            "Orvita",
            "Amaterasu",
            "Sunny",
            "UR1",
            "UR2"
        ];
        foreach($names as $name ){
            $fellow = new Fellow;
            $fellow->name = $name;
            $fellow->save();
        }
        $fellows = Fellow::all();
        var_dump($fellows);
    }
}
