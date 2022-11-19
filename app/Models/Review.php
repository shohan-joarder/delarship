<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "review",
        "review_by"
    ];

    public function user()
    {
        return $this->hasOne(User::class);
    }
}
