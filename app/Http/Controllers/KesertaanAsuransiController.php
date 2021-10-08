<?php

namespace App\Http\Controllers;

use App\Http\Traits\PermissionTrait;
use App\Models\KesertaanAsuransi;
use Illuminate\Http\Request;

class KesertaanAsuransiController extends Controller
{
    use PermissionTrait;

    public function index()
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true || $this->checkPermission(auth()->user(), 'nav-content-management-access') == true) {
            $kesertaan_asuransi = KesertaanAsuransi::get();

            return response($kesertaan_asuransi, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function store(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'kesertaan_asuransi' => 'required|string'
            ]);

            $kesertaan_asuransi = KesertaanAsuransi::create($fields);
            return response($kesertaan_asuransi, 201);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function update(Request $request, $id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'kesertaan_asuransi' => 'required|string'
            ]);
            $kesertaan_asuransi = KesertaanAsuransi::where('id', $id)->first();
            if (!$kesertaan_asuransi) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $kesertaan_asuransi->kesertaan_asuransi = $fields['kesertaan_asuransi'];
            $kesertaan_asuransi->save();
            return response($kesertaan_asuransi, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function destroy($id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {

            $kesertaan_asuransi = KesertaanAsuransi::where('id', $id)->first();
            if (!$kesertaan_asuransi) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $kesertaan_asuransi->delete();
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
                $record = KesertaanAsuransi::find($id);
                $record->delete();
            } catch (\Throwable $th) {
            }
        }
        return response([
            'message' => 'Success'
        ], 200);
    }
}
