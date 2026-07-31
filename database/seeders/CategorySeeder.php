<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Real category list, exported from the live store.
     */
    public function run(): void
    {
        $categories = [
            'Smart Watches',
            'Games',
            'Airbuds',
            'Cables',
            'Projector',
            'Charger',
            'Cooling Fan',
            'Microphone',
            'Speakers',
            'Headphones',
            'Gift Wrap',
        ];

        foreach ($categories as $name) {
            Category::withTrashed()->updateOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'status' => 'active']
            );
        }
    }
}
