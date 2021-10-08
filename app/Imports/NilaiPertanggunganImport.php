<?php

namespace App\Imports;

use App\Models\NilaiPertanggungan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class NilaiPertanggunganImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (
            !isset($row['nilai_pertanggungan'])
            || $row['nilai_pertanggungan'] == '*'
        ) {
            return null;
        }
        return new NilaiPertanggungan([
            'nilai_pertanggungan' => $row['nilai_pertanggungan'],
        ]);
    }
    public function headingRow(): int
    {
        return 2;
    }
}
