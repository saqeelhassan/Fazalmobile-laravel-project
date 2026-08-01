<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed categories from the exported local dataset.
     */
    public function run(): void
    {
        $path = database_path('seeders/data/categories.json');

        if (! file_exists($path)) {
            $this->command->warn('categories.json not found, skipping.');
            return;
        }

        $categories = json_decode(file_get_contents($path), true);

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['slug' => $category['slug']],
                [
                    'name'   => $category['name'],
                    'status' => $category['status'],
                ]
            );
        }

        $this->command->info(count($categories) . ' categories seeded.');
    }
}
