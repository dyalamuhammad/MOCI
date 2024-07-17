<?php

namespace App\Exports;

use App\Models\Ss;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SsExport implements FromCollection, WithHeadings
{
    public function collection()
{
    return Ss::all()->map(function ($item, $key) {
        $org = \App\Models\Org::where('npk', $item->npk)->first();
        $deptName = $org
            ? \App\Models\Departemen::where('id_dept', $org->dept)->value('dept')
            : 'Tidak ada departemen';

        return [
            'No' => $key + 1,
            'NPK' => $item->npk,
            'Nama' => $item->nama,
            'Departemen' => $deptName,
            'Januari' => $item->januari,
            'Februari' => $item->februari,
            'Maret' => $item->maret,
            'April' => $item->april,
            'Mei' => $item->mei,
            'Juni' => $item->juni,
            'Juli' => $item->juli,
            'Agustus' => $item->agustus,
            'September' => $item->september,
            'Oktober' => $item->oktober,
            'November' => $item->november,
            'Desember' => $item->desember,
        ];
    });
}


    public function headings(): array
    {
        return [
            'No',
            'NPK',
            'Nama',
            'Departemen',
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember',
        ];
    }
}
