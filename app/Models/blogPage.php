<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class blogPage extends Model
{
    use HasFactory;
    protected $fillable = [
        "main_baner",
        "main_baner_title_1",
        "main_baner_title_2",
        "middle_banner",
        "middle_banner_content_1",
        "middle_banner_content_2",
        "bottom_banner",
        "bottom_banner_content_1",
        "bottom_banner_content_2",
        "blog_page_meta",
    ];
}
