<?php

namespace App\Http\Controllers;

use App\Http\Traits\PermissionTrait;
use App\Models\TujuanPenggunaan;
use Illuminate\Http\Request;

class TujuanPenggunaanController extends Controller
{
    use PermissionTrait;

    public function index()
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true || $this->checkPermission(auth()->user(), 'nav-content-management-access') == true) {
            $tujuan = TujuanPenggunaan::get();

            return response($tujuan, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function store(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'tujuan_penggunaan' => 'required|string'
            ]);

            $tujuan = TujuanPenggunaan::create($fields);
            return response($tujuan, 201);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function update(Request $request, $id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'tujuan_penggunaan' => 'required|string'
            ]);
            $tujuan = TujuanPenggunaan::where('id', $id)->first();
            if (!$tujuan) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $tujuan->tujuan_penggunaan = $fields['tujuan_penggunaan'];
            $tujuan->save();
            return response($tujuan, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function destroy($id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {

            $tujuan = TujuanPenggunaan::where('id', $id)->first();
            if (!$tujuan) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $tujuan->delete();
            return response([
                'Message' => 'Success',
            ], 201);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function deleteMulti(Request $request)
    {
        $ids = $request->input('id');
        foreach ($ids as $id) {
            try {
                $record = TujuanPenggunaan::find($id);
                $record->delete();
            } catch (\Throwable $th) {
            }
        }
        return response([
            'message' => 'Success'
        ], 200);
    }
}
