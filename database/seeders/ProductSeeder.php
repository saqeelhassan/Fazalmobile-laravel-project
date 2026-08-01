<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Intentionally left empty. Real products are added through the
     * admin panel (/admin/products) rather than seeded placeholder data.
     */
    public function run(): void
    {
        $this->command->info('ProductSeeder is a no-op — add products via the admin panel.');
    }
}
