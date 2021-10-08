<?php

namespace App\Imports;

use App\Models\JenisUnit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JenisImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (
            !isset($row['jenis'])
            || $row['jenis'] == '*'
        ) {
            return null;
        }
        return new JenisUnit([
            'jenis_unit' => $row['jenis'],
        ]);
    }
    public function headingRow(): int
    {
        return 2;
    }
}
