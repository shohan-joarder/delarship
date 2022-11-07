<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GalleryToLook extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "photo",
        "sort_order",
        "status",
    ];
}
