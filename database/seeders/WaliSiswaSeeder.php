<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Wali;
use App\Models\Siswa;

class WaliSiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data wali dan siswa
        $walis = Wali::all();
        $siswas = Siswa::all();
        
        if ($walis->isEmpty() || $siswas->isEmpty()) {
            $this->command->warn('Data wali atau siswa belum tersedia. Jalankan seeder terkait terlebih dahulu.');
            return;
        }
        
        // Hapus data wali_siswa yang sudah ada untuk mencegah duplikasi
        DB::table('wali_siswa')->delete();
        
        $waliSiswaData = [];
        
        // Setiap wali bisa mengasuh 1-3 siswa
        foreach ($walis as $index => $wali) {
            $jumlahSiswa = rand(1, 3);
            
            // Ambil siswa secara acak untuk wali ini
            $siswaUntukWali = $siswas->random(min($jumlahSiswa, $siswas->count()));
            
            foreach ($siswaUntukWali as $siswa) {
                // Cek apakah siswa sudah memiliki wali
                $sudahAda = collect($waliSiswaData)->where('siswa_id', $siswa->siswa_id)->isNotEmpty();
                
                if (!$sudahAda) {
                    $waliSiswaData[] = [
                        'wali_id' => $wali->wali_id,
                        'siswa_id' => $siswa->siswa_id,
                        'hubungan' => $this->getRandomHubungan(),
                        'created_at' => now(),
                        'updated_at' => now()
                    ];
                }
            }
            
            // Hapus siswa yang sudah diassign dari collection
            $siswaIds = collect($waliSiswaData)->pluck('siswa_id')->toArray();
            $siswas = $siswas->whereNotIn('siswa_id', $siswaIds);
            
            // Jika sudah tidak ada siswa yang tersisa, break
            if ($siswas->isEmpty()) {
                break;
            }
        }
        
        // Pastikan semua siswa memiliki wali
        if (!$siswas->isEmpty()) {
            foreach ($siswas as $siswa) {
                $waliRandom = $walis->random();
                $waliSiswaData[] = [
                    'wali_id' => $waliRandom->wali_id,
                    'siswa_id' => $siswa->siswa_id,
                    'hubungan' => $this->getRandomHubungan(),
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }
        
        // Insert data ke database
        DB::table('wali_siswa')->insert($waliSiswaData);
        
        $this->command->info('Data relasi wali-siswa berhasil dibuat: ' . count($waliSiswaData) . ' relasi.');
    }
    
    /**
     * Get random hubungan keluarga
     */
    private function getRandomHubungan(): string
    {
        $hubungan = ['Ayah', 'Ibu', 'Kakek', 'Nenek', 'Paman', 'Bibi', 'Wali'];
        return $hubungan[array_rand($hubungan)];
    }
}