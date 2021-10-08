<?php

namespace App\Http\Controllers;

use App\Http\Traits\PermissionTrait;
use App\Models\AngsuranPertama;
use Illuminate\Http\Request;

class AngsuranPertamaController extends Controller
{
    use PermissionTrait;

    public function index()
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true || $this->checkPermission(auth()->user(), 'nav-content-management-access') == true) {
            $angsuran_pertama = AngsuranPertama::get();

            return response($angsuran_pertama, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function store(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'angsuran_pertama' => 'required|string'
            ]);

            $angsuran_pertama = AngsuranPertama::create($fields);
            return response($angsuran_pertama, 201);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function update(Request $request, $id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'angsuran_pertama' => 'required|string'
            ]);
            $angsuran_pertama = AngsuranPertama::where('id', $id)->first();
            if (!$angsuran_pertama) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $angsuran_pertama->angsuran_pertama = $fields['angsuran_pertama'];
            $angsuran_pertama->save();
            return response($angsuran_pertama, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function destroy($id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {

            $angsuran_pertama = AngsuranPertama::where('id', $id)->first();
            if (!$angsuran_pertama) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $angsuran_pertama->delete();
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
                $record = AngsuranPertama::find($id);
                $record->delete();
            } catch (\Throwable $th) {
            }
        }
        return response([
            'message' => 'Success'
        ], 200);
    }
}
