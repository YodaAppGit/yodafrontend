<?php

namespace App\Http\Controllers;

use App\Http\Traits\PermissionTrait;
use App\Models\MerekModelVarian;
use Illuminate\Http\Request;

class MerekModelVarianController extends Controller
{
    use PermissionTrait;

    public function index()
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true || $this->checkPermission(auth()->user(), 'nav-content-management-access') == true) {
            $mmv = MerekModelVarian::get();

            return response($mmv, 200);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function store(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'merek' => 'required|string',
                'model' => 'required|string',
                'varian' => 'required|string',
            ]);
            $mmv = MerekModelVarian::create($fields);

            return response([
                'Message' => 'Success',
                'MMV' => $mmv,
            ], 201);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function update(Request $request, $id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $fields = $request->validate([
                'merek' => 'required|string',
                'model' => 'required|string',
                'varian' => 'required|string',
            ]);
            $mmv = MerekModelVarian::where('id', $id)->first();
            if (!$mmv) {
                return response([
                    'Message' => 'Data Not Found.',
                ], 404);
            }

            $mmv->merek = $fields['merek'];
            $mmv->model = $fields['model'];
            $mmv->varian = $fields['varian'];
            $mmv->save();

            return response([
                'Message' => 'Success',
                'MMV' => $mmv,
            ], 201);
        }
        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function destroy($id)
    {
        if ($this->checkPermission(auth()->user(), 'content-management-access') == true) {
            $mmv = MerekModelVarian::where('id', $id)->first();

            if (!$mmv) {
                return response([
                    'Message' => 'Data Not Found',
                ], 404);
            }

            $mmv->delete();
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
                $record = MerekModelVarian::find($id);
                $record->delete();
            } catch (\Throwable $th) {
            }
        }
        return response([
            'message' => 'Success'
        ], 200);
    }
}
