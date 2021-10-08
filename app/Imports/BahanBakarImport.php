<?php

namespace App\Imports;

use App\Models\BahanBakar;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BahanBakarImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (
            !isset($row['bahan_bakar'])
            || $row['bahan_bakar'] == '*'
        ) {
            return null;
        }
        return new BahanBakar([
            'bahan_bakar' => $row['bahan_bakar'],
        ]);
    }
    public function headingRow(): int
    {
        return 2;
    }
}
