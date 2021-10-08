<?php

namespace App\Imports;

use App\Models\TujuanPenggunaan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TujuanPenggunaanImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (
            !isset($row['tujuan_penggunaan'])
            || $row['tujuan_penggunaan'] == '*'
        ) {
            return null;
        }
        return new TujuanPenggunaan([
            'tujuan_penggunaan' => $row['tujuan_penggunaan'],
        ]);
    }
    public function headingRow(): int
    {
        return 2;
    }
}
