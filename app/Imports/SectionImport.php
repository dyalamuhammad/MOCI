<?php

namespace App\Imports;

use App\Models\Section;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class SectionImport implements ToModel, WithHeadingRow
{
    use Importable;
    /**
    * @param array $row
*
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
         Section::updateOrCreate(
                ['id_section' => $row['id_section']],
                [
                    'section' =>$row['section'],
                    'npk_cord' => $row['npk_cord'], // Jika password perlu di-hash
                    'id_dept' => $row['id_dept'],
                    'part' => 'section'
                ]
            );
    }
}
