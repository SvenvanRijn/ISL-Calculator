<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SandtopiaInstance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sandtopia_id',
        'run_id',
        'fellows'
    ];

    /**
     * Returns the current run ID for the user, or the next run ID if $new is true.
     *
     * @param bool $new
     * @return int
     */
    public static function getRunId($new = false){
        $run = SandtopiaInstance::select('run_id')->where('user_id', Auth::user()->id)->orderBy('run_id', 'desc')->first();
        return $new ? $run->run_id + 1 : $run->run_id ?? 1;
    }

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
