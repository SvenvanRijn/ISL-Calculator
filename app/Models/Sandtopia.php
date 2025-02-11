<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sandtopia extends Model
{
    use HasFactory;

    protected $table = 'sandtopia';

    static $rewards = [
        10,
        40,
        50,
        60,
        75,
        100,
        300
    ];

    protected $fillable = [
        'user_id',
        'reward',
        'power',
    ];
}
