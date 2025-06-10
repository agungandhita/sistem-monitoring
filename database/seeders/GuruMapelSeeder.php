<?php

namespace Database\Seeders;

use App\Models\Guru;
use App\Models\Mapel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuruMapelSeeder extends Seeder
{
    public function run(): void
    {
        // Get all guru and mapel IDs
        $gurus = Guru::all();
        $mapels = Mapel::all();

        if ($gurus->isEmpty() || $mapels->isEmpty()) {
            $this->command->warn('Guru atau Mapel belum ada. Pastikan GuruSeeder dan MapelSeeder sudah dijalankan.');
            return;
        }

        // Define assignments
        $assignments = [
            // Dr. Ahmad Susanto - Matematika untuk beberapa kelas
            [
                'guru_nip' => '196501011990031001',
                'mapel_kode' => 'MTK',
                'kelas' => '1A',
                'tahun_ajaran' => '2024/2025',
                'status' => 'aktif',
                'catatan' => 'Guru senior dengan pengalaman 25 tahun'
            ],
            [
                'guru_nip' => '196501011990031001',
                'mapel_kode' => 'MTK',
                'kelas' => '2A',
                'tahun_ajaran' => '2024/2025',
                'status' => 'aktif',
                'catatan' => 'Mengajar kelas unggulan'
            ],
            
            // Siti Nurhaliza - Bahasa Indonesia
            [
                'guru_nip' => '197203151995122002',
                'mapel_kode' => 'BIN',
                'kelas' => '1A',
                'tahun_ajaran' => '2024/2025',
                'status' => 'aktif',
                'catatan' => 'Spesialis sastra dan tata bahasa'
            ],
            [
                'guru_nip' => '197203151995122002',
                'mapel_kode' => 'BIN',
                'kelas' => '1B',
                'tahun_ajaran' => '2024/2025',
                'status' => 'aktif',
                'catatan' => null
            ],
            [
                'guru_nip' => '197203151995122002',
                'mapel_kode' => 'BIN',
                'kelas' => '2B',
                'tahun_ajaran' => '2024/2025',
                'status' => 'aktif',
                'catatan' => null
            ],
            
            // Budi Santoso - IPA
            [
                'guru_nip' => '198005102005011003',
                'mapel_kode' => 'IPA',
                'kelas' => '3A',
                'tahun_ajaran' => '2024/2025',
                'status' => 'aktif',
                'catatan' => 'Lulusan terbaik jurusan Fisika'
            ],
            [
                'guru_nip' => '198005102005011003',
                'mapel_kode' => 'IPA',
                'kelas' => '3B',
                'tahun_ajaran' => '2024/2025',
                'status' => 'aktif',
                'catatan' => null
            ],
            
            // Rina Kartika - IPS dan PAI
            [
                'guru_nip' => '198512252010012004',
                'mapel_kode' => 'IPS',
                'kelas' => '2A',
                'tahun_ajaran' => '2024/2025',
                'status' => 'aktif',
                'catatan' => 'Ahli sejarah dan geografi'
            ],
            [
                'guru_nip' => '198512252010012004',
                'mapel_kode' => 'IPS',
                'kelas' => '3A',
                'tahun_ajaran' => '2024/2025',
                'status' => 'aktif',
                'catatan' => null
            ],
            [
                'guru_nip' => '198512252010012004',
                'mapel_kode' => 'PAI',
                'kelas' => '1A',
                'tahun_ajaran' => '2024/2025',
                'status' => 'aktif',
                'catatan' => 'Juga mengajar agama Islam'
            ],
            
            // Dedi Kurniawan - Matematika kelas lain
            [
                'guru_nip' => '199001152015031005',
                'mapel_kode' => 'MTK',
                'kelas' => '1B',
                'tahun_ajaran' => '2024/2025',
                'status' => 'aktif',
                'catatan' => 'Guru muda yang energik'
            ],
            [
                'guru_nip' => '199001152015031005',
                'mapel_kode' => 'MTK',
                'kelas' => '3A',
                'tahun_ajaran' => '2024/2025',
                'status' => 'aktif',
                'catatan' => null
            ],
            
            // Maya Sari - PAI dan IPA
            [
                'guru_nip' => '199205202017022006',
                'mapel_kode' => 'PAI',
                'kelas' => '2A',
                'tahun_ajaran' => '2024/2025',
                'status' => 'aktif',
                'catatan' => 'Lulusan pesantren modern'
            ],
            [
                'guru_nip' => '199205202017022006',
                'mapel_kode' => 'PAI',
                'kelas' => '3B',
                'tahun_ajaran' => '2024/2025',
                'status' => 'aktif',
                'catatan' => null
            ],
            [
                'guru_nip' => '199205202017022006',
                'mapel_kode' => 'IPA',
                'kelas' => '1A',
                'tahun_ajaran' => '2024/2025',
                'status' => 'aktif',
                'catatan' => 'Mengajar IPA dasar'
            ],
            
            // Some assignments for previous year (inactive)
            [
                'guru_nip' => '196501011990031001',
                'mapel_kode' => 'MTK',
                'kelas' => '3A',
                'tahun_ajaran' => '2023/2024',
                'status' => 'nonaktif',
                'catatan' => 'Tahun ajaran sebelumnya'
            ],
        ];

        foreach ($assignments as $assignment) {
            // Find guru by NIP
            $guru = $gurus->where('nip', $assignment['guru_nip'])->first();
            // Find mapel by kode
            $mapel = $mapels->where('kode_mapel', $assignment['mapel_kode'])->first();
            
            if ($guru && $mapel) {
                DB::table('guru_mapel')->insert([
                    'guru_id' => $guru->guru_id,
                    'mapel_id' => $mapel->mapel_id,
                    'kelas' => $assignment['kelas'],
                    'tahun_ajaran' => $assignment['tahun_ajaran'],
                    'status' => $assignment['status'],
                    'catatan' => $assignment['catatan'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $this->command->warn("Guru dengan NIP {$assignment['guru_nip']} atau Mapel dengan kode {$assignment['mapel_kode']} tidak ditemukan.");
            }
        }
        
        $this->command->info('GuruMapel seeder berhasil dijalankan!');
    }
}