<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Administrator
        // 2. Admin Gudang
        // 3. Admin Divisi
        // 4. Wakil Rektor 2
        
        Role::create([
            'name' => 'Administrator',
        ]);
        Role::create([
            'name' => 'Admin Gudang',
        ]);
        Role::create([
            'name' => 'Admin Divisi',
        ]);
        Role::create([
            'name' => 'Wakil Rektor 2',
        ]);
    }
}
