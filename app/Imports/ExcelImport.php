<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ExcelImport implements WithMultipleSheets
{
    /**
     * @param Collection $collection
     */
    public function sheets(): array
    {
        return [
            'Merek, model & varian' => new MMVImport(),
            'Provinsi, kota & kecamatan' => new IndonesiaImport(),
            'Kantor' => new KantorImport(),
            'Tahun' => new TahunImport(),
            'Jarak tempuh' => new JarakTempuhImport(),
            'Warna' => new WarnaImport(),
            'Bahan bakar' => new BahanBakarImport(),
            'Transmisi' => new TransmisiImport(),
            'Kondisi unit' => new KondisiImport(),
            'Jenis unit' => new JenisImport(),
            'Tujuan penggunaan' => new TujuanPenggunaanImport(),
            'Kategori' => new KategoriImport(),
            'Jenis asuransi' => new TipeAsuransiImport(),
            'Kesertaan asuransi' => new KesertaanAsuransiImport(),
            'Loan type' => new LoanTypeImport(),
            'Nilai pertanggungan' => new NilaiPertanggunganImport(),
            'Pembayaran asuransi' => new PembayaranAsuransiImport(),
            'Tenor' => new TenorImport(),
            'Angsuran pertama' => new AngsuranPertamaImport(),
        ];
    }
}
