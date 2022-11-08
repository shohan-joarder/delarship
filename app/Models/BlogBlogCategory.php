<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogBlogCategory extends Model
{
    use HasFactory;
    protected $fillable = ["blog_id", "blog_types_id"];
    protected $table = "blog_blog_types";
}
