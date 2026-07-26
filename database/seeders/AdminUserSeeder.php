<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\AdminUser::updateOrCreate(
            ['email' => 'admin@fazalmobile.com'],
            [
                'name'      => 'Admin',
                'password'  => \Illuminate\Support\Facades\Hash::make('Admin@1234'),
                'is_active' => true,
            ]
        );
    }
}
