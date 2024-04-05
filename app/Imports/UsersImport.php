<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;

class UsersImport implements ToModel
{
    use Importable;
    /**
    * @param array $row
*
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'npk' => $row[0],
            'name' => $row[1],
            'password' => $row[2],
            'jabatan' => $row[3],
            'shift' => $row[4],
            'status' => $row[5],
            'section' => $row[6]
            
        ]);
    }
}
