<?php

namespace App\Http\Controllers;

use App\Models\Card;
use App\Models\Nasabah;
use Illuminate\Http\Request;

class NasabahController extends Controller
{
    public function getByCard($id)
    {
        $card = Card::find($id);
        if (!$card) {
            return response([
                'message' => 'Card Not Found.'
            ], 400);
        }

        $nasabah = Nasabah::where('card_id', $card)->first();
        if (!$nasabah) {
            return response([
                'message' => 'Nasabah not found'
            ], 400);
        }

        return response([
            'message' => 'Success',
            'nasabah' => $nasabah,
        ], 200);
    }

    public function store(Request $request)
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

        $nasabah = new Nasabah();
        if ($request->has('nama')) $nasabah->nama = $request->input('nama');
        if ($request->has('no_hp')) $nasabah->nama = $request->input('no_hp');
        if ($request->has('no_ktp')) $nasabah->nama = $request->input('no_ktp');
        if ($request->has('ktp_terbit')) $nasabah->nama = $request->input('ktp_terbit');
        if ($request->has('ktp_berlaku_sampai')) $nasabah->nama = $request->input('ktp_berlaku_sampai');
        if ($request->has('jenis_kelamin')) $nasabah->nama = $request->input('jenis_kelamin');
        if ($request->has('status_pernikahan')) $nasabah->nama = $request->input('status_pernikahan');
        if ($request->has('gelar_nasabah')) $nasabah->nama = $request->input('gelar_nasabah');
        if ($request->has('nama_gadis_ibu_kandung')) $nasabah->nama = $request->input('nama_gadis_ibu_kandung');
        if ($request->has('no_npwp')) $nasabah->nama = $request->input('no_npwp');
        if ($request->has('tempat_lahir')) $nasabah->nama = $request->input('tempat_lahir');
        if ($request->has('tanggal_lahir')) $nasabah->nama = $request->input('tanggal_lahir');
        if ($request->has('alamat_ktp')) $nasabah->nama = $request->input('alamat_ktp');
        if ($request->has('provinsi')) $nasabah->nama = $request->input('provinsi');
        if ($request->has('kota')) $nasabah->nama = $request->input('kota');
        if ($request->has('kecamatan')) $nasabah->nama = $request->input('kecamatan');
        if ($request->has('kelurahan')) $nasabah->nama = $request->input('kelurahan');
        if ($request->has('rw')) $nasabah->nama = $request->input('rw');
        if ($request->has('rt')) $nasabah->nama = $request->input('rt');
        if ($request->has('kode_pos')) $nasabah->nama = $request->input('kode_pos');
        if ($request->has('nama_pasangan')) $nasabah->nama = $request->input('nama_pasangan');
        if ($request->has('hubungan')) $nasabah->nama = $request->input('hubungan');
        if ($request->has('ktp_pasangan')) $nasabah->nama = $request->input('ktp_pasangan');
        if ($request->has('tanggal_lahir_pasangan')) $nasabah->nama = $request->input('tanggal_lahir_pasangan');
        if ($request->has('no_hp_pasangan')) $nasabah->nama = $request->input('no_hp_pasangan');
        $nasabah->save();

