<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            BlogPostSeeder::class,
        ]);

        // AdminUserSeeder is intentionally not called here — production
        // installs get their admin account from the install wizard
        // (App\Http\Controllers\Install), not a hardcoded credential.
        // For local dev convenience run it manually:
        // php artisan db:seed --class=AdminUserSeeder
    }
}
