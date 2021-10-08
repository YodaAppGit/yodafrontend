<?php

namespace App\Imports;

use App\Models\MerekModelVarian;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MMVImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (
            !isset($row['merek'])
            || !isset($row['model'])
            || !isset($row['varian'])
            || $row['merek'] == '*'
            || $row['model'] == '*'
            || $row['varian'] == '*'
        ) {
            return null;
        }

        return new MerekModelVarian([
            'merek' => $row['merek'],
            'model' => $row['model'],
            'varian' => $row['varian'],
        ]);
    }
    public function headingRow(): int
    {
        return 2;
    }
}
