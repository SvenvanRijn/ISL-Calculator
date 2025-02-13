<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sandtopia extends Model
{
    use HasFactory;

    protected $table = 'sandtopia';

    static $rewards = [
        '10',
        '40',
        '50',
        '60',
        '75',
        '100',
        '300'
    ];

    static $abreviations = [
        'b' => 1000000000,
        'B' => 1000000000,
        'b' => 1000000000,
        'b' => 1000000000,
        'b' => 1000000000,
        'b' => 1000000000,
    ];

    protected $fillable = [
        'user_id',
        'reward',
        'power',
    ];

    /**
     * returns this->power as an integer
     * 
     * @return int
     */
    public function parsePower(){
        $multiplier = 1;

        // Check the last character for a unit
        $unit = strtoupper(substr($this->power, -1));
        if (!is_numeric($unit)) {
            // Remove the unit from the input
            $number = floatval(substr($this->power, 0, -1));

            switch ($unit) {
                case 'K':
                    $multiplier = 1_000;
                    break;
                case 'M':
                    $multiplier = 1_000_000;
                    break;
                case 'B':
                    $multiplier = 1_000_000_000;
                    break;
                case 'T':
                    $multiplier = 1_000_000_000_000;
                    break;
                default:
                    break;
            }
        } else {
            $number = floatval($this->power);
        }

        // Multiply and return as a string
        return (int)($number * $multiplier);
    }

}
