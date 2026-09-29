<?php

namespace Database\Seeders;

use App\Models\AdminUser;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = config('admin.seed.password');

        if (blank($password)) {
            $this->command?->warn('ADMIN_PASSWORD is not set; skipping admin user creation.');

            return;
        }

        AdminUser::updateOrCreate(
            ['email' => config('admin.seed.email')],
            [
                'name'      => config('admin.seed.name'),
                'password'  => Hash::make($password),
                'is_active' => true,
            ]
        );
    }
}
