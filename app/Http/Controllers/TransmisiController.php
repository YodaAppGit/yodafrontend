<?php

namespace App\Http\Controllers;

use App\Http\Traits\PermissionTrait;
use App\Models\Transmisi;
use Illuminate\Http\Request;

class TransmisiController extends Controller
{
    use PermissionTrait;

    public function index()
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true || $this->checkPermission(auth()->user(), 'nav-content-management-access') == true) {
            $transmisi = Transmisi::get();

            return response($transmisi, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function store(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'transmisi' => 'required|string'
            ]);

            $transmisi = Transmisi::create($fields);
            return response($transmisi, 201);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function update(Request $request, $id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'transmisi' => 'required|string'
            ]);
            $transmisi = Transmisi::where('id', $id)->first();
            if (!$transmisi) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $transmisi->transmisi = $fields['transmisi'];
            $transmisi->save();
            return response($transmisi, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function destroy($id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {

            $transmisi = Transmisi::where('id', $id)->first();
            if (!$transmisi) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $transmisi->delete();
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
                $record = Transmisi::find($id);
                $record->delete();
            } catch (\Throwable $th) {
            }
        }
        return response([
            'message' => 'Success'
        ], 200);
    }
}
