<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mapel;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mapels = [
            [
                'kode_mapel' => 'MTK',
                'mapel' => 'Matematika',
                'deskripsi' => 'Mata pelajaran matematika untuk semua tingkat'
            ],
            [
                'kode_mapel' => 'BIN',
                'mapel' => 'Bahasa Indonesia',
                'deskripsi' => 'Mata pelajaran bahasa Indonesia'
            ],
            [
                'kode_mapel' => 'BING',
                'mapel' => 'Bahasa Inggris',
                'deskripsi' => 'Mata pelajaran bahasa Inggris'
            ],
            [
                'kode_mapel' => 'FIS',
                'mapel' => 'Fisika',
                'deskripsi' => 'Mata pelajaran fisika untuk tingkat SMA'
            ],
            [
                'kode_mapel' => 'KIM',
                'mapel' => 'Kimia',
                'deskripsi' => 'Mata pelajaran kimia untuk tingkat SMA'
            ],
            [
                'kode_mapel' => 'BIO',
                'mapel' => 'Biologi',
                'deskripsi' => 'Mata pelajaran biologi untuk tingkat SMA'
            ],
            [
                'kode_mapel' => 'SEJ',
                'mapel' => 'Sejarah',
                'deskripsi' => 'Mata pelajaran sejarah Indonesia dan dunia'
            ],
            [
                'kode_mapel' => 'GEO',
                'mapel' => 'Geografi',
                'deskripsi' => 'Mata pelajaran geografi'
            ],
            [
                'kode_mapel' => 'EKO',
                'mapel' => 'Ekonomi',
                'deskripsi' => 'Mata pelajaran ekonomi untuk tingkat SMA'
            ],
            [
                'kode_mapel' => 'SOS',
                'mapel' => 'Sosiologi',
                'deskripsi' => 'Mata pelajaran sosiologi'
            ]
        ];

        foreach ($mapels as $mapel) {
            Mapel::create($mapel);
        }
    }
}