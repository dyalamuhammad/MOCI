<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrganisasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();

        // 1. SEEDER SECTION
        $sections = [
            [
                'id_section' => 'sect-001', 
                'section' => 'Dummy Section 1', 
                'npk_cord' => '3001', 
                'id_dept' => 'dept-001', 
                'part' => 'section', 
                'created_at' => $now, 
                'updated_at' => $now
                ],
        ];

        foreach ($sections as $sec) {
            DB::table('section')->updateOrInsert(['id_section' => $sec['id_section']], $sec);
        }

        // 2. SEEDER DEPARTMENT
        // Sesuai request: id_dept, nama_dept, npk_cord, id_section, part
        $departments = [
            [
                'id_dept' => 'dept-001', 
                'dept' => 'Dummy Department 1', 
                'npk_cord' => '2001', 
                'id_div' => 'sect-001', 
                'part' => 'dept', 
                'created_at' => $now, 
                'updated_at' => $now
            ],
        ];

        foreach ($departments as $dept) {
            DB::table('department')->updateOrInsert(['id_dept' => $dept['id_dept']], $dept);
        }

        // 3. SEEDER GROUP
        $groups = [
            [
                'id_group' => 'grp-001', 
                'nama_group' => 'Dummy Group 1', 
                'npk_cord' => '4001', 
                'id_section' => 'sect-001', 
                'part' => 'group', 
                'created_at' => $now, 
                'updated_at' => $now
            ],
        ];

        foreach ($groups as $group) {
            DB::table('groupfrm')->updateOrInsert(['id_group' => $group['id_group']], $group);
        }
    }
}
