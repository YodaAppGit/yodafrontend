<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Credit;
use App\Models\Unit;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    public function storeCredit(Request $request)
    {
        $fields = $request->validate([
            'card_id' => 'required',
        ]);

        $card = Card::find($request->input('card_id'));
        if (!$card) {
            return response([
                'message' => 'Card Not Found.'
            ], 400);
        }

        $credit = new Credit();

        if ($request->has('no_kontrak')) $credit->no_kontrak = $request->input('no_kontrak');
        if ($request->has('kondisi_unit')) $credit->kondisi_unit = $request->input('kondisi_unit');
        if ($request->has('jenis')) $credit->jenis = $request->input('jenis');
        if ($request->has('tujuan_penggunaan')) $credit->tujuan_penggunaan = $request->input('tujuan_penggunaan');
        if ($request->has('kategori_unit')) $credit->kategori_unit = $request->input('kategori_unit');
        if ($request->has('nomor_mesin')) $credit->nomor_mesin = $request->input('nomor_mesin');
        if ($request->has('nomor_rangka')) $credit->nomor_rangka = $request->input('nomor_rangka');
        if ($request->has('nama_pemilik_bpkb')) $credit->nama_pemilik_bpkb = $request->input('nama_pemilik_bpkb');
        if ($request->has('nomor_bpkb')) $credit->nomor_bpkb = $request->input('nomor_bpkb');
        if ($request->has('kota_terbit_bpkb')) $credit->kota_terbit_bpkb = $request->input('kota_terbit_bpkb');
        if ($request->has('tanggal_bpkb')) $credit->tanggal_bpkb = $request->input('tanggal_bpkb');
        if ($request->has('masa_berkalu_stnk')) $credit->masa_berkalu_stnk = $request->input('masa_berkalu_stnk');
        if ($request->has('tenor')) $credit->tenor = $request->input('tenor');
        if ($request->has('harga_kendaraan_baru')) $credit->harga_kendaraan_baru = $request->input('harga_kendaraan_baru');
        if ($request->has('harga_on_the_road')) $credit->harga_on_the_road = $request->input('harga_on_the_road');
        if ($request->has('max_pembiayaan_kepu')) $credit->max_pembiayaan_kepu = $request->input('max_pembiayaan_kepu');
        if ($request->has('dp')) $credit->dp = $request->input('dp');
        if ($request->has('pokok_pinjaman')) $credit->pokok_pinjaman = $request->input('pokok_pinjaman');
        if ($request->has('bunga')) $credit->bunga = $request->input('bunga');
        if ($request->has('suku_bunga_flat')) $credit->suku_bunga_flat = $request->input('suku_bunga_flat');
        if ($request->has('suku_bunga_efektif')) $credit->suku_bunga_efektif = $request->input('suku_bunga_efektif');
        if ($request->has('total_pinjaman')) $credit->total_pinjaman = $request->input('total_pinjaman');
        if ($request->has('pembayaran_asuransi')) $credit->pembayaran_asuransi = $request->input('pembayaran_asuransi');
        if ($request->has('kesertaan_asuransi')) $credit->kesertaan_asuransi = $request->input('kesertaan_asuransi');
        if ($request->has('jenis_asuransi')) $credit->jenis_asuransi = $request->input('jenis_asuransi');
        if ($request->has('premi_asuransi')) $credit->premi_asuransi = $request->input('premi_asuransi');
        if ($request->has('angsuran')) $credit->angsuran = $request->input('angsuran');
        if ($request->has('biaya_administrasi')) $credit->biaya_administrasi = $request->input('biaya_administrasi');
        if ($request->has('biaya_fudicia')) $credit->biaya_fudicia = $request->input('biaya_fudicia');
        if ($request->has('nilai_pertanggungan')) $credit->nilai_pertanggungan = $request->input('nilai_pertanggungan');
        if ($request->has('biaya_survey_verifikasi')) $credit->biaya_survey_verifikasi = $request->input('biaya_survey_verifikasi');
        if ($request->has('biaya_notaris')) $credit->biaya_notaris = $request->input('biaya_notaris');
        if ($request->has('total_biaya')) $credit->total_biaya = $request->input('total_biaya');
        $credit->card_id = $card->id;

        $credit->save();

        return response([
            'message' => 'Success',
            'nasabah' => $credit,
        ], 201);
    }


    public function updateAll(Request $request)
    {
        $fields = $request->validate([
            'card_id' => 'required',
        ]);

        $card = Card::find($request->input('card_id'));
        if (!$card) {
            return response([
                'message' => 'Card Not Found.'
            ], 400);
        }

        $credit = Credit::where('card_id', $card->id)->first();
        if (!$credit) {
            return response([
                'message' => 'Credit not found'
            ], 400);
        }

        if ($request->has('no_kontrak')) $credit->no_kontrak = $request->input('no_kontrak');
        if ($request->has('kondisi_unit')) $credit->kondisi_unit = $request->input('kondisi_unit');
        if ($request->has('jenis')) $credit->jenis = $request->input('jenis');
        if ($request->has('tujuan_penggunaan')) $credit->tujuan_penggunaan = $request->input('tujuan_penggunaan');
        if ($request->has('kategori_unit')) $credit->kategori_unit = $request->input('kategori_unit');
        if ($request->has('nomor_mesin')) $credit->nomor_mesin = $request->input('nomor_mesin');
        if ($request->has('nomor_rangka')) $credit->nomor_rangka = $request->input('nomor_rangka');
        if ($request->has('nama_pemilik_bpkb')) $credit->nama_pemilik_bpkb = $request->input('nama_pemilik_bpkb');
        if ($request->has('nomor_bpkb')) $credit->nomor_bpkb = $request->input('nomor_bpkb');
        if ($request->has('kota_terbit_bpkb')) $credit->kota_terbit_bpkb = $request->input('kota_terbit_bpkb');
        if ($request->has('tanggal_bpkb')) $credit->tanggal_bpkb = $request->input('tanggal_bpkb');
        if ($request->has('masa_berkalu_stnk')) $credit->masa_berkalu_stnk = $request->input('masa_berkalu_stnk');
        if ($request->has('tenor')) $credit->tenor = $request->input('tenor');
        if ($request->has('harga_kendaraan_baru')) $credit->harga_kendaraan_baru = $request->input('harga_kendaraan_baru');
        if ($request->has('harga_on_the_road')) $credit->harga_on_the_road = $request->input('harga_on_the_road');
        if ($request->has('max_pembiayaan_kepu')) $credit->max_pembiayaan_kepu = $request->input('max_pembiayaan_kepu');
        if ($request->has('dp')) $credit->dp = $request->input('dp');
        if ($request->has('pokok_pinjaman')) $credit->pokok_pinjaman = $request->input('pokok_pinjaman');
        if ($request->has('bunga')) $credit->bunga = $request->input('bunga');
        if ($request->has('suku_bunga_flat')) $credit->suku_bunga_flat = $request->input('suku_bunga_flat');
        if ($request->has('suku_bunga_efektif')) $credit->suku_bunga_efektif = $request->input('suku_bunga_efektif');
        if ($request->has('total_pinjaman')) $credit->total_pinjaman = $request->input('total_pinjaman');
        if ($request->has('pembayaran_asuransi')) $credit->pembayaran_asuransi = $request->input('pembayaran_asuransi');
        if ($request->has('kesertaan_asuransi')) $credit->kesertaan_asuransi = $request->input('kesertaan_asuransi');
        if ($request->has('jenis_asuransi')) $credit->jenis_asuransi = $request->input('jenis_asuransi');
        if ($request->has('premi_asuransi')) $credit->premi_asuransi = $request->input('premi_asuransi');
        if ($request->has('angsuran')) $credit->angsuran = $request->input('angsuran');
        if ($request->has('biaya_administrasi')) $credit->biaya_administrasi = $request->input('biaya_administrasi');
        if ($request->has('biaya_fudicia')) $credit->biaya_fudicia = $request->input('biaya_fudicia');
        if ($request->has('nilai_pertanggungan')) $credit->nilai_pertanggungan = $request->input('nilai_pertanggungan');
        if ($request->has('biaya_survey_verifikasi')) $credit->biaya_survey_verifikasi = $request->input('biaya_survey_verifikasi');
        if ($request->has('biaya_notaris')) $credit->biaya_notaris = $request->input('biaya_notaris');
        if ($request->has('total_biaya')) $credit->total_biaya = $request->input('total_biaya');
        $credit->save();

        return response([
            'message' => 'Success',
            'nasabah' => $credit,
        ], 201);
    }

    public function updateNoKontrak(Request $request)
    {
        $id = $request->input('id');
        $no_kontrak = $request->input('no_kontrak');
        $credit = Credit::find($id);
        $credit->no_kontrak = $no_kontrak;
        $credit->save();
    }

    public function getCreditInfo($id)
    {
        $card = Card::find($id);
        if (!$card) {
            return response([
                'message' => 'Card Not Found.'
            ], 400);
        }

        $credit = Credit::where('card_id', $card->id)->first();
        if (!$credit) {
            return response([
                'message' => 'Credit Not Found'
            ], 400);
        }
        $unit = Unit::where('unit_id', $card->unit_id)->first();
        if (!$unit) {
            return response([
                'message' => 'Unit Not Found'
            ], 400);
        }

        return response([
            'unit' => $unit,
            'credit' => $credit,
        ], 200);
    }
}
