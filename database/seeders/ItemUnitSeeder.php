<?php

namespace Database\Seeders;

use App\Models\ItemUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $units = [
            ['symbol' => 'Pcs', 'name' => 'Pieces'],
            ['symbol' => NULL, 'name' => 'Kotak'],
            ['symbol' => NULL, 'name' => 'Set'],
            ['symbol' => 'Kg', 'name' => 'Kilogram'],
            ['symbol' => 'g', 'name' => 'Gram'],
            ['symbol' => NULL, 'name' => 'Liter'],
            ['symbol' => 'Ml', 'name' => 'Milliliter'],
            ['symbol' => 'm', 'name' => 'Meter'],
            ['symbol' => 'cm', 'name' => 'Centimeter'],
            ['symbol' => NULL, 'name' => 'Lusin'],
            ['symbol' => NULL, 'name' => 'Bungkus'],
            ['symbol' => NULL, 'name' => 'Blok'],
            ['symbol' => NULL, 'name' => 'Lembar'],
            ['symbol' => NULL, 'name' => 'Rim'],
            ['symbol' => NULL, 'name' => 'Unit'],
        ];
        
        ItemUnit::insert($units);        
    }
}
