<?php

namespace App\Http\Controllers;

use App\Http\Traits\KeywordTrait;
use App\Models\CardRefinancing;
use App\Models\Credit;
use App\Models\Nasabah;
use App\Models\Penjual;
use App\Models\Unit;
use Illuminate\Http\Request;

class RefinancingController extends Controller
{
    use KeywordTrait;

    public function createNasabah($nama, $no_ktp, $provinsi, $kota, $kecamatan, $no_hp, $card_id)
    {
        $nasabah = new Nasabah();
        $nasabah->nama =  $nama;
        $nasabah->no_ktp =  $no_ktp;
        $nasabah->provinsi =  $provinsi;
        $nasabah->kota =  $kota;
        $nasabah->kecamatan =  $kecamatan;
        $nasabah->no_hp =  $no_hp;
        $nasabah->card_id = $card_id;
        $nasabah->save();
    }

    public function createCardRefinancing($id)
    {
        $index = CardRefinancing::where('silk_checking', 1)->get();
        $idx = 0;
        if ($index) $idx = count($index);
        $card = CardRefinancing::create([
            'type' => 'Refinancing',
            'slik_checking' => 1,
            'assigning_credit_surveyor' => 0,
            'credit_surveying' => 0,
            'credit_approval' => 0,
            'credit_purchasing_order' => 0,
            'credit_rejected' => 0,
            'slik_rejected' => 0,
            'index' => $idx,
            'creator' => auth()->id(),
            'unit_id' => $id,
            'pic_1' => auth()->id(),
        ]);
        $this->cardRefinancingKeyword($card->id);
        return $card;
    }

    public function getSingle($id)
    {
        $card = CardRefinancing::find($id);

        if (!$card) {
            return response([
                'message' => 'Card Not Found'
            ], 404);
        }

        $unit = Unit::find($card->unit_id);
        $image = $this->getImageListDetailed($unit->id);
        $penjual = Penjual::find($unit->penjual_id);
        $unit->image = $image;
        $result = [
            'card_info' => $card,
            'unit' => $unit,
            'penjual' => $penjual,
        ];

        return response([
            'result' => $result
        ], 200);
    }


    public function storeRefinancing(Request $request)
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
                'alamat' => 'required|string',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'harga' => 'required|string',
                'nama' => 'required|string',
                'no_ktp' => 'required|string',
                'provinsi' => 'required|string',
                'kota' => 'required|string',
                'kecamatan' => 'required|string',
                'no_hp' => 'required|string',
            ]);

            $unit = new Unit();
            $unit->plat_nomor = $request->input('plat_nomor');
            $unit->merek = $request->input('merek');
            $unit->model = $request->input('model');
            $unit->varian = $request->input('varian');
            $unit->tahun = $request->input('tahun');
            $unit->jarak_tempuh = $request->input('jarak_tempuh');
            $unit->bahan_bakar = $request->input('bahan_bakar');
            $unit->warna = $request->input('warna');
            $unit->catatan = $request->input('catatan');
            $unit->alamat = $request->input('alamat');
            $unit->latitude = $request->input('latitude');
            $unit->longitude = $request->input('longitude');
            $unit->harga = $request->input('harga');
            $unit->save();
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

            $card = $this->createCardRefinancing($unit->id);
            $this->cardRefinancingKeyword($card->id);
            $nasabah = $this->createNasabah(
                $request->input('nama'),
                $request->input('no_ktp'),
                $request->input('provinsi'),
                $request->input('kota'),
                $request->input('kecamatan'),
                $request->input('no_hp'),
                $card->id
            );

            return response($unit, 201);
        }

        return response([
            'message' => 'Unauthorized',
        ], 403);
    }

    public function changePipeline(Request $request)
    {
        $id = $request->input('id');
        $pipeline = $request->input('pipeline');
        $index = $request->input('index');
        $card = CardRefinancing::find($id);

        if ($card->silk_checking == 1) $current_pipeline = 'silk_checking';
        if ($card->assigning_credit_surveyor == 1) $current_pipeline = 'assigning_credit_surveyor';
        if ($card->credit_surveying == 1) $current_pipeline = 'credit_surveying';
        if ($card->credit_approval == 1) $current_pipeline = 'credit_approval';
        if ($card->credit_purchasing_order == 1) $current_pipeline = 'credit_purchasing_order';
        if ($card->credit_rejected == 1) $current_pipeline = 'credit_rejected';
        if ($card->unit_not_available == 1) $current_pipeline = 'unit_not_available';
        if ($card->credit_rejected == 1) $current_pipeline = 'credit_rejected';
        if ($card->silk_rejected == 1) $current_pipeline = 'silk_rejected';
        $current_index = $card->index;
        if (!$card) {
            return response([
                'message' => 'Card Not Found'
            ], 400);
        }

        $card->silk_checking = 0;
        $card->assigning_credit_surveyor = 0;
        $card->credit_surveying = 0;
        $card->credit_approval = 0;
        $card->credit_purchasing_order = 0;
        $card->credit_rejected = 0;
        $card->unit_not_available = 0;
        $card->credit_rejected = 0;
        $card->slik_rejected = 0;

        $card->{$pipeline} = 1;
        $card->index = $index;
        $this->indexDownBefore($current_index, $current_pipeline);
        $this->indexUpAfter($index, $pipeline);

        $card->save();
        return response([
            'message' => 'Success',
            'card' => $card,
        ], 200);
    }

    public function indexUpAfter($index, $pipeline)
    {
        $card = CardRefinancing::where($pipeline, 1)->get();
        foreach ($card as $c) {
            if ($c->index >= $index) {
                $c->index++;
                $c->save();
            }
        }
    }

    public function indexDownBefore($index, $pipeline)
    {
        $card = CardRefinancing::where($pipeline, 1)->get();
        foreach ($card as $c) {
            if ($c->index > $index) {
                $c->index--;
                $c->save();
            }
        }
    }
}
