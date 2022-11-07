<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MiddleBanner extends Model
{
    use HasFactory;
    protected $fillable = [
        "title",
        "photo",
        "sort_order",
        "status"
    ];
}
