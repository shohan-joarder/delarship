<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogBlogCategory extends Model
{
    use HasFactory;
    protected $fillable = ["blog_id", "blog_catogory_id"];
    protected $table = "blogs_blog_category";
}
