<?php

namespace App\Imports;

use App\Models\Org;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class UsersImport implements ToModel, WithHeadingRow
{
    use Importable;
    /**
    * @param array $row
*
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
       

        // Konversi tanggal dari format d/m/Y ke Y-m-d
        try {
            // Uji apakah tanggal dalam format tanggal Excel numerik
            if (is_numeric($row['tanggal_masuk'])) {
                $tglMasuk = Date::excelToDateTimeObject($row['tanggal_masuk'])->format('Y-m-d');
            } else {
                $tglMasuk = \DateTime::createFromFormat('d/m/Y', $row['tanggal_masuk']);
                if ($tglMasuk) {
                    $tglMasuk = $tglMasuk->format('Y-m-d');
                } else {
                    throw new \Exception('Format tanggal tidak valid untuk NPK: ' . $row['npk']);
                }
            }
        } catch (\Exception $e) {
            throw new \Exception('Format tanggal tidak valid untuk NPK: ' . $row['npk'] . ' dengan error: ' . $e->getMessage());
        }

         User::updateOrCreate(
                ['npk' => $row['npk']],
                [
                    'name' =>$row['nama'],
                    'password' => $row['password'], // Jika password perlu di-hash
                    'tgl_masuk' => $tglMasuk,   
                    'jabatan' => $row['jabatan'],
                    'shift' => $row['shift'],
                    'status' => $row['status']
                ]
            );

            // Update or create org data
            Org::updateOrCreate(
                ['npk' => $row['npk']],
                [
                    'sect' => $row['section'],
                    'grp' => $row['group'],
                    'dept' => $row['department'],
                    'division' => $row['divisi']
                ]
            );
    }
}
