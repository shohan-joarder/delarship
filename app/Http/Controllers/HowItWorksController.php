<?php

namespace App\Http\Controllers;

use App\Models\HowItWorks;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class HowItWorksController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $info = HowItWorks::where('id', '!=', '');

            if ($request->search['value'] != '') {
                $info = $info->where(function ($query) use ($request) {
                    $query->orWhere('title', 'LIKE', '%' . $request->search['value'] . '%')
                        ->orWhere('sort_order', 'LIKE', '%' . $request->search['value'] . '%')
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
            $alldata = $info->offset($request->start)->limit($request->length)->get();
            foreach ($alldata as $row) :
                $data[] = [
                    'id' => $row->id,
                    'title' => $row->title,
                    'description' => $row->description,
                    'sort_order' => $row->sort_order,
                    'status' => $row->status,
                    'updated_at' => $row->updated_at,
                    'edit' => route('how-it-works.edit', $row->id),
                    'delete' => route('how-it-works.delete', $row->id),
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
        $data["title"] = "How it works";
        return view('home-section.how-it-works-section.index');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'    => 'required',
            'description' => 'required',
            'sort_order' => $request->id ? 'required' : 'required|unique:how_it_works'
        ]);
        $data = [];
        $data["status"] = false;
        if ($validator->fails()) {
            $data["errors"] = $validator->errors();
            return response()->json($data);
        } else {
            $validData = $validator->validated();
            if ($request->id) {
                HowItWorks::find($request->id)->update($validData);
                $data["status"] = true;
                $data["message"] = "Work step updated successfully";
                return response()->json($data);
            } else {
                HowItWorks::create($validData);
                $data["status"] = true;
                $data["message"] = "Work step added successfully";
                return response()->json($data);
            }
        }
    }

    public function edit($id)
    {
        $data = HowItWorks::find($id);
        $photo = asset($data->photo);
        return response()->json($data);
    }

    public function destroy($id)
    {
        if ($id) {
            HowItWorks::find($id)->delete();
            return response()->json(["status" => true, "message" => "Deleted successfully"]);
        } else {
            return response()->json(["status" => false, "message" => "Something went wrong"]);
        }
    }
}
