<?php

namespace App\Http\Controllers;

use App\Http\Traits\PermissionTrait;
use App\Models\TahunPembuatan;
use Illuminate\Http\Request;

class TahunPembuatanController extends Controller
{
    use PermissionTrait;

    public function index()
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true || $this->checkPermission(auth()->user(), 'nav-content-management-access') == true) {
            $tahun = TahunPembuatan::get();

            return response($tahun, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function store(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'tahun' => 'required|date_format:Y'
            ]);

            $tahun = TahunPembuatan::create($fields);
            return response($tahun, 201);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function update(Request $request, $id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'tahun' => 'required|date_format:Y'
            ]);
            $tahun = TahunPembuatan::where('id', $id)->first();
            if (!$tahun) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $tahun->tahun = $fields['tahun'];
            $tahun->save();
            return response($tahun, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function destroy($id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {

            $tahun = TahunPembuatan::where('id', $id)->first();
            if (!$tahun) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $tahun->delete();
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
                $record = TahunPembuatan::find($id);
                $record->delete();
            } catch (\Throwable $th) {
            }
        }
        return response([
            'message' => 'Success'
        ], 200);
    }
}
