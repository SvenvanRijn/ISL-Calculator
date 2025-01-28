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

    public function scopeWhereUser($query){
        return $query->where('user_id', Auth::user()->id);
    }

    public function scopeWithFellow(){
        return $this->select('user_fellows.*', 'fellows.*')->join('fellows', 'fellows.id', '=', 'fellow_id');
    }
}
