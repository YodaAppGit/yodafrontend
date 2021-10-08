<?php

namespace App\Imports;

use App\Models\AngsuranPertama;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AngsuranPertamaImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (
            !isset($row['angsuran_pertama'])
            || $row['angsuran_pertama'] == '*'
        ) {
            return null;
        }
        return new AngsuranPertama([
            'angsuran_pertama' => $row['angsuran_pertama'],
        ]);
    }
    public function headingRow(): int
    {
        return 2;
    }
}
