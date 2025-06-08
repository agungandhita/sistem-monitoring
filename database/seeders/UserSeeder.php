<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'nama' => 'Admin',
            'alamat' => 'Jl. Admin No. 1',
            'telepon' => '08123456789',
            'email' => 'admin@sismo.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin'
        ]);

        // Create guru user
        User::create([
            'nama' => 'Guru',
            'alamat' => 'Jl. Guru No. 1',
            'telepon' => '08234567890',
            'email' => 'guru@sismo.com',
            'password' => Hash::make('guru123'),
            'role' => 'guru'
        ]);

        // Create wali user
        User::create([
            'nama' => 'Wali',
            'alamat' => 'Jl. Wali No. 1',
            'telepon' => '08345678901',
            'email' => 'wali@sismo.com',
            'password' => Hash::make('wali123'),
            'role' => 'wali'
        ]);

        // Create additional users using factory
        User::factory(7)->create();
    }
}