<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Kurikulum;

class GuruMapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data yang sudah ada
        $gurus = Guru::all();
        $mapels = Mapel::all();
        $kurikulums = Kurikulum::all();
        
        if ($gurus->count() > 0 && $mapels->count() > 0 && $kurikulums->count() > 0) {
            // Contoh penugasan guru ke mata pelajaran
            $assignments = [
                [
                    'guru_id' => 1, // Dr. Ahmad Hidayat (Matematika)
                    'mapel_id' => 1, // Matematika
                    'kurikulum_id' => 1, // Kurikulum 2013
                    'kelas' => 'X'
                ],
                [
                    'guru_id' => 1,
                    'mapel_id' => 1,
                    'kurikulum_id' => 1,
                    'kelas' => 'XI'
                ],
                [
                    'guru_id' => 2, // Siti Nurhaliza (Bahasa Indonesia)
                    'mapel_id' => 2, // Bahasa Indonesia
                    'kurikulum_id' => 2, // Kurikulum Merdeka
                    'kelas' => 'X'
                ],
                [
                    'guru_id' => 3, // Budi Santoso (Fisika)
                    'mapel_id' => 4, // Fisika
                    'kurikulum_id' => 1,
                    'kelas' => 'XI'
                ],
                [
                    'guru_id' => 4, // Rina Kartika (Kimia)
                    'mapel_id' => 5, // Kimia
                    'kurikulum_id' => 1,
                    'kelas' => 'XII'
                ],
                [
                    'guru_id' => 5, // Dedi Kurniawan (Biologi)
                    'mapel_id' => 6, // Biologi
                    'kurikulum_id' => 2,
                    'kelas' => 'X'
                ]
            ];

            foreach ($assignments as $assignment) {
                $guru = Guru::find($assignment['guru_id']);
                if ($guru) {
                    $guru->mapels()->attach($assignment['mapel_id'], [
                        'kurikulum_id' => $assignment['kurikulum_id'],
                        'kelas' => $assignment['kelas']
                    ]);
                }
            }
        }
    }
}