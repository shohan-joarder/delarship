<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\RealWeddingAuthor;
use App\Models\RealWeddingCategories;
use App\Models\RealWeddingPage;
use App\Models\RealWeddingPost;
use Illuminate\Http\Request;

class RealWeddingController extends Controller
{
    public function index($limit = 10, $page = 1)
    {
        $data = RealWeddingPost::with(['category', 'author'])->where('status', 1)->orderBy('sort_order')->paginate($limit);
        if (!$data) {
            return response()->json(['status' => "success", 'data' => "No blog found!"]);
        }
        return response()->json(['status' => "success", 'data' => $data]);
    }

    public function page()
    {
        $data = RealWeddingPage::first();
        return response()->json(['status' => "success", 'data' => $data]);
    }

    public function show($slug)
    {
        $data = RealWeddingPost::with(['category', 'author'])->where('slug', $slug)->first();
        if (!$data) {
            return response()->json(['status' => "success", 'data' => "No blog found!"]);
        }
        return response()->json(['status' => "success", 'data' => $data]);
    }
    public function author()
    {
        $data = RealWeddingAuthor::orderBy('name')->get();
        if (!$data) {
            return response()->json(['status' => "success", 'message' => "No author found!"]);
        }
        return response()->json(['status' => "success", 'data' => $data]);
    }
    public function category()
    {
        $data = RealWeddingCategories::where('status', 1)->orderBy('order_by')->get();
        if (!$data) {
            return response()->json(['status' => "success", 'message' => "No author found!"]);
        }
        return response()->json(['status' => "success", 'data' => $data]);
    }
}
