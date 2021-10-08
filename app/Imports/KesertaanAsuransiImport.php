<?php

namespace App\Imports;

use App\Models\KesertaanAsuransi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KesertaanAsuransiImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (
            !isset($row['kesertaan_asuransi'])
            || $row['kesertaan_asuransi'] == '*'
        ) {
            return null;
        }
        return new KesertaanAsuransi([
            'kesertaan_asuransi' => $row['kesertaan_asuransi'],
        ]);
    }
    public function headingRow(): int
    {
        return 2;
    }
}
