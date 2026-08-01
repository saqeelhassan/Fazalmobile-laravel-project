<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('status')->default('active');
            $table->softDeletes();
            $table->timestamps();
        });

        foreach (['Smart Watches', 'Games', 'Airbuds', 'Cables', 'Projector', 'Charger', 'Cooling Fan'] as $name) {
            \Illuminate\Support\Facades\DB::table('categories')->insert([
                'name'       => $name,
                'slug'       => Str::slug($name),
                'status'     => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
