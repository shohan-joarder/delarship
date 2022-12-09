<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $info = Product::where('id', '!=', '');

            if ($request->search['value'] != '') {
                $info = $info->where(function ($query) use ($request) {
                    $query->orWhere('title', 'LIKE', '%' . $request->search['value'] . '%');
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
                    'edit' => route('product.edit', $row->id),
                    'delete' => route('product.delete', $row->id),
                    'title' => $row->product_name,
                    'sales_price' => $row->sales_price,
                    'quantity' => $row->quantity,
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
        $data["title"] = "Product";
        return view('product.index', $data);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_name'    => 'required',
            'quantity'    => 'required',
            'sales_price' => 'required',
        ]);
        $data = [];
        $data["status"] = false;
        if ($validator->fails()) {
            $data["errors"] = $validator->errors();
            return response()->json($data);
        } else {
            if ($request->id) {
                if (Product::find($request->id)->update($validator->validated())) {
                    $data["status"] = true;
                    $data["message"] = "Product updated successfully";
                    return response()->json($data);
                }
            } else {
                Product::create($validator->validated());
                $data["status"] = true;
                $data["message"] = "Product added successfully";
                return response()->json($data);
            }
        }
    }

    public function edit($id)
    {
        $data = Product::find($id);
        return response()->json($data);
    }

    public function destroy($id)
    {
        if ($id) {
            Product::find($id)->delete();
            return response()->json(["status" => true, "message" => "Deleted successfully"]);
        } else {
            return response()->json(["status" => false, "message" => "Something went wrong"]);
        }
    }
}
