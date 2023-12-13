<?php

namespace Database\Seeders;

use App\Models\Category as ModelsCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Category extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ModelsCategory::create([
            'category' => 'Electronic',
        ]);
        
        ModelsCategory::create([
            'category' => 'Food',
        ]);

        ModelsCategory::create([
            'category' => 'Accessories',
        ]);

    }
}
