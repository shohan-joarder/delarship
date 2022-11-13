<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RealWeddingPost extends Model
{
    use Sluggable;
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        "wedding_category_id",
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
        "comments",
        "short_description",
        "publish_date",
        "seo_title",
        "seo_description",
        "seo_keywords"
    ];

    public function blogType()
    {
        return $this->belongstoMany(RealWeddingCategories::class);
    }

    public $statuslist = [1 => 'Published', 2 => 'Pending', 3 => 'Draft'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}