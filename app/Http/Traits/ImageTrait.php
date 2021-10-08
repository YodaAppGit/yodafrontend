<?php

namespace App\Http\Traits;

use App\Models\Image;
use Illuminate\Support\Facades\URL;

trait ImageTrait
{
    public function saveImages($assocModel, $assocId, $file)
    {
        $img_id = Image::orderBy('id', 'DESC')->first();
        if (!$img_id) {
            $img_id = 1;
        } else {
            $img_id = $img_id->id + 1;
        }
        $count = $img_id;
        $fileName = $assocModel . $assocId . '-' . $count . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('public/' . $assocModel, $fileName);
        $link = URL::to('/') . '/api/get-image/' . $assocModel . '/' . $fileName;
        $image = Image::create([
            'assoc_model' => $assocModel,
            'assoc_id' => $assocId,
            'file_name' => $fileName,
            'link' => $link
        ]);
        return $link;
    }

    public function getImageList($id)
    {
        $images = Image::where('assoc_model', 'units')->where('assoc_id', $id)->get();
        $links = $images->map(function ($image) {
            return collect($image->toArray())
                ->only(['link'])
                ->all();
        });
        return $links;
    }

    public function getImageListDetailed($id)
    {
        $images = Image::where('assoc_model', 'units')->where('assoc_id', $id)->get();
        return $images;
    }
}
