<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Kurikulum;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data yang diperlukan
        $kurikulum = Kurikulum::first();
        $kelas = Kelas::where('nama_kelas', '1A')->first();
        $guru = Guru::first();
        $mapel = Mapel::first();
        
        if (!$kurikulum || !$kelas || !$guru || !$mapel) {
            $this->command->error('Data kurikulum, kelas, guru, atau mapel tidak ditemukan. Jalankan seeder terkait terlebih dahulu.');
            return;
        }
        
        // Jam pelajaran SD
        $jamPelajaran = [
            1 => ['mulai' => '07:00', 'selesai' => '07:35'],
            2 => ['mulai' => '07:35', 'selesai' => '08:10'],
            3 => ['mulai' => '08:10', 'selesai' => '08:45'],
            4 => ['mulai' => '08:45', 'selesai' => '09:20'],
            5 => ['mulai' => '09:35', 'selesai' => '10:10'], // setelah istirahat
            6 => ['mulai' => '10:10', 'selesai' => '10:45'],
            7 => ['mulai' => '10:45', 'selesai' => '11:20'],
        ];
        
        // Contoh jadwal untuk kelas 1A hari Senin
        $jadwalSenin = [
            [
                'hari' => 'Senin',
                'jam_ke' => 1,
                'mapel_id' => $mapel->mapel_id,
                'guru_id' => $guru->guru_id,
                'kelas_id' => $kelas->kelas_id,
                'kurikulum_id' => $kurikulum->kurikulum_id,
                'tahun_ajaran' => $kurikulum->tahun_ajaran,
                'jam_mulai' => $jamPelajaran[1]['mulai'],
                'jam_selesai' => $jamPelajaran[1]['selesai'],
                'status' => 'aktif',
                'catatan' => 'Pelajaran pembuka'
            ],
            [
                'hari' => 'Senin',
                'jam_ke' => 2,
                'mapel_id' => $mapel->mapel_id,
                'guru_id' => $guru->guru_id,
                'kelas_id' => $kelas->kelas_id,
                'kurikulum_id' => $kurikulum->kurikulum_id,
                'tahun_ajaran' => $kurikulum->tahun_ajaran,
                'jam_mulai' => $jamPelajaran[2]['mulai'],
                'jam_selesai' => $jamPelajaran[2]['selesai'],
                'status' => 'aktif'
            ],
            [
                'hari' => 'Senin',
                'jam_ke' => 3,
                'mapel_id' => $mapel->mapel_id,
                'guru_id' => $guru->guru_id,
                'kelas_id' => $kelas->kelas_id,
                'kurikulum_id' => $kurikulum->kurikulum_id,
                'tahun_ajaran' => $kurikulum->tahun_ajaran,
                'jam_mulai' => $jamPelajaran[3]['mulai'],
                'jam_selesai' => $jamPelajaran[3]['selesai'],
                'status' => 'aktif'
            ]
        ];
        
        foreach ($jadwalSenin as $jadwal) {
            // Cek konflik sebelum membuat jadwal
            if (!Jadwal::hasConflict(
                $jadwal['hari'], 
                $jadwal['jam_ke'], 
                $jadwal['kelas_id'], 
                $jadwal['guru_id'], 
                $jadwal['tahun_ajaran']
            )) {
                Jadwal::create($jadwal);
            } else {
                $this->command->warn("Konflik jadwal ditemukan untuk {$jadwal['hari']} jam ke-{$jadwal['jam_ke']}");
            }
        }
        
        $this->command->info('Data jadwal contoh berhasil dibuat.');
    }
}