<?php

namespace App\Http\Controllers;

use App\Models\blogPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogPageController extends Controller
{
    public function index()
    {
        $data = [];
        $data["title"] = "Blog page";
        $data["allData"] = blogPage::first();
        if (!$data["allData"]) {
            blogPage::create([]);
        }
        return view('blog-section.blog-page.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "main_baner" => 'required',
            "main_baner_title_1" => 'required',
            "main_baner_title_2" => 'required',
            "middle_banner" => 'required',
            "middle_banner_content_1" => 'required',
            "middle_banner_content_2" => 'required',
            "bottom_banner" => 'required',
            "bottom_banner_content_1" => 'required',
            "bottom_banner_content_2" => 'required',
            "blog_page_meta" => "string"
        ]);
        $data = [];
        $data["status"] = false;
        if ($validator->fails()) {
            $data["errors"] = $validator->errors();
            return response()->json($data);
        } else {
            $validData = $validator->validated();

            $mainBanner = $request->main_baner;
            $mainBannerArr = explode('/storage', $mainBanner);
            $mainBannerData = 'storage' . $mainBannerArr[1];
            $validData["main_baner"] = $mainBannerData;

            $middleBanner = $request->middle_banner;
            $middleBannerArr = explode('/storage', $middleBanner);
            $middleBannerData = 'storage' . $middleBannerArr[1];
            $validData["middle_banner"] = $middleBannerData;

            $bottomBanner = $request->bottom_banner;
            $bottomBannerArr = explode('/storage', $bottomBanner);
            $bottomBannerData = 'storage' . $bottomBannerArr[1];
            $validData["bottom_banner"] = $bottomBannerData;

            blogPage::first()->update($validData);
            $data = [];
            $data["status"] = true;
            $data["message"] = "Blog page data updated successfully";
            return response()->json($data);
        }
    }
}
