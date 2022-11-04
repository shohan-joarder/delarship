<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        "blog_category_id",
        "created_by",
        "updated_by",
        "title",
        "description",
        "photo",
        "status"
    ];

    public function blogType()
    {
        return $this->hasOne(BlogTypes::class, 'id', 'blog_category_id');
    }
}