        return response([
            'message' => 'Success',
            'nasabah' => $nasabah,
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

        $nasabah = Nasabah::where('card_id', $card->id)->first();
        if (!$nasabah) {
            return response([
                'message' => 'Nasabah not found'
            ], 400);
        }

        if ($request->has('nama')) $nasabah->nama = $request->input('nama');
        if ($request->has('no_hp')) $nasabah->nama = $request->input('no_hp');
        if ($request->has('no_ktp')) $nasabah->nama = $request->input('no_ktp');
        if ($request->has('ktp_terbit')) $nasabah->nama = $request->input('ktp_terbit');
        if ($request->has('ktp_berlaku_sampai')) $nasabah->nama = $request->input('ktp_berlaku_sampai');
        if ($request->has('jenis_kelamin')) $nasabah->nama = $request->input('jenis_kelamin');
        if ($request->has('status_pernikahan')) $nasabah->nama = $request->input('status_pernikahan');
        if ($request->has('gelar_nasabah')) $nasabah->nama = $request->input('gelar_nasabah');
        if ($request->has('nama_gadis_ibu_kandung')) $nasabah->nama = $request->input('nama_gadis_ibu_kandung');
        if ($request->has('no_npwp')) $nasabah->nama = $request->input('no_npwp');
        if ($request->has('tempat_lahir')) $nasabah->nama = $request->input('tempat_lahir');
        if ($request->has('tanggal_lahir')) $nasabah->nama = $request->input('tanggal_lahir');
        if ($request->has('alamat_ktp')) $nasabah->nama = $request->input('alamat_ktp');
        if ($request->has('provinsi')) $nasabah->nama = $request->input('provinsi');
        if ($request->has('kota')) $nasabah->nama = $request->input('kota');
        if ($request->has('kecamatan')) $nasabah->nama = $request->input('kecamatan');
        if ($request->has('kelurahan')) $nasabah->nama = $request->input('kelurahan');
        if ($request->has('rw')) $nasabah->nama = $request->input('rw');
        if ($request->has('rt')) $nasabah->nama = $request->input('rt');
        if ($request->has('kode_pos')) $nasabah->nama = $request->input('kode_pos');
        if ($request->has('nama_pasangan')) $nasabah->nama = $request->input('nama_pasangan');
        if ($request->has('hubungan')) $nasabah->nama = $request->input('hubungan');
        if ($request->has('ktp_pasangan')) $nasabah->nama = $request->input('ktp_pasangan');
        if ($request->has('tanggal_lahir_pasangan')) $nasabah->nama = $request->input('tanggal_lahir_pasangan');
        if ($request->has('no_hp_pasangan')) $nasabah->nama = $request->input('no_hp_pasangan');
        $nasabah->save();

        return response([
            'message' => 'Success',
            'nasabah' => $nasabah,
        ], 200);
    }

    public function updateIdentitas(Request $request)
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

        $nasabah = Nasabah::where('card_id', $card->id)->first();
        if (!$nasabah) {
            return response([
                'message' => 'Nasabah not found'
            ], 400);
        }

        if ($request->has('nama')) $nasabah->nama = $request->input('nama');
        if ($request->has('no_hp')) $nasabah->nama = $request->input('no_hp');
        if ($request->has('no_ktp')) $nasabah->nama = $request->input('no_ktp');
        if ($request->has('ktp_terbit')) $nasabah->nama = $request->input('ktp_terbit');
        if ($request->has('ktp_berlaku_sampai')) $nasabah->nama = $request->input('ktp_berlaku_sampai');
        if ($request->has('jenis_kelamin')) $nasabah->nama = $request->input('jenis_kelamin');
        if ($request->has('status_pernikahan')) $nasabah->nama = $request->input('status_pernikahan');
        if ($request->has('gelar_nasabah')) $nasabah->nama = $request->input('gelar_nasabah');
        if ($request->has('nama_gadis_ibu_kandung')) $nasabah->nama = $request->input('nama_gadis_ibu_kandung');
        if ($request->has('no_npwp')) $nasabah->nama = $request->input('no_npwp');
        if ($request->has('tempat_lahir')) $nasabah->nama = $request->input('tempat_lahir');
        if ($request->has('tanggal_lahir')) $nasabah->nama = $request->input('tanggal_lahir');
        $nasabah->save();

        return response([
            'message' => 'Success',
            'nasabah' => $nasabah,
        ], 200);
    }

    public function updateDomisili(Request $request)
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

        $nasabah = Nasabah::where('card_id', $card->id)->first();
        if (!$nasabah) {
            return response([
                'message' => 'Nasabah not found'
            ], 400);
        }

        if ($request->has('alamat_ktp')) $nasabah->nama = $request->input('alamat_ktp');
        if ($request->has('provinsi')) $nasabah->nama = $request->input('provinsi');
        if ($request->has('kota')) $nasabah->nama = $request->input('kota');
        if ($request->has('kecamatan')) $nasabah->nama = $request->input('kecamatan');
        if ($request->has('kelurahan')) $nasabah->nama = $request->input('kelurahan');
        if ($request->has('rw')) $nasabah->nama = $request->input('rw');
        if ($request->has('rt')) $nasabah->nama = $request->input('rt');
        if ($request->has('kode_pos')) $nasabah->nama = $request->input('kode_pos');
        $nasabah->save();

        return response([
            'message' => 'Success',
            'nasabah' => $nasabah,
        ], 200);
    }

    public function updatePasangan(Request $request)
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

        $nasabah = Nasabah::where('card_id', $card->id)->first();
        if (!$nasabah) {
            return response([
                'message' => 'Nasabah not found'
            ], 400);
        }

        if ($request->has('nama_pasangan')) $nasabah->nama = $request->input('nama_pasangan');
        if ($request->has('hubungan')) $nasabah->nama = $request->input('hubungan');
        if ($request->has('ktp_pasangan')) $nasabah->nama = $request->input('ktp_pasangan');
        if ($request->has('tanggal_lahir_pasangan')) $nasabah->nama = $request->input('tanggal_lahir_pasangan');
        if ($request->has('no_hp_pasangan')) $nasabah->nama = $request->input('no_hp_pasangan');
        $nasabah->save();

        return response([
            'message' => 'Success',
            'nasabah' => $nasabah,
        ], 200);
    }
}
