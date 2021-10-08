<?php

namespace App\Imports;

use App\Models\PembayaranAsuransi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PembayaranAsuransiImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (
            !isset($row['pembayaran_asuransi'])
            || $row['pembayaran_asuransi'] == '*'
        ) {
            return null;
        }
        return new PembayaranAsuransi([
            'pembayaran_asuransi' => $row['pembayaran_asuransi'],
        ]);
    }
    public function headingRow(): int
    {
        return 2;
    }
}
