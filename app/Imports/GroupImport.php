<?php

namespace App\Imports;

use App\Models\Group;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class GroupImport implements ToModel, WithHeadingRow
{
    use Importable;
    /**
    * @param array $row
*
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
         Group::updateOrCreate(
                ['id_group' => $row['id_group']],
                [
                    'nama_group' =>$row['nama_group'],
                    'npk_cord' => $row['npk_cord'], // Jika password perlu di-hash
                    'id_section' => $row['id_section'],
                    'part' => 'group'
                ]
            );
    }
}
