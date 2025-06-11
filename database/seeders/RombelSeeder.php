<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rombel;
use App\Models\Kelas;
use App\Models\Guru;

class RombelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunAjaran = '2024/2025';
        $rombelData = [];
        
        // Get all classes
        $kelasList = Kelas::where('tahun_ajaran', $tahunAjaran)->get();
        
        // Get available teachers for wali kelas
        $gurus = Guru::limit(18)->get(); // Assuming we have enough teachers
        $guruIndex = 0;
        
        foreach ($kelasList as $kelas) {
            // Create 1-2 rombels per class
            $rombelCount = ($kelas->tingkat <= 3) ? 2 : 1; // More rombels for lower grades
            
            for ($i = 1; $i <= $rombelCount; $i++) {
                $rombelData[] = [
                    'kelas_id' => $kelas->kelas_id,
                    'nama_rombel' => "Rombel " . chr(64 + $i), // A, B, C, etc.
                    'tahun_ajaran' => $tahunAjaran,
                    'kapasitas_maksimal' => 25,
                    'jumlah_siswa_saat_ini' => 0,
                    'wali_kelas_id' => $gurus[$guruIndex % $gurus->count()]->guru_id ?? null,
                    'deskripsi' => "Rombongan belajar " . chr(64 + $i) . " untuk kelas {$kelas->nama_kelas}",
                    'status' => 'aktif',
                    'created_at' => now(),
                    'updated_at' => now()
                ];
                $guruIndex++;
            }
        }
        
        Rombel::insert($rombelData);
        
        $this->command->info('Rombel data seeded successfully!');
    }
}
