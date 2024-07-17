<?php

namespace App\Imports;

use App\Models\Ss;
use App\Models\User;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SsImport implements ToModel, WithHeadingRow
{
    private $month;

    public function __construct($month)
    {
        $this->month = $month;
    }

    public function model(array $row)
    {
        // Ambil bulan yang diinisialisasi dari konstruktor
        $month = $this->month;

        // Cari data yang sudah ada berdasarkan NPK
        $existingData = Ss::where('npk', $row['npk'])->first();

        if ($existingData) {
            // Jika data sudah ada, update bulan yang sesuai
            $existingData->update([$month => $row[$month]]);
            return $existingData;
        } else {
            // Jika data belum ada, buat data baru
            return new Ss([
                'npk' => $row['npk'],
                $month => $row[$month]
            ]);
        }
    }
}

