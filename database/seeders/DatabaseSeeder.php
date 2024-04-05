<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $user = User::where('npk', '3712')->first() ?? new User();
        
        $user->npk = '3712';
        $user->name = 'Dyala';
        $user->jabatan = 'Superadmin';
        $user->section = 'Body 1';
        $user->shift = 'non shift';
        $user->status = 'magang';
        $user->password = bcrypt('123456');
        $user->save();
    }
}
