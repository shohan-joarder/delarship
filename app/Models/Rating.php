<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "rate"
    ];

    public static function averageRatings($vendorId)
    {
        $data = self::where('rate_for', $vendorId)->pluck('rate');
        $averageRatings = 0;
        if ($data) {
            $averageRatings = array_sum($data) / count($data);
            $averageRatings = ceil($averageRatings);
        } else {
            $data = [];
        }

        return $averageRatings;
    }
}
