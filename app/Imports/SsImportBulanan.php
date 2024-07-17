<?php

namespace App\Imports;

use App\Models\Ss;
use App\Models\SsBulanan;
use App\Models\User;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SsImportBulanan implements ToModel, WithHeadingRow
{
    use Importable;

    protected $bulan;
    protected $tahun;

    public function __construct($bulan, $tahun)
    {
        $this->bulan = $bulan;
        $this->tahun = $tahun;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Mengambil hanya npk dan status dari baris data
        $npk = isset($row['npk']) ? $row['npk'] : null;
        $status = isset($row['status']) ? $row['status'] : null;

        // Jika npk atau status tidak ada, abaikan baris ini
        if (!$npk || !$status) {
            return null;
        } else {
            return new SsBulanan([
                'npk' => $row['npk'],
                'status' => $row['status'],
                'bulan' => $this->bulan,
                'tahun' => $this->tahun,
            ]);
        }
    }
}


