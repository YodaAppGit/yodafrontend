<?php

namespace App\Imports;

use App\Models\TipeAsuransi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TipeAsuransiImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (
            !isset($row['tipe_asuransi'])
            || $row['tipe_asuransi'] == '*'
        ) {
            return null;
        }
        return new TipeAsuransi([
            'tipe_asuransi' => $row['tipe_asuransi'],
        ]);
    }
    public function headingRow(): int
    {
        return 2;
    }
}
