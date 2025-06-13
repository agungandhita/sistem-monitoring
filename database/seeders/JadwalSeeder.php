<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Kurikulum;
use App\Models\GuruMapel;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data yang diperlukan
        $kurikulum = Kurikulum::first();
        $kelas = Kelas::all();
        $gurus = Guru::all();
        $mapels = Mapel::all();
        $guruMapels = GuruMapel::with(['guru', 'mapel'])->get();
        
        if (!$kurikulum || $kelas->isEmpty() || $gurus->isEmpty() || $mapels->isEmpty()) {
            $this->command->error('Data kurikulum, kelas, guru, atau mapel tidak ditemukan. Jalankan seeder terkait terlebih dahulu.');
            return;
        }
        
        // Jam pelajaran standar SD/MI
        $jamPelajaran = [
            1 => ['mulai' => '07:00', 'selesai' => '07:35'],
            2 => ['mulai' => '07:35', 'selesai' => '08:10'],
            3 => ['mulai' => '08:10', 'selesai' => '08:45'],
            4 => ['mulai' => '08:45', 'selesai' => '09:20'],
            // Istirahat 15 menit
            5 => ['mulai' => '09:35', 'selesai' => '10:10'],
            6 => ['mulai' => '10:10', 'selesai' => '10:45'],
            7 => ['mulai' => '10:45', 'selesai' => '11:20'],
            8 => ['mulai' => '11:20', 'selesai' => '11:55'],
        ];
        
        $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        $tahunAjaran = $kurikulum->tahun_ajaran ?? '2024/2025';
        
        // Template jadwal untuk setiap tingkat kelas
        $templateJadwal = [
            '1' => [ // Kelas 1
                'Senin' => [
                    1 => 'Bahasa Indonesia',
                    2 => 'Matematika',
                    3 => 'Pendidikan Agama Islam',
                    4 => 'Seni Budaya',
                    5 => 'Pendidikan Jasmani'
                ],
                'Selasa' => [
                    1 => 'Matematika',
                    2 => 'Bahasa Indonesia',
                    3 => 'Ilmu Pengetahuan Alam',
                    4 => 'Ilmu Pengetahuan Sosial',
                    5 => 'Bahasa Arab'
                ],
                'Rabu' => [
                    1 => 'Pendidikan Agama Islam',
                    2 => 'Matematika',
                    3 => 'Bahasa Indonesia',
                    4 => 'Seni Budaya',
                    5 => 'Akidah Akhlak'
                ],
                'Kamis' => [
                    1 => 'Ilmu Pengetahuan Alam',
                    2 => 'Bahasa Indonesia',
                    3 => 'Matematika',
                    4 => 'Pendidikan Jasmani',
                    5 => 'Quran Hadits'
                ],
                'Jumat' => [
                    1 => 'Bahasa Arab',
                    2 => 'Matematika',
                    3 => 'Ilmu Pengetahuan Sosial',
                    4 => 'Fiqih'
                ],
                'Sabtu' => [
                    1 => 'Sejarah Kebudayaan Islam',
                    2 => 'Bahasa Indonesia',
                    3 => 'Matematika',
                    4 => 'Seni Budaya'
                ]
            ],
            '2' => [ // Kelas 2 - sama dengan kelas 1 tapi bisa berbeda guru
                'Senin' => [
                    1 => 'Bahasa Indonesia',
                    2 => 'Matematika',
                    3 => 'Pendidikan Agama Islam',
                    4 => 'Seni Budaya',
                    5 => 'Pendidikan Jasmani'
                ],
                'Selasa' => [
                    1 => 'Matematika',
                    2 => 'Bahasa Indonesia',
                    3 => 'Ilmu Pengetahuan Alam',
                    4 => 'Ilmu Pengetahuan Sosial',
                    5 => 'Bahasa Arab'
                ],
                'Rabu' => [
                    1 => 'Pendidikan Agama Islam',
                    2 => 'Matematika',
                    3 => 'Bahasa Indonesia',
                    4 => 'Seni Budaya',
                    5 => 'Akidah Akhlak'
                ],
                'Kamis' => [
                    1 => 'Ilmu Pengetahuan Alam',
                    2 => 'Bahasa Indonesia',
                    3 => 'Matematika',
                    4 => 'Pendidikan Jasmani',
                    5 => 'Quran Hadits'
                ],
                'Jumat' => [
                    1 => 'Bahasa Arab',
                    2 => 'Matematika',
                    3 => 'Ilmu Pengetahuan Sosial',
                    4 => 'Fiqih'
                ],
                'Sabtu' => [
                    1 => 'Sejarah Kebudayaan Islam',
                    2 => 'Bahasa Indonesia',
                    3 => 'Matematika',
                    4 => 'Seni Budaya'
                ]
            ]
        ];
        
        $jadwalData = [];
        
        // Generate jadwal untuk setiap kelas
        foreach ($kelas as $kelasItem) {
            // Ambil tingkat kelas (misal: dari "1A" ambil "1")
            $tingkat = substr($kelasItem->nama_kelas, 0, 1);
            
            if (!isset($templateJadwal[$tingkat])) {
                continue; // Skip jika template tidak ada
            }
            
            foreach ($templateJadwal[$tingkat] as $namaHari => $jadwalHari) {
                foreach ($jadwalHari as $jamKe => $namaMapel) {
                    // Cari mapel berdasarkan nama
                    $mapel = $mapels->where('mapel', $namaMapel)->first();
                    if (!$mapel) {
                        continue; // Skip jika mapel tidak ditemukan
                    }
                    
                    // Cari guru yang mengajar mapel ini
                    $guruMapel = $guruMapels->where('mapel_id', $mapel->mapel_id)->first();
                    if (!$guruMapel) {
                        // Jika tidak ada di guru_mapel, ambil guru pertama sebagai default
                        $guru = $gurus->first();
                    } else {
                        $guru = $guruMapel->guru;
                    }
                    
                    // Cek konflik jadwal
                    $hasConflict = collect($jadwalData)->contains(function ($item) use ($namaHari, $jamKe, $kelasItem, $guru, $tahunAjaran) {
                        return $item['hari'] === $namaHari && 
                               $item['jam_ke'] === $jamKe && 
                               ($item['kelas_id'] === $kelasItem->kelas_id || $item['guru_id'] === $guru->guru_id) &&
                               $item['tahun_ajaran'] === $tahunAjaran;
                    });
                    
                    if (!$hasConflict) {
                        $jadwalData[] = [
                            'hari' => $namaHari,
                            'jam_ke' => $jamKe,
                            'jam_mulai' => $jamPelajaran[$jamKe]['mulai'],
                            'jam_selesai' => $jamPelajaran[$jamKe]['selesai'],
                            'mapel_id' => $mapel->mapel_id,
                            'guru_id' => $guru->guru_id,
                            'kelas_id' => $kelasItem->kelas_id,
                            'kurikulum_id' => $kurikulum->kurikulum_id,
                            'tahun_ajaran' => $tahunAjaran,
                            'status' => 'aktif',
                            'catatan' => "Jadwal {$namaMapel} untuk kelas {$kelasItem->nama_kelas}",
                            'created_at' => now(),
                            'updated_at' => now()
                        ];
                    }
                }
            }
        }
        
        // Insert data jadwal dalam batch untuk performa yang lebih baik
        if (!empty($jadwalData)) {
            // Chunk data untuk menghindari memory limit
            $chunks = array_chunk($jadwalData, 50);
            
            foreach ($chunks as $chunk) {
                Jadwal::insert($chunk);
            }
            
            $this->command->info('Berhasil membuat ' . count($jadwalData) . ' data jadwal.');
        } else {
            $this->command->warn('Tidak ada data jadwal yang dibuat.');
        }
        
        // Tambahkan beberapa jadwal dengan status tidak aktif sebagai contoh
        $jadwalTidakAktif = [
            [
                'hari' => 'Senin',
                'jam_ke' => 6,
                'jam_mulai' => $jamPelajaran[6]['mulai'],
                'jam_selesai' => $jamPelajaran[6]['selesai'],
                'mapel_id' => $mapels->first()->mapel_id,
                'guru_id' => $gurus->first()->guru_id,
                'kelas_id' => $kelas->first()->kelas_id,
                'kurikulum_id' => $kurikulum->kurikulum_id,
                'tahun_ajaran' => $tahunAjaran,
                'status' => 'tidak_aktif',
                'catatan' => 'Jadwal cadangan - tidak aktif',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];
        
        Jadwal::insert($jadwalTidakAktif);
        
        $this->command->info('Seeder jadwal selesai dijalankan.');
    }
}