<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'npk'        => '1001',
                'name'       => 'Dummy Super Admin',
                'jabatan'    => 'Superadmin',
                'shift'      => 'Non-Shift',
                'status'     => 'Active',
                'password'   => Hash::make('password'), // Menggunakan bcrypt otomatis
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'npk'        => '2001',
                'name'       => 'Division Head',
                'jabatan'    => 'DH',
                'shift'      => 'Non-Shift',
                'status'     => 'Active',
                'password'   => Hash::make('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'npk'        => '3001',
                'name'       => 'Supervisor',
                'jabatan'    => 'SPV',
                'shift'      => 'Non-Shift',
                'status'     => 'Active',
                'password'   => Hash::make('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'npk'        => '4001',
                'name'       => 'Dummy Foreman',
                'jabatan'    => 'FRM',
                'shift'      => 'Non-Shift',
                'status'     => 'Active',
                'password'   => Hash::make('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'npk'        => '5001',
                'name'       => 'Dummy Team Leader',
                'jabatan'    => 'TL',
                'shift'      => 'Non-Shift',
                'status'     => 'Active',
                'password'   => Hash::make('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'npk'        => '6001',
                'name'       => 'Dummy Team Member',
                'jabatan'    => 'TM',
                'shift'      => 'Non-Shift',
                'status'     => 'Active',
                'password'   => Hash::make('password'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];
        foreach ($users as $user) {
            DB::table('users')->updateOrInsert(
                ['npk' => $user['npk']], // Kondisi pengecekan (Unique Key)
                [
                    'name'       => $user['name'],
                    'jabatan'    => $user['jabatan'],
                    'shift'      => $user['shift'],
                    'status'     => $user['status'],
                    'password'   => $user['password'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }

    }
}