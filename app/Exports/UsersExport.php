<?php

namespace App\Exports;

use App\Models\User;
use App\Models\Org;
use App\Models\Departemen;
use App\Models\Section;
use App\Models\Group;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
     * Return a collection of users and their related org data.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $users = User::all();
        $data = $users->map(function ($item) {
            $org = Org::where('npk', $item->npk)->first();
            $deptName = $org ? Departemen::where('id_dept', $org->dept)->value('id_dept') : 'Tidak ada departemen';
            $sectName = $org ? Section::where('id_section', $org->sect)->value('id_section') : 'Tidak ada section';
            $groupName = $org ? Group::where('id_group', $org->grp)->value('id_group') : 'Tidak ada group';

            return [
                'npk' => $item->npk,
                'name' => $item->name,
                'group' => $groupName,
                'section' => $sectName,
                'department' => $deptName,
                'division' => '1-001',
                'shift' => $item->shift,
                'jabatan' => $item->jabatan,
                'status' => $item->status,
            ];
        });

        return collect($data);
    }

    /**
     * Return the headings for the exported Excel file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'NPK',
            'Name',
            'Group',
            'Section',
            'Department',
            'Division',
            'Shift',
            'Jabatan',
            'Status',
        ];
    }
}

