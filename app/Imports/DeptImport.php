<?php

namespace App\Imports;

use App\Models\Departemen;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class DeptImport implements ToModel, WithHeadingRow
{
    use Importable;
    /**
    * @param array $row
*
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
         Departemen::updateOrCreate(
                ['id_dept' => $row['id_dept']],
                [
                    'dept' =>$row['dept'],
                    'npk_cord' => $row['npk_cord'], // Jika password perlu di-hash
                    'id_div' => $row['id_div'],
                    'part' => 'dept'
                ]
            );
    }
}
