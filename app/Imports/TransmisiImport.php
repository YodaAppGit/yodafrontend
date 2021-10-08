<?php

namespace App\Imports;

use App\Models\Transmisi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TransmisiImport implements ToModel, WithHeadingRow
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
        return new Transmisi([
            'transmisi' => $row['transmisi'],
        ]);
    }
    public function headingRow(): int
    {
        return 2;
    }
}
