<?php

namespace App\Imports;

use App\Models\TahunPembuatan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TahunImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (
            !isset($row['tahun'])
            || $row['tahun'] == '*'
        ) {
            return null;
        }
        return new TahunPembuatan([
            'tahun' => $row['tahun'],
        ]);
    }
    public function headingRow(): int
    {
        return 2;
    }
}
