<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Wali;
use App\Models\User;

class WaliSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users with role 'wali' to associate with wali records
        $waliUsers = User::where('role', 'wali')->get();
        
        // Create sample wali data
        $waliData = [
            [
                'nama' => 'Ahmad Suryanto',
                'alamat' => 'Jl. Merdeka No. 15, Jakarta',
                'telepon' => '08123456789',
                'pekerjaan' => 'Pegawai Negeri Sipil',
                'jenis_kelamin' => 'L'
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'alamat' => 'Jl. Sudirman No. 22, Bandung',
                'telepon' => '08234567890',
                'pekerjaan' => 'Guru',
                'jenis_kelamin' => 'P'
            ],
            [
                'nama' => 'Budi Santoso',
                'alamat' => 'Jl. Gatot Subroto No. 8, Surabaya',
                'telepon' => '08345678901',
                'pekerjaan' => 'Wiraswasta',
                'jenis_kelamin' => 'L'
            ],
            [
                'nama' => 'Dewi Sartika',
                'alamat' => 'Jl. Diponegoro No. 12, Yogyakarta',
                'telepon' => '08456789012',
                'pekerjaan' => 'Ibu Rumah Tangga',
                'jenis_kelamin' => 'P'
            ],
            [
                'nama' => 'Hendra Wijaya',
                'alamat' => 'Jl. Ahmad Yani No. 5, Medan',
                'telepon' => '08567890123',
                'pekerjaan' => 'Dokter',
                'jenis_kelamin' => 'L'
            ],
            [
                'nama' => 'Rina Marlina',
                'alamat' => 'Jl. Veteran No. 18, Semarang',
                'telepon' => '08678901234',
                'pekerjaan' => 'Perawat',
                'jenis_kelamin' => 'P'
            ],
            [
                'nama' => 'Agus Salim',
                'alamat' => 'Jl. Pahlawan No. 25, Malang',
                'telepon' => '08789012345',
                'pekerjaan' => 'Polisi',
                'jenis_kelamin' => 'L'
            ],
            [
                'nama' => 'Maya Sari',
                'alamat' => 'Jl. Kartini No. 7, Denpasar',
                'telepon' => '08890123456',
                'pekerjaan' => 'Bidan',
                'jenis_kelamin' => 'P'
            ],
            [
                'nama' => 'Doni Prasetyo',
                'alamat' => 'Jl. Pemuda No. 30, Palembang',
                'telepon' => '08901234567',
                'pekerjaan' => 'Insinyur',
                'jenis_kelamin' => 'L'
            ],
            [
                'nama' => 'Lestari Indah',
                'alamat' => 'Jl. Cendrawasih No. 14, Makassar',
                'telepon' => '08012345678',
                'pekerjaan' => 'Akuntan',
                'jenis_kelamin' => 'P'
            ]
        ];

        // Create wali records
        foreach ($waliData as $index => $data) {
            // Use existing wali users if available, otherwise create with first available user
            $userId = $waliUsers->isNotEmpty() && isset($waliUsers[$index]) 
                ? $waliUsers[$index]->user_id 
                : User::first()->user_id;
                
            Wali::create(array_merge($data, ['user_id' => $userId]));
        }
    }
}
