<?php

namespace App\Http\Controllers;

use App\Models\RealWeddingCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RealWeddingCategoriesController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $info = RealWeddingCategories::where('id', '!=', '');

            if ($request->search['value'] != '') {
                $info = $info->where(function ($query) use ($request) {
                    $query->orWhere('title', 'LIKE', '%' . $request->search['value'] . '%')
                        ->orWhere('sort_order', 'LIKE', '%' . $request->search['value'] . '%');
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
                    'edit' => route('real-wedding-category.edit', $row->id),
                    'delete' => route('real-wedding-category.delete', $row->id),
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
        $data["title"] = "Real wedding categories";
        return view('real-wedding-section.categories.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'    => 'required',
            'sort_order' => 'required',
        ]);
        $data = [];
        $data["status"] = false;
        if ($validator->fails()) {
            $data["errors"] = $validator->errors();
            return response()->json($data);
        } else {
            if ($request->id) {
                if (RealWeddingCategories::find($request->id)->update($validator->validated())) {
                    $data["status"] = true;
                    $data["message"] = "Real wedding category updated successfully";
                    return response()->json($data);
                }
            } else {
                RealWeddingCategories::create($validator->validated());
                $data["status"] = true;
                $data["message"] = "Real wedding category added successfully";
                return response()->json($data);
            }
        }
    }

    public function edit($id)
    {
        $data = RealWeddingCategories::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        if ($id) {
            RealWeddingCategories::find($id)->delete();
            return response()->json(["status" => true, "message" => "Deleted successfully"]);
        } else {
            return response()->json(["status" => false, "message" => "Something went wrong"]);
        }
    }
}
