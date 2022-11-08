<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Models\Blog;
use App\Models\BlogBlogCategory;
use App\Models\BlogTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Closure;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $info = Blog::where('id', '!=', '');

            if ($request->search['value'] != '') {
                $info = $info->where(function ($query) use ($request) {
                    $query->orWhere('title', 'LIKE', '%' . $request->search['value'] . '%')
                        ->orWhere('description', 'LIKE', '%' . $request->search['value'] . '%');
                });
            }

            if ($request->order['0']['column'] != '') {
                if ($request->order['0']['column'] == 2) {
                    $col = 'updated_at';
                }
                $info = $info->orderBy('updated_at', $request->order['0']['dir']);
            }

            $count = $info->count();
            $data = [];
            $alldata = $info->with('blogType')->offset($request->start)->limit($request->length)->get();

            foreach ($alldata as $row) :
                $data[] = [
                    'id' => $row->id,
                    'type' => $row->blogType->title,
                    'description' => $row->description,
                    'image' => '<img class="img-container img-flid" src="' . asset("$row->photo") . '" alt="" style="max-width:250px">',
                    'edit' => route('blog.edit', $row->id),
                    'delete' => route('blog.delete', $row->id),
                    'title' => $row->title,
                    'sort_order' => $row->sort_order,
                    'status' => $row->status,
                    'updated_at' => $row->updated_at,
                ];
            endforeach;
            $this->return = [
                "draw" => $request->draw,
                "recordsTotal" => $count,
                "recordsFiltered" => $count,
                "data" => $data,
            ];
            return response()->json($this->return);
        }
        $data = [];
        $data["title"] = "Blog";
        $data['category'] = BlogTypes::pluck("title", 'id');
        return view('blog-section.blog.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'    => 'required',
            'description' => 'required',
            'photo' => 'required',
            'blog_category_id' => 'required'
        ], [
            'blog_category_id.required' => "Blog category is required"
        ]);
        $data = [];
        $data["status"] = false;
        if ($validator->fails()) {
            $data["errors"] = $validator->errors();
            return response()->json($data);
        } else {
            $validData = $validator->validated();
            $photo = $request->photo;
            $photoArr = explode('/storage', $photo);
            $photoData = 'storage' . $photoArr[1];
            $validData["photo"] = $photoData;
            if ($request->id) {
                $validData["updated_by"] = auth()->user()->id;
                Blog::find($request->id)->update($validData);
                $data["status"] = true;
                $data["message"] = "Blog updated successfully";
                return response()->json($data);
            } else {
                $validData["created_by"] = auth()->user()->id;
                Blog::create($validData);
                $data["status"] = true;
                $data["message"] = "Blog added successfully";

                return response()->json($data);
            }
        }
    }

    public function create()
    {
        $data = [];
        $data["title"] = "Create new blog";
        $data["model"] = new Blog();
        $data["categoty"] = BlogTypes::pluck('title', 'id');
        $data["authors"] = Author::pluck('name', 'id');
        $data["blogCatagories"] = [];
        return view('blog-section.blog.create', $data);
    }

    public function edit($id)
    {
        $data = [];
        $data["title"] = "Update blog";
        $data["model"] = Blog::find($id);
        $data["categoty"] = BlogTypes::pluck('title', 'id');
        $data["authors"] = Author::pluck('name', 'id');
        $data["blogCatagories"]  = json_decode($data["model"]->blog_category_id);
        return view('blog-section.blog.create', $data);
        // return response()->json(["data" => $data, "photo" => $photo]);
    }

    public function destroy($id)
    {
        if ($id) {
            Blog::find($id)->delete();
            return response()->json(["status" => true, "message" => "Deleted successfully"]);
        } else {
            return response()->json(["status" => false, "message" => "Something went wrong"]);
        }
    }

    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'    => 'required',
            'description' => 'required',
            'photo' => 'required',
            'status' => 'required',
            'tags' => 'required',
            // 'featured' => 'boolean',
            // 'comments' => 'boolean',
            'auther_id' => 'required',
            'blog_category_id' => 'required'
        ], [
            'blog_category_id.required' => "Blog category is required",
            'auther_id.required' => "Auther is required"
        ]);
        $data = [];
        $data["status"] = false;
        if ($validator->fails()) {
            $data["errors"] = $validator->errors();

            return response()->json($data);
        } else {
            // dd($request->featured);
            $validData = $validator->validated();
            $validData["featured"] = ($request->featured == "true") ? 1 : 0;
            $validData["comments"] = ($request->comments == "true") ? 1 : 0;

            $photo = $request->photo;
            $photoArr = explode('/storage', $photo);
            $photoData = 'storage' . $photoArr[1];
            $validData["photo"] = $photoData;
            $validData["blog_category_id"] = json_encode($request->blog_category_id);

            DB::beginTransaction();

            if ($request->id) {
                $blogId = $request->id;
                Blog::find($blogId)->update($validData);
                BlogBlogCategory::where('blog_id', $blogId)->delete();
                $data["message"] = "Blog updated successfully";
            } else {
                $storeBlog = Blog::create($validData);
                $blogId = $storeBlog->id;
                $data["message"] = "Blog added successfully";
            }
            if ($blogId) {
                // insert data into prevot table
                foreach ($request->blog_category_id as $key => $value) {
                    BlogBlogCategory::create(['blog_id' => $blogId, 'blog_catogory_id' => $value]);
                }

                DB::commit();
                $data["status"] = true;
                return response()->json($data);
            } else {
                DB::rollback();
                return response()->json(['status' => false, 'message' => "Something went wrong"]);
            }
        }
        // dd($request->all());
    }
}
