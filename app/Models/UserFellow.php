<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class UserFellow extends Model
{
    use HasFactory;

    public $table = 'user_fellows';

    public $fillable = [
        'fellow_id',
        'user_id',
        'power',
        'extra',
    ];

    public function fellow(){
        return $this->belongsTo(Fellow::class, 'fellow_id', 'id');
    }

    public function scopeWhereUser(){
        return $this->where('user_id', Auth::user()->id);
    }
}
