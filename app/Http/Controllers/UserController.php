<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function vendors(Request $request)
    {
        if ($request->ajax()) {
            $info = User::where('role', '=', 2);

            if ($request->search['value'] != '') {
                $info = $info->where(function ($query) use ($request) {
                    $query->orWhere('full_name', 'LIKE', '%' . $request->search['value'] . '%')
                        ->orWhere('email', 'LIKE', '%' . $request->search['value'] . '%')
                        ->orWhere('phone', 'LIKE', '%' . $request->search['value'] . '%');
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
                    'title' => $row->full_name,
                    'email' => $row->email,
                    'phone' => $row->phone,
                    'status' => $row->status,
                    'verified' => $row->email_verified_at,
                    'updated_at' => $row->updated_at
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
        $data["title"] = "All Vendors";
        return view('users.vendors', $data);
    }
    public function users(Request $request)
    {
        if ($request->ajax()) {
            $info = User::where('role', 3);

            if ($request->search['value'] != '') {
                $info = $info->where(function ($query) use ($request) {
                    $query->orWhere('full_name', 'LIKE', '%' . $request->search['value'] . '%')
                        ->orWhere('email', 'LIKE', '%' . $request->search['value'] . '%')
                        ->orWhere('phone', 'LIKE', '%' . $request->search['value'] . '%');
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
                    'title' => $row->full_name,
                    'email' => $row->email,
                    'phone' => $row->phone,
                    'status' => $row->status,
                    'verified' => $row->email_verified_at,
                    'updated_at' => $row->updated_at
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
        $data["title"] = "All Users";
        return view('users.all-users', $data);
    }

    public function changeStatus(Request $request)
    {
        $id = $request->id;
        $updateStatus = User::find($id);
        $updateStatus->status = ($updateStatus->status == 1) ? false : true;
        $updateStatus->save();
        return response()->json(['status' => 'success', 'message' => "Status changed successfully."]);
    }
}
