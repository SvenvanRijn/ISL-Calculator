<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SandtopiaInstance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sandtopia_id',
        'run_id',
        'fellows'
    ];

    public function sandtopia(){
        return $this->belongsTo(Sandtopia::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function scopeWithSandtopia($query){
        return $query->with('sandtopia');
    }
}
