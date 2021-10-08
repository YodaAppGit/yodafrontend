<?php

namespace App\Imports;

use App\Models\Kondisi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KondisiImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (
            !isset($row['transmisi'])
            || $row['transmisi'] == '*'
        ) {
            return null;
        }
        return new Kondisi([
            'kondisi' => $row['transmisi'],
        ]);
    }
    public function headingRow(): int
    {
        return 2;
    }
}
