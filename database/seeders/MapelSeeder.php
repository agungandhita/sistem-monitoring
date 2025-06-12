<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mapel;
use App\Models\Kurikulum;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil kurikulum pertama sebagai default
        $kurikulum = Kurikulum::first();
        
        if (!$kurikulum) {
            $this->command->warn('Tidak ada kurikulum yang tersedia. Jalankan KurikulumSeeder terlebih dahulu.');
            return;
        }

        $mapels = [
            [
                'kurikulum_id' => $kurikulum->kurikulum_id,
                'kode_mapel' => 'MTK',
                'mapel' => 'Matematika',
                'deskripsi' => 'Mata pelajaran yang mempelajari tentang angka, ruang, dan struktur'
            ],
            [
                'kurikulum_id' => $kurikulum->kurikulum_id,
                'kode_mapel' => 'IPA',
                'mapel' => 'Ilmu Pengetahuan Alam',
                'deskripsi' => 'Mata pelajaran yang mempelajari tentang alam dan fenomena-fenomenanya'
            ],
            [
                'kurikulum_id' => $kurikulum->kurikulum_id,
                'kode_mapel' => 'IPS',
                'mapel' => 'Ilmu Pengetahuan Sosial',
                'deskripsi' => 'Mata pelajaran yang mempelajari tentang masyarakat dan lingkungan sosial'
            ],
            [
                'kurikulum_id' => $kurikulum->kurikulum_id,
                'kode_mapel' => 'BIN',
                'mapel' => 'Bahasa Indonesia',
                'deskripsi' => 'Mata pelajaran bahasa nasional Indonesia'
            ],
            [
                'kurikulum_id' => $kurikulum->kurikulum_id,
                'kode_mapel' => 'ENG',
                'mapel' => 'Bahasa Inggris',
                'deskripsi' => 'Mata pelajaran bahasa internasional'
            ]
        ];

        foreach ($mapels as $mapel) {
            Mapel::create($mapel);
        }
    }
}