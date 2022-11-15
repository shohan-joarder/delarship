<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        "user_id",
        "website_link",
        "facebook_link",
        "instagram_link",
        "youtube_url",
        "additional_information",
        "address",
        "additional_details"
    ];
}
