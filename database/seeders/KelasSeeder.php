<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tahunAjaran = '2024/2025';
        $kelasData = [];
        
        // Create classes for grades 1-6 with multiple sections (A, B, C)
        for ($tingkat = 1; $tingkat <= 6; $tingkat++) {
            foreach (['A', 'B', 'C'] as $section) {
                $kelasData[] = [
                    'nama_kelas' => $tingkat . $section,
                    'tingkat' => $tingkat,
                    'tahun_ajaran' => $tahunAjaran,
                    'kapasitas_maksimal' => 30,
                    'deskripsi' => "Kelas {$tingkat}{$section} untuk tingkat {$tingkat}",
                    'status' => 'aktif',
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }
        }
        
        Kelas::insert($kelasData);
        
        $this->command->info('Kelas data seeded successfully!');
    }
}
