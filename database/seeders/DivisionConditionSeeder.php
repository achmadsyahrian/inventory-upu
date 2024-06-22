<?php

namespace Database\Seeders;

use App\Models\DivisionCondition;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionConditionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Baik
        // 2. Perlu Perbaikan
        // 3. Buruk
        
        DivisionCondition::create([
            'name' => 'Baik',
        ]);
        DivisionCondition::create([
            'name' => 'Perlu Perbaikan',
        ]);
        DivisionCondition::create([
            'name' => 'Buruk',
        ]);
    }
}
