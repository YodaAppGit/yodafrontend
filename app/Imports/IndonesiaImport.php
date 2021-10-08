<?php

namespace App\Imports;

use App\Models\Indonesia;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IndonesiaImport implements ToModel, WithHeadingRow
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        if (
            !isset($row['provinsi'])
            || !isset($row['kota'])
            || !isset($row['kecamatan'])
            || $row['provinsi'] == '*'
            || $row['kota'] == '*'
            || $row['kecamatan'] == '*'
        ) {
            return null;
        }

        return new Indonesia([
            'provinsi' => $row['provinsi'],
            'kota' => $row['kota'],
            'kecamatan' => $row['kecamatan'],
        ]);
    }

    public function headingRow(): int
    {
        return 2;
    }
}
