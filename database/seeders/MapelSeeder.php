<?php

namespace Database\Seeders;

use App\Models\Mapel;
use Illuminate\Database\Seeder;

class MapelSeeder extends Seeder
{
    public function run(): void
    {
        $mapel = [
            [
                'kode_mapel' => 'MTK',
                'nama_mapel' => 'Matematika',
                'deskripsi' => 'Pelajaran tentang ilmu hitung dan logika',
            ],
            [
                'kode_mapel' => 'BIN',
                'nama_mapel' => 'Bahasa Indonesia',
                'deskripsi' => 'Pelajaran tentang bahasa nasional Indonesia',
            ],
            [
                'kode_mapel' => 'IPA',
                'nama_mapel' => 'Ilmu Pengetahuan Alam',
                'deskripsi' => 'Pelajaran tentang ilmu alam dan sains dasar',
            ],
            [
                'kode_mapel' => 'IPS',
                'nama_mapel' => 'Ilmu Pengetahuan Sosial',
                'deskripsi' => 'Pelajaran tentang ilmu sosial dan kemasyarakatan',
            ],
            [
                'kode_mapel' => 'PAI',
                'nama_mapel' => 'Pendidikan Agama Islam',
                'deskripsi' => 'Pelajaran tentang agama Islam',
            ],
        ];

        foreach ($mapel as $m) {
            Mapel::create($m);
        }
    }
}