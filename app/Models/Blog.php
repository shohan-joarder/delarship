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
        "auther_id",
        "created_by",
        "updated_by",
        "title",
        "slug",
        "description",
        "photo",
        "status",
        "tags",
        "featured",
        "comments"
    ];

    public function blogType()
    {
        return $this->belongstoMany(BlogTypes::class);
    }

    public $statuslist = [1 => 'Published', 2 => 'Pending', 2 => 'Draft'];
}
