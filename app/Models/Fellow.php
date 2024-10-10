<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fellow extends Model
{
    use HasFactory;

    public $table = 'fellows';

    public function userFellows(){
        return $this->hasMany(UserFellow::class);
    }
}
