<?php

namespace App\Http\Controllers;

use App\Http\Traits\PermissionTrait;
use App\Models\BahanBakar;
use Illuminate\Http\Request;

class BahanBakarController extends Controller
{
    use PermissionTrait;

    public function index()
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true || $this->checkPermission(auth()->user(), 'nav-content-management-access') == true) {
            $bbm = BahanBakar::get();

            return response($bbm, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function store(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'bahan_bakar' => 'required|string'
            ]);

            $bbm = BahanBakar::create($fields);
            return response($bbm, 201);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function update(Request $request, $id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'bahan_bakar' => 'required|string'
            ]);
            $bbm = BahanBakar::where('id', $id)->first();
            if (!$bbm) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $bbm->bahan_bakar = $fields['bahan_bakar'];
            $bbm->save();

            return response($bbm, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function destroy($id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {

            $bbm = BahanBakar::where('id', $id)->first();
            if (!$bbm) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $bbm->delete();
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
                $record = BahanBakar::find($id);
                $record->delete();
            } catch (\Throwable $th) {
            }
        }
        return response([
            'message' => 'Success'
        ], 200);
    }
}
