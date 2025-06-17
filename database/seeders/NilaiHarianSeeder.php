<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\NilaiHarian;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Mapel;
use App\Models\Kelas;
use App\Models\GuruMapel;
use Carbon\Carbon;

class NilaiHarianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data yang diperlukan
        $siswas = Siswa::all();
        $gurus = Guru::all();
        $mapels = Mapel::all();
        $kelas = Kelas::all();
        $guruMapels = GuruMapel::all();
        
        if ($siswas->isEmpty() || $gurus->isEmpty() || $mapels->isEmpty() || $kelas->isEmpty()) {
            $this->command->warn('Data siswa, guru, mapel, atau kelas belum tersedia. Jalankan seeder terkait terlebih dahulu.');
            return;
        }
        
        // Jenis penilaian yang tersedia
        $jenisPenilaian = ['Tugas', 'Kuis', 'Ulangan Harian', 'Praktik', 'Lainnya'];
        
        // Keterangan untuk nilai
        $keteranganPositif = [
            'Sangat baik, pertahankan!',
            'Hasil memuaskan',
            'Terus tingkatkan',
            'Bagus sekali',
            'Prestasi yang baik'
        ];
        
        $keteranganNegatif = [
            'Perlu bimbingan lebih',
            'Tingkatkan belajar',
            'Perlu latihan tambahan',
            'Konsultasi dengan guru',
            'Perbaiki pemahaman materi'
        ];
        
        // Generate nilai untuk 3 bulan terakhir
        $startDate = Carbon::now()->subMonths(3)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        
        // Loop untuk setiap siswa
        foreach ($siswas as $siswa) {
            $kelasId = $siswa->kelas_id;
            
            // Ambil guru mapel yang mengajar di kelas siswa ini
            $guruMapelKelas = $guruMapels->where('kelas', $siswa->kelas->tingkat);
            
            if ($guruMapelKelas->isEmpty()) {
                continue;
            }
            
            // Generate nilai untuk setiap mata pelajaran yang diajarkan di kelas ini
            foreach ($guruMapelKelas as $guruMapel) {
                $guru = $guruMapel->guru;
                $mapel = $guruMapel->mapel;
                
                // Generate 8-15 nilai per mata pelajaran dalam 3 bulan
                $jumlahNilai = rand(8, 15);
                
                for ($i = 0; $i < $jumlahNilai; $i++) {
                    // Random tanggal dalam rentang 3 bulan
                    $tanggal = Carbon::createFromTimestamp(
                        rand($startDate->timestamp, $endDate->timestamp)
                    )->format('Y-m-d');
                    
                    // Generate nilai dengan distribusi realistis
                    // 70% nilai bagus (75-100), 20% nilai sedang (60-74), 10% nilai kurang (50-59)
                    $random = rand(1, 100);
                    if ($random <= 70) {
                        $nilai = rand(75, 100);
                    } elseif ($random <= 90) {
                        $nilai = rand(60, 74);
                    } else {
                        $nilai = rand(50, 59);
                    }
                    
                    // Tentukan semester dan tahun ajaran berdasarkan tanggal
                    $bulan = Carbon::parse($tanggal)->month;
                    if ($bulan >= 7 && $bulan <= 12) {
                        $semester = 1;
                        $tahunAjaran = Carbon::parse($tanggal)->year . '/' . (Carbon::parse($tanggal)->year + 1);
                    } else {
                        $semester = 2;
                        $tahunAjaran = (Carbon::parse($tanggal)->year - 1) . '/' . Carbon::parse($tanggal)->year;
                    }
                    
                    // Pilih keterangan berdasarkan nilai
                    $keterangan = $nilai >= 75 ? 
                        $keteranganPositif[array_rand($keteranganPositif)] : 
                        $keteranganNegatif[array_rand($keteranganNegatif)];
                    
                    NilaiHarian::create([
                        'siswa_id' => $siswa->siswa_id,
                        'guru_id' => $guru->guru_id,
                        'mapel_id' => $mapel->mapel_id,
                        'kelas_id' => $kelasId,
                        'nilai' => $nilai,
                        'jenis_penilaian' => $jenisPenilaian[array_rand($jenisPenilaian)],
                        'keterangan' => $keterangan,
                        'tanggal' => $tanggal,
                        'semester' => $semester,
                        'tahun_ajaran' => $tahunAjaran,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]);
                }
            }
        }
        
        $this->command->info('Data nilai harian berhasil dibuat untuk ' . $siswas->count() . ' siswa.');
    }
}