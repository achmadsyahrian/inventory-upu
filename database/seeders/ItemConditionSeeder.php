<?php

namespace Database\Seeders;

use App\Models\ItemCondition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ItemCondition::create([
            'name' => 'Baik',
        ]);
        ItemCondition::create([
            'name' => 'Buruk',
        ]);
        ItemCondition::create([
            'name' => 'Rusak',
        ]);
    }
}
