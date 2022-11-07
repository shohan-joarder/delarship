<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InHouseService extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "sub_title",
        "url",
        "button_text",
        "photo",
        "sort_order",
        "status"
    ];
}
