<?php

namespace App\Http\Controllers;

use App\Models\BahanBakar;
use App\Models\JarakTempuh;
use App\Models\MerekModelVarian;
use App\Models\TahunPembuatan;
use App\Models\Transmisi;
use App\Models\Warna;
use Illuminate\Http\Request;

class ContentManagementController extends Controller
{
    public function tambahUnitDD()
    {
        $results = [];
        $results['merek'] = MerekModelVarian::groupBy('merek')->pluck('merek')->toArray();
        $results['model'] = MerekModelVarian::groupBy('model')->pluck('model')->toArray();
        $results['varian'] = MerekModelVarian::groupBy('varian')->pluck('varian')->toArray();
        $results['tahun'] = TahunPembuatan::pluck('tahun')->toArray();
        $results['jarak_tempuh'] = JarakTempuh::pluck('jarak_tempuh')->toArray();
        $results['bahan_bakar'] = BahanBakar::pluck('bahan_bakar')->toArray();
        $results['transmisi'] = Transmisi::pluck('transmisi')->toArray();
        $results['warna'] = Warna::pluck('warna')->toArray();
        return $results;
    }
}
