<?php

namespace App\Http\Controllers;

use App\Http\Traits\ImageTrait;
use App\Http\Traits\KeywordTrait;
use App\Http\Traits\PermissionTrait;
use App\Models\Card;
use App\Models\CardRefinancing;
use App\Models\Credit;
use App\Models\Image;
use App\Models\Nasabah;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    use PermissionTrait, ImageTrait, KeywordTrait, KeywordTrait;

    public function index()
    {
        $units = Unit::with('penjual')->get();

        foreach ($units as $unit) {
            $unit->image_links = $this->getImageList($unit->id, 'units');
        }
        return response($units, 200);
    }

    public function storeFinancing(Request $request)
    {
        if ($this->checkPermission(auth()->user(), 'mobile-add-unit-access') == true) {
            $fields = $request->validate([
                'plat_nomor' => 'required|string|unique:units,plat_nomor',
                'merek' => 'required|string',
                'model' => 'required|string',
                'varian' => 'required|string',
                'tahun' => 'required|string',
                'jarak_tempuh' => 'required|string',
                'bahan_bakar' => 'required|string',
                'warna' => 'required|string',
                'catatan' => 'required',
                'pictures' => 'required',
                'pictures.*' => 'image|mimes:jpeg,png,jpg',
                'penjual_id' => 'required|string',
                'alamat' => 'required|string',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'harga' => 'required|string'
            ]);
            $unit = Unit::create($fields);

            if ($request->hasFile('pictures')) {
                $ctr = 1;
                $files = $request->file('pictures');
                foreach ($files as $file) {
                    $link = $this->saveImages('units', $unit->id, $file);
                    if ($ctr == 1) {
                        $unit->cover_link = $link;
                        $unit->save();
                    }
                    $ctr++;
                }
            }
            $this->unitKeyword($unit->id);
            $unit->image_links = $this->getImageList($unit->id, 'units');

            $this->createCardFinancing($unit->id);
            return response($unit, 201);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function update(Request $request, $id)
    {
        $fields = $request->validate([
            'plat_nomor' => 'required|string',
            'merek' => 'required|string',
            'model' => 'required|string',
            'varian' => 'required|string',
            'tahun' => 'required|string',
            'jarak_tempuh' => 'required|string',
            'bahan_bakar' => 'required|string',
            'warna' => 'required|string',
            'catatan' => 'required',
            'penjual_id' => 'required|string',
            'alamat' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'harga' => 'required|string'
        ]);

        $unit = Unit::where('id', $id)->with('penjual')->first();
        if (!$unit) {
            return response([
                'message' => 'Data Not Found.'
            ], 404);
        }
        $unit->plat_nomor = $request->input('plat_nomor');
        $unit->merek = $request->input('merek');
        $unit->model = $request->input('model');
        $unit->varian = $request->input('varian');
        $unit->tahun = $request->input('tahun');
        $unit->jarak_tempuh = $request->input('jarak_tempuh');
        $unit->bahan_bakar = $request->input('bahan_bakar');
        $unit->warna = $request->input('warna');
        $unit->catatan = $request->input('catatan');
        $unit->penjual_id = $request->input('penjual_id');
        $unit->alamat = $request->input('alamat');
        $unit->latitude = $request->input('latitude');
        $unit->longitude = $request->input('longitude');
        $unit->harga = $request->input('harga');
        $unit->save();
        $this->unitKeyword($unit->id);
        $unit = Unit::where('id', $id)->with('penjual')->first();
        $unit->image_links = $this->getImageList($unit->id, 'units');
        return response([
            'unit' => $unit
        ], 200);
    }

    public function destroy($id)
    {
        if ($this->checkPermission(auth()->user(), 'mobile-add-unit-access') == true) {

            $unit = Unit::where('id', $id)->first();
            if (!$unit) {
                return response([
                    'message' => 'Data Not Found.'
                ], 404);
            }
            $unit->delete();
            return response([
                'Message' => 'Success',
            ], 201);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function createCardFinancing($id)
    {
        $index = Card::where('unit_listing', 1)->get();
        $idx = 0;
        if ($index) $idx = count($index);
        $card = Card::create([
            'type' => 'financing',
            'unit_listing' => 1,
            'unit_visiting' => 0,
            'unit_visit_done' => 0,
            'assigning_credit_surveyor' => 0,
            'credit_surveying' => 0,
            'credit_approval' => 0,
            'credit_purchasing_order' => 0,
            'credit_rejected' => 0,
            'unit_not_available' => 0,
            'creator' => auth()->id(),
            'unit_id' => $id,
            'pic_1' => auth()->id(),
            'index' => $idx,
        ]);
        $this->cardFinancingKeyword($card->id);
        $nasabah = Nasabah::create([
            'card_id' => $id,
        ]);
        $credit = Credit::create([
            'card_id' => $id,
        ]);
    }
}
