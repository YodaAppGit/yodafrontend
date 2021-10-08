<?php

namespace App\Imports;

use App\Models\Kategori;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KategoriImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (
            !isset($row['kategori'])
            || $row['kategori'] == '*'
        ) {
            return null;
        }
        return new Kategori([
            'kategori' => $row['kategori'],
        ]);
    }
    public function headingRow(): int
    {
        return 2;
    }
}
