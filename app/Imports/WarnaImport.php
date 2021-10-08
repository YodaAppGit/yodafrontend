<?php

namespace App\Imports;

use App\Models\Warna;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WarnaImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (
            !isset($row['warna'])
            || $row['warna'] == '*'
        ) {
            return null;
        }
        return new Warna([
            'warna' => $row['warna'],
        ]);
    }
    public function headingRow(): int
    {
        return 2;
    }
}
