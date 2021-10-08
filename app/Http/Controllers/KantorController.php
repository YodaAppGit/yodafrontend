<?php

namespace App\Http\Controllers;

use App\Http\Traits\PermissionTrait;
use App\Models\Kantor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KantorController extends Controller
{
    use PermissionTrait;

    public function index()
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true || $this->checkPermission(auth()->user(), 'nav-content-management-access') == true) {
            $kantor = Kantor::get();
            foreach ($kantor as $k) {
                $pic = User::find($k->pic);
                $k->pic = $pic->name;
            }
            return response($kantor, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function store(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'nama_cabang' => 'required|string',
                'kode_cabang' => 'required|integer',
                'no_telepon' => 'required|string',
                'alamat' => 'required|string',
                'pic' => 'required',
            ]);
            $pic = User::where('id', $fields['pic'])->first();
            if (!$pic) {
                return response([
                    'message' => 'PIC Unregistered.'
                ], 404);
            }
            $fields['pic'] = $pic->id;
            $fields['tanggal_registrasi'] = Carbon::now();
            $kantor = Kantor::create($fields);
            return response($kantor, 201);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function update(Request $request, $id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'nama_cabang' => 'required|string',
                'kode_cabang' => 'required|integer',
                'no_telepon' => 'required|string',
                'alamat' => 'required|string',
                'pic' => 'required',
            ]);
            $pic = User::where('id', $fields['pic'])->first();
            if (!$pic) {
                return response([
                    'message' => 'PIC Unregistered.'
                ], 404);
            }
            $fields['pic'] = $pic->id;

            $kantor = Kantor::where('id', $id)->first();
            if (!$kantor) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $kantor->nama_cabang = $fields['nama_cabang'];
            $kantor->kode_cabang = $fields['kode_cabang'];
            $kantor->no_telepon = $fields['no_telepon'];
            $kantor->alamat = $fields['alamat'];
            $kantor->pic = $fields['pic'];
            $kantor->save();

            return response($kantor, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function destroy($id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {

            $kantor = Kantor::where('id', $id)->first();
            if (!$kantor) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $kantor->delete();
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
                $record = Kantor::find($id);
                $record->delete();
            } catch (\Throwable $th) {
            }
        }
        return response([
            'message' => 'Success'
        ], 200);
    }

    public function getNamaCabang()
    {
        $kantor = Kantor::select('nama_cabang')->get();

        return response([
            'nama_cabang' => $kantor
        ], 200);
    }
}
