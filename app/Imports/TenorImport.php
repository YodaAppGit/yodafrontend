<?php

namespace App\Imports;

use App\Models\Tenor;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TenorImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (
            !isset($row['tenor'])
            || $row['tenor'] == '*'
        ) {
            return null;
        }
        return new Tenor([
            'tenor' => $row['tenor'],
        ]);
    }
    public function headingRow(): int
    {
        return 2;
    }
}
