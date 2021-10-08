<?php

namespace App\Http\Controllers;

use App\Http\Traits\ImageTrait;
use App\Models\Image;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    use ImageTrait;

    public function getImage($model, $name)
    {
        return response()->file(storage_path('/app/public/' . $model . '/' . $name));
    }

    public function deleteMulti(Request $request)
    {
        $ids = $request->input('id');
        $table = $request->input('table');
        foreach ($ids as $id) {
            $image = Image::find($id);

            if ($image) {

                if (Storage::exists('public/' . $table . '/' . $image->file_name)) {
                    Storage::delete('public/' . $table . '/' . $image->file_name);
                }
                $image->delete();
            }
            return response([
                'message' => 'Image Not Found'
            ], 400);
        }

        return response([
            'message' => 'Success'
        ], 200);
    }

    public function setUnitCover($id)
    {
        $image = Image::find($id);
        $unit = Unit::find($image->assoc_id);

        if (!$image || !$unit) {
            return response([
                'message' => 'Image or Unit Not Found'
            ], 400);
        }

        $unit->cover_link = $image->link;
        $unit->save();

        return response([
            'message' => 'Success'
        ], 200);
    }

    public function uploadMultiImage(Request $request)
    {
        $fields = $request->validate([
            'table' => 'required|string',
            'id' => 'required',
            'pictures' => 'required',
            'pictures.*' => 'image|mimes:jpeg,png,jpg',
        ]);
        $table = $request->input('table');
        $id = $request->input('id');

        $data = DB::table($table)->where('id', $id)->first();

        if (!$data) {
            return response([
                'message' => 'Unit Not Found',
            ], 400);
        }

        if ($request->hasFile('pictures')) {
            $files = $request->file('pictures');
            foreach ($files as $file) {
                $link = $this->saveImages($table, $id, $file);
            }
        }
        return response([
            'message' => 'Success'
        ], 200);
    }
}
