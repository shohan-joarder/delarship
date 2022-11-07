<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PopularVanues extends Model
{
    use HasFactory;

    protected $fillable = [
        "photo",
        "title",
        "description",
        "location",
        "sort_order"
    ];
}
