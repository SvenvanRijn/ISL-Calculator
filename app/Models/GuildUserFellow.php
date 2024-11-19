<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class GuildUserFellow extends Model
{
    use HasFactory;

    public $table = 'guild_user_fellows';

    public $fillable = [
        'user_id',
        'power',
        'name',
    ];

    public function scopeWhereUser(){
        return $this->where('user_id', Auth::user()->id);
    }
}
