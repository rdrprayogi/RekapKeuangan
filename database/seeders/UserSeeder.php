<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = \App\Models\UserRole::where('name', 'admin')->first();
        $pengajuRole = \App\Models\UserRole::where('name', 'pengaju')->first();
        $approverRole = \App\Models\UserRole::where('name', 'approver')->first();

        // Create Admin User
        \App\Models\User::firstOrCreate(
            ['email' => 'admin@politeknik.ac.id'],
            [
                'name' => 'Administrator',
                'password' => bcrypt('password'),
                'user_role_id' => $adminRole->id,
                'nip' => '1234567890',
                'jabatan' => 'Administrator Sistem',
                'unit_kerja' => 'IT',
                'is_active' => true
            ]
        );

        // Create Pengaju User
        \App\Models\User::firstOrCreate(
            ['email' => 'pengaju@politeknik.ac.id'],
            [
                'name' => 'Dosen Pengaju',
                'password' => bcrypt('password'),
                'user_role_id' => $pengajuRole->id,
                'nip' => '0987654321',
                'jabatan' => 'Dosen',
                'unit_kerja' => 'Teknik Informatika',
                'is_active' => true
            ]
        );

        // Create Approver User
        \App\Models\User::firstOrCreate(
            ['email' => 'approver@politeknik.ac.id'],
            [
                'name' => 'Ketua Jurusan',
                'password' => bcrypt('password'),
                'user_role_id' => $approverRole->id,
                'nip' => '1122334455',
                'jabatan' => 'Ketua Jurusan',
                'unit_kerja' => 'Teknik Informatika',
                'is_active' => true
            ]
        );
    }
}
