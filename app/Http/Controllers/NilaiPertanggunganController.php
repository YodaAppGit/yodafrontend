<?php

namespace App\Http\Controllers;

use App\Http\Traits\PermissionTrait;
use App\Models\NilaiPertanggungan;
use Illuminate\Http\Request;

class NilaiPertanggunganController extends Controller
{
    use PermissionTrait;

    public function index()
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true || $this->checkPermission(auth()->user(), 'nav-content-management-access') == true) {
            $nilai_pertanggungan = NilaiPertanggungan::get();

            return response($nilai_pertanggungan, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function store(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'nilai_pertanggungan' => 'required|string'
            ]);

            $nilai_pertanggungan = NilaiPertanggungan::create($fields);
            return response($nilai_pertanggungan, 201);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function update(Request $request, $id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'nilai_pertanggungan' => 'required|string'
            ]);
            $nilai_pertanggungan = NilaiPertanggungan::where('id', $id)->first();
            if (!$nilai_pertanggungan) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $nilai_pertanggungan->nilai_pertanggungan = $fields['nilai_pertanggungan'];
            $nilai_pertanggungan->save();
            return response($nilai_pertanggungan, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function destroy($id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {

            $nilai_pertanggungan = NilaiPertanggungan::where('id', $id)->first();
            if (!$nilai_pertanggungan) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $nilai_pertanggungan->delete();
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
                $record = NilaiPertanggungan::find($id);
                $record->delete();
            } catch (\Throwable $th) {
            }
        }
        return response([
            'message' => 'Success'
        ], 200);
    }
}
