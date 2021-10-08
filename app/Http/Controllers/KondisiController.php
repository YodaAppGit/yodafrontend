<?php

namespace App\Http\Controllers;

use App\Http\Traits\PermissionTrait;
use App\Models\Kondisi;
use Illuminate\Http\Request;

class KondisiController extends Controller
{
    use PermissionTrait;

    public function index()
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true || $this->checkPermission(auth()->user(), 'nav-content-management-access') == true) {
            $kondisi = Kondisi::get();

            return response($kondisi, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function store(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'kondisi' => 'required|string'
            ]);

            $kondisi = Kondisi::create($fields);
            return response($kondisi, 201);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function update(Request $request, $id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'kondisi' => 'required|string'
            ]);
            $kondisi = Kondisi::where('id', $id)->first();
            if (!$kondisi) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $kondisi->kondisi = $fields['kondisi'];
            $kondisi->save();
            return response($kondisi, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function destroy($id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {

            $kondisi = Kondisi::where('id', $id)->first();
            if (!$kondisi) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $kondisi->delete();
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
                $record = Kondisi::find($id);
                $record->delete();
            } catch (\Throwable $th) {
            }
        }
        return response([
            'message' => 'Success'
        ], 200);
    }
}
