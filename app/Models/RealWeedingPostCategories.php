<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealWeedingPostCategories extends Model
{
    use HasFactory;
    protected $table = "real_weeding_categories_real_weeding_post";
    protected $fillable =  [
        "real_weeding_post_id",
        "real_weeding_categories_id"
    ];
}
