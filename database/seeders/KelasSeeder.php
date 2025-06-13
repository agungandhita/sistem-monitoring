<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kelas;
use App\Models\Kurikulum;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil kurikulum yang ada
        $kurikulum = Kurikulum::first();
        
        if (!$kurikulum) {
            $this->command->error('Tidak ada data kurikulum. Jalankan KurikulumSeeder terlebih dahulu.');
            return;
        }
        
        $tahunAjaran = $kurikulum->tahun_ajaran;
        
        // Data kelas untuk SD (tingkat 1-6)
        $kelasData = [
            // Kelas 1
            ['nama_kelas' => '1A', 'tingkat' => 1],
            ['nama_kelas' => '1B', 'tingkat' => 1],
            
            // Kelas 2
            ['nama_kelas' => '2A', 'tingkat' => 2],
            ['nama_kelas' => '2B', 'tingkat' => 2],
            
            // Kelas 3
            ['nama_kelas' => '3A', 'tingkat' => 3],
            ['nama_kelas' => '3B', 'tingkat' => 3],
            
            // Kelas 4
            ['nama_kelas' => '4A', 'tingkat' => 4],
            ['nama_kelas' => '4B', 'tingkat' => 4],
            
            // Kelas 5
            ['nama_kelas' => '5A', 'tingkat' => 5],
            ['nama_kelas' => '5B', 'tingkat' => 5],
            
            // Kelas 6
            ['nama_kelas' => '6A', 'tingkat' => 6],
            ['nama_kelas' => '6B', 'tingkat' => 6],
        ];
        
        foreach ($kelasData as $data) {
            Kelas::create([
                'nama_kelas' => $data['nama_kelas'],
                'tingkat' => $data['tingkat'],
                'tahun_ajaran' => $tahunAjaran,
                'kurikulum_id' => $kurikulum->kurikulum_id,
                'kapasitas' => 30,
                'status' => 'aktif'
            ]);
        }
        
        $this->command->info('Data kelas berhasil dibuat.');
    }
}