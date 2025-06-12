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
            // Ambil mapel berdasarkan kode untuk memastikan ID yang benar
            $matematika = $mapels->where('kode_mapel', 'MTK')->first();
            $ipa = $mapels->where('kode_mapel', 'IPA')->first();
            $ips = $mapels->where('kode_mapel', 'IPS')->first();
            $bahasaIndonesia = $mapels->where('kode_mapel', 'BIN')->first();
            $bahasaInggris = $mapels->where('kode_mapel', 'ENG')->first();
            
            // Contoh penugasan guru ke mata pelajaran
            $assignments = [];
            
            if ($matematika && $gurus->count() >= 1) {
                $assignments[] = [
                    'guru_id' => $gurus->first()->guru_id,
                    'mapel_id' => $matematika->mapel_id,
                    'kurikulum_id' => $kurikulums->first()->kurikulum_id,
                    'kelas' => '1'
                ];
            }
            
            if ($bahasaIndonesia && $gurus->count() >= 2) {
                $assignments[] = [
                    'guru_id' => $gurus->skip(1)->first()->guru_id,
                    'mapel_id' => $bahasaIndonesia->mapel_id,
                    'kurikulum_id' => $kurikulums->first()->kurikulum_id,
                    'kelas' => '2'
                ];
            }
            
            if ($ipa && $gurus->count() >= 3) {
                $assignments[] = [
                    'guru_id' => $gurus->skip(2)->first()->guru_id,
                    'mapel_id' => $ipa->mapel_id,
                    'kurikulum_id' => $kurikulums->first()->kurikulum_id,
                    'kelas' => '3'
                ];
            }

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