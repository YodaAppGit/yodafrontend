<?php

namespace App\Imports;

use App\Models\JarakTempuh;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class JarakTempuhImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (
            !isset($row['jarak_tempuh'])
            || $row['jarak_tempuh'] == '*'
        ) {
            return null;
        }
        return new JarakTempuh([
            'jarak_tempuh' => $row['jarak_tempuh'],
        ]);
    }

    public function headingRow(): int
    {
        return 2;
    }
}
