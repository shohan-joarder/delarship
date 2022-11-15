<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorPortfolio extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "title",
        "photo",
        "album",
        "status"
    ];
}
