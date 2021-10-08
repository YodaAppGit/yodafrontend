<?php

namespace App\Http\Controllers;

use App\Http\Traits\PermissionTrait;
use App\Models\JarakTempuh;
use Illuminate\Http\Request;

class JarakTempuhController extends Controller
{
    use PermissionTrait;

    public function index()
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true || $this->checkPermission(auth()->user(), 'nav-content-management-access') == true) {
            $jarak = JarakTempuh::get();

            return response($jarak, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function store(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'jarak_tempuh' => 'required|string'
            ]);

            $jarak = JarakTempuh::create($fields);
            return response($jarak, 201);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function update(Request $request, $id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'jarak_tempuh' => 'required|string'
            ]);
            $jarak = JarakTempuh::where('id', $id)->first();
            if (!$jarak) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $jarak->jarak_tempuh_unit = $fields['jarak_tempuh_unit'];
            $jarak->save();
            return response($jarak, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function destroy($id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {

            $jarak = JarakTempuh::where('id', $id)->first();
            if (!$jarak) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $jarak->delete();
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
                $record = JarakTempuh::find($id);
                $record->delete();
            } catch (\Throwable $th) {
            }
        }
        return response([
            'message' => 'Success'
        ], 200);
    }
}
