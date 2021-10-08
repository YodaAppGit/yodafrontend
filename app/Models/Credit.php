<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_kontrak',
        'kondisi_unit',
        'jenis',
        'tujuan_penggunaan',
        'kategori_unit',
        'nomor_mesin',
        'nomor_rangka',
        'nama_pemilik_bpkb',
        'nomor_bpkb',
        'kota_terbit_bpkb',
        'tanggal_bpkb',
        'masa_berkalu_stnk',
        'tenor',
        'harga_kendaraan_baru',
        'harga_on_the_road',
        'max_pembiayaan_kepu',
        'dp',
        'pokok_pinjaman',
        'bunga',
        'suku_bunga_flat',
        'suku_bunga_efektif',
        'total_pinjaman',
        'pembayaran_asuransi',
        'kesertaan_asuransi',
        'jenis_asuransi',
        'premi_asuransi',
        'angsuran',
        'biaya_administrasi',
        'biaya_fudicia',
        'nilai_pertanggungan',
        'biaya_survey_verifikasi',
        'biaya_notaris',
        'total_biaya',
        'card_id',
    ];
}
