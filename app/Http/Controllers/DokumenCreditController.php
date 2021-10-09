<?php

namespace App\Http\Controllers;

use App\Http\Traits\ImageTrait;
use App\Models\Credit;
use App\Models\DokumenCredit;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenCreditController extends Controller
{
    use ImageTrait;

    public function allCreditDokumen($credit_id)
    {
        $dokumens = DokumenCredit::where('credit_id', $credit_id)->get();

        if (!$dokumens) {
            return response([
                'message' => 'Document Not Found'
            ], 400);
        }

        return response([
            'dokumen' => $dokumens,
        ], 200);
    }

    public function storeDokumen(Request $request)
    {
        $nasabah = Credit::find($request->input('credit_id'));
        if (!$nasabah) {
            return response([
                'message' => 'Credit Not Found'
            ], 400);
        }

        $dokumens = new DokumenCredit();
        $dokumens->credit_id = $request->input('credit_id');
        $dokumens->keterangan = $request->input('keterangan');
        $dokumens->save();

        if ($request->hasFile('pictures')) {
            $files = $request->file('pictures');
            foreach ($files as $file) {
                $id = $this->saveImages('dokumen_credits', $dokumens->id, $file);
            }
        }

        return $dokumens;
    }

    public function getDokumenByKeterangan(Request $request)
    {
        $nasabah = Credit::find($request->input('credit_id'));
        if (!$nasabah) {
            return response([
                'message' => 'Credit Not Found'
            ], 400);
        }

        $dokumen = DokumenCredit::where('credit_id', $nasabah->id)->where('keterangan', $request->input('Keterangan'))->first();

        if (!$dokumen) {
            return response([
                'message' => 'Document Not Found'
            ], 400);
        }

        $dokumen->image_links = $this->getImageList($dokumen->id, 'dokumen_credits');

        return $dokumen;
    }

    public function deleteDokumenFoto(Request $request)
    {
        $id_doc = $request->input('id_dokumen');
        $dokumen = DokumenCredit::find($id_doc);
        $link = $request->input('image_link');
        if (!$dokumen) {
            return response([
                'message' => 'Document Not Found'
            ], 400);
        }
        $table = 'dokumen_credits';
        $ids = Image::where('assoc_model', $table)->where('assoc_id', $id_doc)->pluck('id');
        foreach ($ids as $id) {
            $image = Image::where('link', $link)->first();

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
}
