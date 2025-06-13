<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // 1. TAHAP SETUP AWAL
            UserSeeder::class,          // Admin user
            
            // 2. TAHAP DATA MASTER (Urutan penting!)
            KurikulumSeeder::class,     // Kurikulum HARUS duluan
            MapelSeeder::class,      
            GuruMapelSeeder::class,     // Mapel butuh Kurikulum
            KelasSeeder::class,         // Kelas untuk pengelompokan
            
            // 3. TAHAP SDM
            WaliSeeder::class,       // Wali HARUS duluan (belum ada)
            SiswaSeeder::class,         // Siswa butuh Wali & Kelas
            GuruSeeder::class,          // Guru bisa bersamaan
            Jadwalseeder::class,
            
            // 4. TAHAP ASSIGNMENT
              // Assignment butuh Guru, Mapel, Kurikulum
        ]);
    }
}
