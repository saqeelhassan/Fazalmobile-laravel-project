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
        $password    = config('admin.seed.password');
        $usingFallback = blank($password);

        if ($usingFallback) {
            $password = config('admin.seed.default_password');
            $this->command?->warn(
                'ADMIN_PASSWORD is not set; using the default password. '
                . 'You will be required to change it on first login.'
            );
        }

        AdminUser::updateOrCreate(
            ['email' => config('admin.seed.email')],
            [
                'name'                  => config('admin.seed.name'),
                'password'              => Hash::make($password),
                'is_active'             => true,
                'must_change_password'  => $usingFallback,
            ]
        );
    }
}
