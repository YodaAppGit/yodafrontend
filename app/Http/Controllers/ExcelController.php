<?php

namespace App\Http\Controllers;

use App\Imports\ExcelImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ExcelController extends Controller
{
    public function import(Request $request)
    {
        DB::table('merek_model_varians')->truncate();
        DB::table('indonesias')->truncate();
        DB::table('kantors')->truncate();
        DB::table('tahun_pembuatans')->truncate();
        DB::table('jarak_tempuhs')->truncate();
        DB::table('warnas')->truncate();
        DB::table('bahan_bakars')->truncate();
        DB::table('transmisis')->truncate();
        DB::table('kondisis')->truncate();
        DB::table('jenis_units')->truncate();
        DB::table('tujuan_penggunaans')->truncate();
        DB::table('kategoris')->truncate();
        DB::table('tipe_asuransis')->truncate();
        DB::table('kesertaan_asuransis')->truncate();
        DB::table('loan_types')->truncate();
        DB::table('nilai_pertanggungans')->truncate();
        DB::table('pembayaran_asuransis')->truncate();
        DB::table('tenors')->truncate();
        DB::table('angsuran_pertamas')->truncate();
        DB::table('areas')->truncate();

        Excel::import(new ExcelImport, request()->file('excel'));

        return response([
            'message' => 'Success'
        ], 201);
    }
}
