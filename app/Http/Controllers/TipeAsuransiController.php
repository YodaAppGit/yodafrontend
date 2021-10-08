<?php

namespace App\Http\Controllers;

use App\Http\Traits\PermissionTrait;
use App\Models\TipeAsuransi;
use Illuminate\Http\Request;

class TipeAsuransiController extends Controller
{
    use PermissionTrait;

    public function index()
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true || $this->checkPermission(auth()->user(), 'nav-content-management-access') == true) {
            $tipe_asuransi = TipeAsuransi::get();

            return response($tipe_asuransi, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function store(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'tipe_asuransi' => 'required|string'
            ]);

            $tipe_asuransi = TipeAsuransi::create($fields);
            return response($tipe_asuransi, 201);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function update(Request $request, $id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'tipe_asuransi' => 'required|string'
            ]);
            $tipe_asuransi = TipeAsuransi::where('id', $id)->first();
            if (!$tipe_asuransi) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $tipe_asuransi->tipe_asuransi = $fields['tipe_asuransi'];
            $tipe_asuransi->save();
            return response($tipe_asuransi, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function destroy($id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {

            $tipe_asuransi = TipeAsuransi::where('id', $id)->first();
            if (!$tipe_asuransi) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $tipe_asuransi->delete();
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
                $record = TipeAsuransi::find($id);
                $record->delete();
            } catch (\Throwable $th) {
            }
        }
        return response([
            'message' => 'Success'
        ], 200);
    }
}
