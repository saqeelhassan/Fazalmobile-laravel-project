<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Seed products from the exported local dataset.
     *
     * Only inserts DB rows - product image files must be uploaded to
     * storage/app/public/products separately, this seeder does not copy them.
     */
    public function run(): void
    {
        $path = database_path('seeders/data/products.json');

        if (! file_exists($path)) {
            $this->command->warn('products.json not found, skipping.');
            return;
        }

        $products = json_decode(file_get_contents($path), true);

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['slug' => $product['slug']],
                [
                    'name'               => $product['name'],
                    'description'        => $product['description'],
                    'short_description'  => $product['short_description'],
                    'price'              => $product['price'],
                    'sale_price'         => $product['sale_price'],
                    'cost_price'         => $product['cost_price'],
                    'sku'                => $product['sku'],
                    'stock'              => $product['stock'],
                    'category'           => $product['category'],
                    'brand'              => $product['brand'],
                    'image'              => $product['image'],
                    'original_image'     => $product['original_image'] ?? null,
                    'gallery'            => $product['gallery'],
                    'status'             => $product['status'],
                    'is_featured'        => $product['is_featured'],
                    'is_on_sale'         => $product['is_on_sale'],
                ]
            );
        }

        $this->command->info(count($products) . ' products seeded.');
    }
}
