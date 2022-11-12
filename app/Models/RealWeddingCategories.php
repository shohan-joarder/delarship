<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealWeddingCategories extends Model
{
    use HasFactory;
    protected $fillable = [
        "title",
        "status",
        "sort_order"
    ];

    public function realWeedingPost()
    {
        return $this->belongstoMany(RealWeddingPost::class);
    }
}
