<?php

namespace App\Http\Controllers;

use App\Models\GalleryToLook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GalleryToLookController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $info = GalleryToLook::where('id', '!=', '');

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
                    'title' => $row->title,
                    'sort_order' => $row->sort_order,
                    'status' => $row->status,
                    'image' => '<img class="img-container img-flid" src="' . asset("$row->photo") . '" alt="" style="max-width:250px">',
                    'updated_at' => $row->updated_at,
                    'edit' => route('gallery-to-look.edit', $row->id),
                    'delete' => route('gallery-to-look.delete', $row->id),
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
        $data["title"] = "Gallery to look";
        return view('home-section.gallery-to-look.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'    => 'required',
            'photo' => 'required',
            'sort_order' => $request->id ? 'required' : 'required|unique:gallery_to_looks'
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
                GalleryToLook::find($request->id)->update($validData);
                $data["status"] = true;
                $data["message"] = "Gallery updated successfully";
                return response()->json($data);
            } else {
                GalleryToLook::create($validData);
                $data["status"] = true;
                $data["message"] = "Gallery added successfully";
                return response()->json($data);
            }
        }
    }

    public function edit($id)
    {
        $data = GalleryToLook::find($id);
        $photo = asset($data->photo);
        return response()->json(["data" => $data, "photo" => $photo]);
    }

    public function destroy($id)
    {
        if ($id) {
            GalleryToLook::find($id)->delete();
            return response()->json(["status" => true, "message" => "Deleted successfully"]);
        } else {
            return response()->json(["status" => false, "message" => "Something went wrong"]);
        }
    }
}
