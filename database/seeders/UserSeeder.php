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

        // Create additional users using factory
        // User::factory()->create();
    }
}