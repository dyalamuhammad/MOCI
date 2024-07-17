<?php

namespace App\Imports;

use App\Models\Org;
use App\Models\User;
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
         User::updateOrCreate(
                ['npk' => $row['npk']],
                [
                    'name' =>$row['nama'],
                    'password' => $row['password'], // Jika password perlu di-hash
                    'jabatan' => $row['jabatan'],
                    'tgl_masuk' => $row['tgl_masuk'],
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
