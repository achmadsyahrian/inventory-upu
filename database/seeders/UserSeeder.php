<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Administrator',
            'username' => 'administrator',
            'role_id' => '1',
            'password' => bcrypt('administrator')
        ]);
        User::create([
            'name' => 'Admin Inventori',
            'username' => 'admininventori',
            'role_id' => '2',
            'password' => bcrypt('potensiutama')
        ]);
    }
}
