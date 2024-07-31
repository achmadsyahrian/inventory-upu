<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Division::create([
            'name' => 'Wakil Rekor 2',
            'division_head' => 'Daifiria M.Kom',
            'dimensions' => NULL,
            'description' => NULL,
            'condition_id' => 1,
            'building_id' => 1,
        ]);
    }
}
