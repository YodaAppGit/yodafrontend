<?php

namespace App\Imports;

use App\Models\LoanType;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class LoanTypeImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (
            !isset($row['loan_type'])
            || $row['loan_type'] == '*'
        ) {
            return null;
        }
        return new LoanType([
            'loan_type' => $row['loan_type'],
        ]);
    }
    public function headingRow(): int
    {
        return 2;
    }
}
