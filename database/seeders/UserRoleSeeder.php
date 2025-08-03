<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'admin',
                'description' => 'Administrator dengan akses penuh ke sistem'
            ],
            [
                'name' => 'pengaju',
                'description' => 'User yang dapat mengajukan permintaan keuangan'
            ],
            [
                'name' => 'approver',
                'description' => 'User yang dapat menyetujui atau menolak pengajuan'
            ]
        ];

        foreach ($roles as $role) {
            \App\Models\UserRole::firstOrCreate(
                ['name' => $role['name']],
                $role
            );
        }
    }
}
