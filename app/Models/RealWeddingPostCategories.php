<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealWeddingPostCategories extends Model
{
    use HasFactory;
    protected $table = "real_wedding_categories_real_wedding_post";
    protected $fillable =  [
        "real_wedding_post_id",
        "real_wedding_categories_id"
    ];
}
