<?php

namespace App\Http\Controllers;

use App\Http\Traits\PermissionTrait;
use App\Models\Wilayah;
use Carbon\Carbon;
use Illuminate\Http\Request;

class WilayahController extends Controller
{
    use PermissionTrait;

    public function index()
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true || $this->checkPermission(auth()->user(), 'nav-content-management-access') == true) {
            $wilayah = Wilayah::get();

            return response($wilayah, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function store(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'provinsi' => 'required|string',
                'kota' => 'required|string',
                'kecamatan' => 'required|string',
                'cabang_pengelola' => 'required|string',
            ]);
            $fields['tanggal_registrasi'] = Carbon::now();
            $wilayah = Wilayah::create($fields);
            return response($wilayah, 201);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function update(Request $request, $id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'provinsi' => 'required|string',
                'kota' => 'required|string',
                'kecamatan' => 'required|string',
                'cabang_pengelola' => 'required|string',
            ]);

            $wilayah = Wilayah::where('id', $id)->first();
            if (!$wilayah) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $wilayah->provinsi = $fields['provinsi'];
            $wilayah->kota = $fields['kota'];
            $wilayah->kecamatan = $fields['kecamatan'];
            $wilayah->cabang_pengelola = $fields['cabang_pengelola'];
            $wilayah->save();

            return response($wilayah, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function destroy($id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {

            $wilayah = Wilayah::where('id', $id)->first();
            if (!$wilayah) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $wilayah->delete();
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
                $record = Wilayah::find($id);
                $record->delete();
            } catch (\Throwable $th) {
            }
        }
        return response([
            'message' => 'Success'
        ], 200);
    }
}
