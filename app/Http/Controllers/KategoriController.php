<?php

namespace App\Http\Controllers;

use App\Http\Traits\PermissionTrait;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    use PermissionTrait;

    public function index()
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true || $this->checkPermission(auth()->user(), 'nav-content-management-access') == true) {
            $kategori = Kategori::get();

            return response($kategori, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function store(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'kategori' => 'required|string'
            ]);

            $kategori = Kategori::create($fields);
            return response($kategori, 201);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function update(Request $request, $id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'kategori' => 'required|string'
            ]);
            $kategori = Kategori::where('id', $id)->first();
            if (!$kategori) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $kategori->kategori = $fields['kategori'];
            $kategori->save();
            return response($kategori, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function destroy($id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {

            $kategori = Kategori::where('id', $id)->first();
            if (!$kategori) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $kategori->delete();
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
                $record = Kategori::find($id);
                $record->delete();
            } catch (\Throwable $th) {
            }
        }
        return response([
            'message' => 'Success'
        ], 200);
    }
}
