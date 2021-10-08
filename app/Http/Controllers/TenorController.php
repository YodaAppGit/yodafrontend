<?php

namespace App\Http\Controllers;

use App\Http\Traits\PermissionTrait;
use App\Models\Tenor;
use Illuminate\Http\Request;

class TenorController extends Controller
{
    use PermissionTrait;

    public function index()
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true || $this->checkPermission(auth()->user(), 'nav-content-management-access') == true) {
            $tenor = Tenor::get();

            return response($tenor, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function store(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'tenor' => 'required|string'
            ]);

            $tenor = Tenor::create($fields);
            return response($tenor, 201);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function update(Request $request, $id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'tenor' => 'required|string'
            ]);
            $tenor = Tenor::where('id', $id)->first();
            if (!$tenor) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $tenor->tenor = $fields['tenor'];
            $tenor->save();
            return response($tenor, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function destroy($id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {

            $tenor = Tenor::where('id', $id)->first();
            if (!$tenor) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $tenor->delete();
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
                $record = Tenor::find($id);
                $record->delete();
            } catch (\Throwable $th) {
            }
        }
        return response([
            'message' => 'Success'
        ], 200);
    }
}
