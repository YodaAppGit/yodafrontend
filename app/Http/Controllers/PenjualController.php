<?php

namespace App\Http\Controllers;

use App\Http\Traits\KeywordTrait;
use App\Http\Traits\PermissionTrait;
use App\Models\Penjual;
use Illuminate\Http\Request;

class PenjualController extends Controller
{
    use PermissionTrait, KeywordTrait;

    public function index()
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true || $this->checkPermission(auth()->user(), 'nav-content-management-access') == true) {
            $penjual = Penjual::get();

            return response($penjual, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function store(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'nama' => 'required|string',
                'no_telepon' => 'required|string',
                'alamat' => 'required|string',
                'provinsi' => 'required|string',
                'kota' => 'required|string',
                'kecamatan' => 'required|string',
            ]);
            $count = Penjual::withTrashed()->count();
            $fields['kode'] = "#" . str_pad($count, 4, '0', STR_PAD_LEFT);
            $penjual = Penjual::create($fields);
            $this->penjualKeyword($penjual->id);
            return response($penjual, 201);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function update(Request $request, $id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'nama' => 'required|string',
                'no_telepon' => 'required|string',
                'alamat' => 'required|string',
                'provinsi' => 'required|string',
                'kota' => 'required|string',
                'kecamatan' => 'required|string',
            ]);

            $penjual = Penjual::where('id', $id)->first();
            if (!$penjual) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $penjual->nama = $fields['nama'];
            $penjual->no_telepon = $fields['no_telepon'];
            $penjual->alamat = $fields['alamat'];
            $penjual->provinsi = $fields['provinsi'];
            $penjual->kota = $fields['kota'];
            $penjual->kecamatan = $fields['kecamatan'];
            $penjual->save();
            $this->penjualKeyword($id);
            return response($penjual, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function destroy($id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {

            $penjual = Penjual::where('id', $id)->first();
            if (!$penjual) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $penjual->delete();
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
                $record = Penjual::find($id);
                $record->delete();
            } catch (\Throwable $th) {
            }
        }
        return response([
            'message' => 'Success'
        ], 200);
    }
}
