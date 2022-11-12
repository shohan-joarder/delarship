<?php

namespace App\Http\Controllers;

use App\Models\RealWeddingAuthor;
use App\Models\RealWeddingCategories;
use App\Models\RealWeddingPost;
use App\Models\RealWeddingPostCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RealWeddingPostController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $info = RealWeddingPost::where('id', '!=', '');

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
                $categoty = '';
                foreach ($row->blogType as $key => $value) {
                    $categoty .= $value->title . ", ";
                };
                $tags = '';
                $tagsArr = json_decode($row->tags);
                foreach ($tagsArr as $k => $tag) {
                    $tags .= $tag->value . ", ";
                }

                $categoty =  substr($categoty, 0, -2);
                $tags = substr($tags, 0, -2);

                $description = (strlen($row->description) > 50) ? substr($row->description, 0, 50) . "...."  : $row->description;

                $data[] = [
                    'id' => $row->id,
                    'type' => $categoty,
                    'description' => $description,
                    'image' => '<img class="img-container img-flid" src="' . asset("$row->photo") . '" alt="" style="max-width:250px">',
                    'edit' => route('real-wedding.edit', $row->id),
                    'delete' => route('real-wedding.delete', $row->id),
                    'title' => $row->title,
                    'tags' => $tags,
                    'sort_order' => $row->sort_order,
                    'created_at' => $row->created_at->diffForHumans(),
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
        $data["title"] = "Real Wedding";
        return view('real-wedding-section.wedding.index', $data);
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
                RealWeddingPost::find($request->id)->update($validData);
                $data["status"] = true;
                $data["message"] = "Blog updated successfully";
                return response()->json($data);
            } else {
                $validData["created_by"] = auth()->user()->id;
                RealWeddingPost::create($validData);
                $data["status"] = true;
                $data["message"] = "Blog added successfully";

                return response()->json($data);
            }
        }
    }

    public function create()
    {
        $data = [];
        $data["title"] = "Create new wedding";
        $data["model"] = new RealWeddingPost();
        $data["categoty"] = RealWeddingCategories::pluck('title', 'id');
        $data["authors"] = RealWeddingAuthor::pluck('name', 'id');
        $data["blogCatagories"] = [];
        return view('real-wedding-section.wedding.create', $data);
    }

    public function edit($id)
    {
        $data = [];
        $data["title"] = "Update wedding";
        $data["model"] = RealWeddingPost::find($id);
        $data["categoty"] = RealWeddingCategories::pluck('title', 'id');
        $data["authors"] = RealWeddingAuthor::pluck('name', 'id');
        $data["blogCatagories"]  = json_decode($data["model"]->wedding_category_id);
        return view('real-wedding-section.wedding.create', $data);
    }

    public function destroy($id)
    {
        if ($id) {
            RealWeddingPost::find($id)->delete();
            return response()->json(["status" => true, "message" => "Deleted successfully"]);
        } else {
            return response()->json(["status" => false, "message" => "Something went wrong"]);
        }
    }

    public function save(Request $request)
    {
        // dd(gettype($request->seo_title));
        $validator = Validator::make($request->all(), [
            'title'    => ($request->id) ? 'required|max:150|unique:real_wedding_posts,title,' . $request->id : 'required|unique:blogs|max:150',
            'description' => 'required',
            'photo' => 'required',
            'status' => 'required',
            'tags' => 'required',
            'auther_id' => 'required',
            'wedding_category_id' => 'required',
            'short_description' => 'required',
            // 'publish_date' => 'required',
            'seo_title' => 'max:120',
            'seo_description' => 'max:160',
            'seo_keywords' => 'max:160',
        ], [
            'wedding_category_id.required' => "Wedding category is required",
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
            $validData["publish_date"] = ($request->publish_date) ? $request->publish_date : date('Y-m-d h:i:s');

            $photo = $request->photo;
            $photoArr = explode('/storage', $photo);
            $photoData = 'storage' . $photoArr[1];
            $validData["photo"] = $photoData;
            $validData["wedding_category_id"] = json_encode($request->wedding_category_id);

            DB::beginTransaction();
            if ($request->id) {
                $blogId = $request->id;
                RealWeddingPost::find($blogId)->update($validData);
                RealWeddingPostCategories::where('real_wedding_post_id', $blogId)->delete();
                $data["message"] = "Real wedding updated successfully";
            } else {
                $storeBlog = RealWeddingPost::create($validData);
                $blogId = $storeBlog->id;
                $data["message"] = "Real wedding added successfully";
            }
            if ($blogId) {
                // insert data into prevot table
                foreach ($request->wedding_category_id as $key => $value) {
                    RealWeddingPostCategories::create(['real_wedding_post_id' => $blogId, 'real_wedding_categories_id' => $value]);
                }

                DB::commit();
                $data["status"] = true;
                return response()->json($data);
            } else {
                DB::rollback();
                return response()->json(['status' => false, 'message' => "Something went wrong"]);
            }
        }
    }

    public function validation(Request $request)
    {
        if (isset($_GET['title'])) {
            $titleLength = strlen($_GET['title']);
            return response()->json("Remains only " . 150 - $titleLength . " charecter");
        }
    }

    public function slugGenerator(Request $request)
    {
        return Str::slug($request->title);
    }
}
