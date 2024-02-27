<?php

namespace App\Http\Controllers;

use App\Models\Monster;
use Illuminate\Http\Request;

class MonsterController extends Controller
{
    public function monsters(){
        $data = [
            "Rock baby" => 225000,
            "Rock elf" => 237000,
            "Fang Jieshi" => 322000,
            "The Fluorite Monster" => 345000,
            "Iron Latva" => 487000,
            "Iron Beetle" => 517000,
            "Coal Bat Bal" => 585000,
            "Great Coal Bat" => 787000,
            "Peacock stone moss frog" => 862000,
            "Peacock stone frog" => 975000,
            "Crabble" => 1240000,
            "Rock dwelling crab" => 1300000,
            "Crystal-tailed Scorpion" => 1570000,
            "Poison Crystal Scorpion" => 1950000,
            "Crystal Snake" => 2250000,
            "Crystal King Snake" => 2700000,
            "Ruby Lizard" => 3670000,
            "Ruby Rampage Dragon" => 3900000,
            "The Thief Mole" => 4570000,
            "Boss Mole" => 6070000,
            "Group of Rock monsters" => 6370000,
            "Feldspar Group" => 7500000,
            "Metal insect swarm" => 8770000,
            "Coal Bat Swarm" => 10800000,
            "Peacock stone frog group" => 13500000,
            "Rock Crab Group" => 15000000,
            "C" => 18000000,
            "Crystal Snake Swarm" => 21700000,
            "Ruby Lizard Swarm" => 23200000,
            "Mole Rat Group" => 31500000,
            "Rock Monster Squad" => 36700000,
            "Fangoite Squad" => 39700000,
            "Metal Bug Squad" => 49500000,
            "Coal Bat Team" => 60000000,
            "Peacock Stone Frog Team" => 78700000,
            "Team Rock Crab" => 90700000,
            "37" => 97500000,
            "Crystal Snake Squad" => 129000000,
        ];
        foreach($data as $name => $power){
            $monster = new Monster;
            $monster->name = $name;
            $monster->power = $power;
            $monster->save();
        }
        $monsters = Monster::all();
        dd($monsters);
    }
}
