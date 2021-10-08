<?php

namespace Database\Seeders;

use App\Models\AngsuranPertama;
use App\Models\BahanBakar;
use App\Models\JarakTempuh;
use App\Models\JenisUnit;
use App\Models\Kantor;
use App\Models\Kategori;
use App\Models\KesertaanAsuransi;
use App\Models\Kondisi;
use App\Models\MerekModelVarian;
use App\Models\NilaiPertanggungan;
use App\Models\PembayaranAsuransi;
use App\Models\Penjual;
use App\Models\TahunPembuatan;
use App\Models\Tenor;
use App\Models\TipeAsuransi;
use App\Models\Transmisi;
use App\Models\TujuanPenggunaan;
use App\Models\Warna;
use App\Models\Wilayah;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ContentManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MerekModelVarian::create([
            'merek' => 'Mitsubishi',
            'model' => 'Colt',
            'varian' => '1.0 Bensin'
        ]);
        MerekModelVarian::create([
            'merek' => 'Mitsubishi',
            'model' => 'Colt',
            'varian' => '1.3 Bensin'
        ]);
        MerekModelVarian::create([
            'merek' => 'Mitsubishi',
            'model' => 'Colt FE',
            'varian' => '1.3 Solar'
        ]);
        MerekModelVarian::create([
            'merek' => 'Suzuki',
            'model' => 'Futura',
            'varian' => '1.3 Bensin'
        ]);

        TahunPembuatan::create([
            'tahun' => '<1993'
        ]);
        TahunPembuatan::create([
            'tahun' => '1994'
        ]);
        TahunPembuatan::create([
            'tahun' => '1995'
        ]);
        TahunPembuatan::create([
            'tahun' => '1996'
        ]);
        TahunPembuatan::create([
            'tahun' => '1997'
        ]);


        JarakTempuh::create([
            'jarak_tempuh' => '0-5.000'
        ]);
        JarakTempuh::create([
            'jarak_tempuh' => '5.000-10.000'
        ]);
        JarakTempuh::create([
            'jarak_tempuh' => '10.000-15.000'
        ]);
        JarakTempuh::create([
            'jarak_tempuh' => '5.000-10.000'
        ]);
        JarakTempuh::create([
            'jarak_tempuh' => '15.000-20.000'
        ]);
        JarakTempuh::create([
            'jarak_tempuh' => '20.000-25.000'
        ]);


        Warna::create([
            'warna' => 'Hitam'
        ]);
        Warna::create([
            'warna' => 'Biru'
        ]);
        Warna::create([
            'warna' => 'Hitam'
        ]);
        Warna::create([
            'warna' => 'Kuning'
        ]);
        Warna::create([
            'warna' => 'Merah'
        ]);
        Warna::create([
            'warna' => 'Cokelat'
        ]);

        BahanBakar::create([
            'bahan_bakar' => 'Diesel'
        ]);
        BahanBakar::create([
            'bahan_bakar' => 'Bensin'
        ]);
        BahanBakar::create([
            'bahan_bakar' => 'Hybrid'
        ]);
        BahanBakar::create([
            'bahan_bakar' => 'Listrik'
        ]);

        Transmisi::create([
            'transmisi' => 'Manual'
        ]);
        Transmisi::create([
            'transmisi' => 'Automatic'
        ]);
        Transmisi::create([
            'transmisi' => 'Automatic Triptonic'
        ]);

        Kondisi::create([
            'kondisi' => 'Baru'
        ]);
        Kondisi::create([
            'kondisi' => 'Bekas'
        ]);

        JenisUnit::create([
            'jenis_unit' => 'MB'
        ]);
        JenisUnit::create([
            'jenis_unit' => 'Jeep'
        ]);
        JenisUnit::create([
            'jenis_unit' => 'Bus'
        ]);
        JenisUnit::create([
            'jenis_unit' => 'Sedan'
        ]);
        JenisUnit::create([
            'jenis_unit' => 'Microbus'
        ]);

        Kantor::create([
            'nama_cabang' => 'Jakarta Timur',
            'kode_cabang' => '23',
            'no_telepon' => '(021) 86614072',
            'alamat' => 'Puri Sentra Niaga Blok A No. 10 Jl. Wiraloka Kalimalang',
            'pic' => 1,
            'tanggal_registrasi' => Carbon::now()
        ]);
        Kantor::create([
            'nama_cabang' => 'Bekasi',
            'kode_cabang' => '3',
            'no_telepon' => '(021) 8892447',
            'alamat' => 'Ruko Sun City Square Blok A No. 42 Jl. M. Hasibuan Margajaya Bekasi Selatan',
            'pic' => 1,
            'tanggal_registrasi' => Carbon::now()
        ]);

        Wilayah::create([
            'provinsi' => 'DKI Jakarta',
            'kota' => 'Jakarta',
            'kecamatan' => 'Menteng Cikini',
            'cabang_pengelola' => 'Kalimalang',
            'tanggal_registrasi' => Carbon::now()
        ]);
        Wilayah::create([
            'provinsi' => 'Jawa Timur',
            'kota' => 'Batu',
            'kecamatan' => 'Bumiaji',
            'cabang_pengelola' => 'Malang',
            'tanggal_registrasi' => Carbon::now()
        ]);

        TujuanPenggunaan::create([
            'tujuan_penggunaan' => 'Angkutan Barang'
        ]);
        TujuanPenggunaan::create([
            'tujuan_penggunaan' => 'Rental'
        ]);
        TujuanPenggunaan::create([
            'tujuan_penggunaan' => 'Angkutan Penumpang'
        ]);
        TujuanPenggunaan::create([
            'tujuan_penggunaan' => 'Pribadi'
        ]);

        Kategori::create([
            'kategori' => 'Kepu'
        ]);
        Kategori::create([
            'kategori' => 'Niaga'
        ]);
        Kategori::create([
            'kategori' => 'Penumpang'
        ]);
        Kategori::create([
            'kategori' => 'Lain'
        ]);

        TipeAsuransi::create([
            'tipe_asuransi' => 'TLO'
        ]);
        TipeAsuransi::create([
            'tipe_asuransi' => 'All Risk'
        ]);

        KesertaanAsuransi::create([
            'kesertaan_asuransi' => 'Asuransi'
        ]);
        KesertaanAsuransi::create([
            'kesertaan_asuransi' => 'Non Asuransi'
        ]);

        NilaiPertanggungan::create([
            'nilai_pertanggungan' => 'OTR'
        ]);
        NilaiPertanggungan::create([
            'nilai_pertanggungan' => 'PH'
        ]);

        PembayaranAsuransi::create([
            'pembayaran_asuransi' => 'Tunai'
        ]);
        PembayaranAsuransi::create([
            'pembayaran_asuransi' => 'Kredit'
        ]);

        Tenor::create([
            'tenor' => '1 Tahun'
        ]);
        Tenor::create([
            'tenor' => '2 Tahun'
        ]);
        Tenor::create([
            'tenor' => '3 Tahun'
        ]);
        Tenor::create([
            'tenor' => '4 Tahun'
        ]);

        AngsuranPertama::create([
            'angsuran_pertama' => 'ADDM'
        ]);
        AngsuranPertama::create([
            'angsuran_pertama' => 'ADDB'
        ]);
    }
}
