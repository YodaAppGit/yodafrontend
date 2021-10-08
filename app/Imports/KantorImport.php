<?php

namespace App\Imports;

use App\Models\Area;
use App\Models\Kantor;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KantorImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (
            !isset($row['kode_cabang'])
            || !isset($row['nama_cabang'])
            || !isset($row['nama_pic_cabang'])
            || $row['kode_cabang'] == '*'
            || $row['nama_cabang'] == '*'
            || $row['nama_pic_cabang'] == '*'
        ) {
            return null;
        }


        $area = Area::where('nama_area', $row['nama_area'])
            ->where('area_manager', $row['area_manager'])->first();
        if (!$area) {
            Area::create([
                'nama_area' => $row['nama_area'],
                'area_manager' => $row['area_manager'],
            ]);
        }

        return new Kantor([
            'kode_cabang' => $row['kode_cabang'],
            'nama_cabang' => $row['nama_cabang'],
            'no_telepon' => '-',
            'alamat' => '-',
            'pic' => 1,
            'tanggal_registrasi' => Carbon::now(),
        ]);
    }
    public function headingRow(): int
    {
        return 2;
    }
}
