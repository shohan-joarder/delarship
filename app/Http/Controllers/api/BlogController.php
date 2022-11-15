<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\blogPage;
use App\Models\BlogTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    public function index($limit = 10, $page = 1)
    {
        $data = Blog::with(['category', 'author'])->where('status', 1)->orderBy('sort_order')->paginate($limit);
        if (!$data) {
            return response()->json(['status' => "success", 'data' => "No blog found!"]);
        }
        return response()->json(['status' => "success", 'data' => $data]);
    }

    public function page()
    {
        $data = blogPage::first();
        return response()->json(['status' => "success", 'data' => $data]);
    }

    public function show($slug)
    {
        $data = Blog::with(['category', 'author'])->where('slug', $slug)->first();
        if (!$data) {
            return response()->json(['status' => "success", 'data' => "No blog found!"]);
        }
        return response()->json(['status' => "success", 'data' => $data]);
    }
    public function author()
    {
        $data = Auth::orderBy('name')->get();
        if (!$data) {
            return response()->json(['status' => "success", 'message' => "No author found!"]);
        }
        return response()->json(['status' => "success", 'data' => $data]);
    }
    public function category()
    {
        $data = BlogTypes::where('status', 1)->orderBy('order_by')->get();
        if (!$data) {
            return response()->json(['status' => "success", 'message' => "No author found!"]);
        }
        return response()->json(['status' => "success", 'data' => $data]);
    }
}
