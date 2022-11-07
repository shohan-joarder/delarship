<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogTypes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function edit($id)
    {
        $data = Blog::find($id);
        $photo = asset($data->photo);
        return response()->json(["data" => $data, "photo" => $photo]);
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
}
