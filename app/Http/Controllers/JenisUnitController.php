<?php

namespace App\Http\Controllers;

use App\Http\Traits\PermissionTrait;
use App\Models\JenisUnit;
use Illuminate\Http\Request;

class JenisUnitController extends Controller
{
    use PermissionTrait;

    public function index()
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true || $this->checkPermission(auth()->user(), 'nav-content-management-access') == true) {
            $jenis = JenisUnit::get();

            return response($jenis, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function store(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'jenis_unit' => 'required|string'
            ]);

            $jenis = JenisUnit::create($fields);
            return response($jenis, 201);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function update(Request $request, $id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'jenis_unit' => 'required|string'
            ]);
            $jenis = JenisUnit::where('id', $id)->first();
            if (!$jenis) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $jenis->jenis_unit = $fields['jenis_unit'];
            $jenis->save();
            return response($jenis, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function destroy($id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {

            $jenis = JenisUnit::where('id', $id)->first();
            if (!$jenis) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $jenis->delete();
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
                $record = JenisUnit::find($id);
                $record->delete();
            } catch (\Throwable $th) {
            }
        }
        return response([
            'message' => 'Success'
        ], 200);
    }
}
