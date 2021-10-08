<?php

namespace App\Http\Controllers;

use App\Http\Traits\PermissionTrait;
use App\Models\PembayaranAsuransi;
use Illuminate\Http\Request;

class PembayaranAsuransiController extends Controller
{
    use PermissionTrait;

    public function index()
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true || $this->checkPermission(auth()->user(), 'nav-content-management-access') == true) {
            $pembayaran_asuransi = PembayaranAsuransi::get();

            return response($pembayaran_asuransi, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function store(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'pembayaran_asuransi' => 'required|string'
            ]);

            $pembayaran_asuransi = PembayaranAsuransi::create($fields);
            return response($pembayaran_asuransi, 201);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function update(Request $request, $id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'pembayaran_asuransi' => 'required|string'
            ]);
            $pembayaran_asuransi = PembayaranAsuransi::where('id', $id)->first();
            if (!$pembayaran_asuransi) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $pembayaran_asuransi->pembayaran_asuransi = $fields['pembayaran_asuransi'];
            $pembayaran_asuransi->save();
            return response($pembayaran_asuransi, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function destroy($id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {

            $pembayaran_asuransi = PembayaranAsuransi::where('id', $id)->first();
            if (!$pembayaran_asuransi) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $pembayaran_asuransi->delete();
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
                $record = PembayaranAsuransi::find($id);
                $record->delete();
            } catch (\Throwable $th) {
            }
        }
        return response([
            'message' => 'Success'
        ], 200);
    }
}
