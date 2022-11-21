<?php

namespace App\Http\Controllers;

use App\Models\BlogAuthor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogAuthorController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $info = BlogAuthor::where('id', '!=', '');

            if ($request->search['value'] != '') {
                $info = $info->where(function ($query) use ($request) {
                    $query->orWhere('name', 'LIKE', '%' . $request->search['value'] . '%')
                        ->orWhere('sort_order', 'LIKE', '%' . $request->search['value'] . '%');
                    // ->orWhere('order_date', 'LIKE', '%' . date("Y-m-d", strtotime($request->search['value'])) . '%')
                    // ->orWhere('payment_status', 'LIKE', '%' . $request->search['value'] . '%')
                    // ->orWhere('status', 'LIKE', '%' . $request->search['value'] . '%');
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
            $alldata = $info->offset($request->start)->limit($request->length)->get();
            foreach ($alldata as $row) :
                $data[] = [
                    'id' => $row->id,
                    'edit' => route('blog-author.edit', $row->id),
                    'delete' => route('blog-author.delete', $row->id),
                    'title' => $row->name,
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
        $data["title"] = "Blog Author";
        return view('blog-section.author.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'    => 'required',
            // 'sort_order' => 'required',
        ]);
        $data = [];
        $data["status"] = false;
        if ($validator->fails()) {
            $data["errors"] = $validator->errors();
            return response()->json($data);
        } else {
            if ($request->id) {
                if (BlogAuthor::find($request->id)->update($validator->validated())) {
                    $data["status"] = true;
                    $data["message"] = "Blog author updated successfully";
                    return response()->json($data);
                }
            } else {
                BlogAuthor::create($validator->validated());
                $data["status"] = true;
                $data["message"] = "Blog author added successfully";
                return response()->json($data);
            }
        }
    }

    public function edit($id)
    {
        $data = BlogAuthor::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        if ($id) {
            BlogAuthor::find($id)->delete();
            return response()->json(["status" => true, "message" => "Deleted successfully"]);
        } else {
            return response()->json(["status" => false, "message" => "Something went wrong"]);
        }
    }
}
