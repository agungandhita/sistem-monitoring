<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CatatanPerkembangan;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\GuruMapel;
use Carbon\Carbon;

class CatatanPerkembanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil data yang diperlukan
        $siswas = Siswa::all();
        $gurus = Guru::all();
        $guruMapels = GuruMapel::all();
        
        if ($siswas->isEmpty() || $gurus->isEmpty()) {
            $this->command->warn('Data siswa atau guru belum tersedia. Jalankan seeder terkait terlebih dahulu.');
            return;
        }
        
        // Template catatan positif
        $catatanPositif = [
            'Siswa menunjukkan kemajuan yang sangat baik dalam memahami materi pembelajaran.',
            'Aktif bertanya dan berpartisipasi dalam diskusi kelas.',
            'Memiliki kemampuan analisis yang baik dan dapat menyelesaikan soal dengan tepat.',
            'Menunjukkan sikap disiplin dan tanggung jawab yang tinggi.',
            'Mampu bekerja sama dengan baik dalam kelompok.',
            'Memiliki kreativitas yang tinggi dalam mengerjakan tugas.',
            'Selalu mengumpulkan tugas tepat waktu dengan kualitas yang baik.',
            'Menunjukkan peningkatan signifikan dalam prestasi belajar.',
            'Memiliki kemampuan komunikasi yang baik saat presentasi.',
            'Rajin membaca dan mencari referensi tambahan untuk belajar.'
        ];
        
        // Template catatan yang perlu perbaikan
        $catatanPerbaikan = [
            'Perlu meningkatkan konsentrasi saat pembelajaran berlangsung.',
            'Sebaiknya lebih aktif bertanya jika ada materi yang belum dipahami.',
            'Perlu bimbingan tambahan untuk memahami konsep dasar.',
            'Tingkatkan kedisiplinan dalam mengumpulkan tugas.',
            'Perlu latihan lebih banyak untuk meningkatkan kemampuan.',
            'Sebaiknya lebih percaya diri saat menjawab pertanyaan.',
            'Perlu meningkatkan kerjasama dalam kegiatan kelompok.',
            'Tingkatkan kehadiran dan ketepatan waktu.',
            'Perlu bimbingan dalam mengorganisir waktu belajar.',
            'Sebaiknya lebih fokus dan mengurangi gangguan saat belajar.'
        ];
        
        // Template catatan netral/observasi
        $catatanObservasi = [
            'Siswa menunjukkan kemampuan yang stabil dalam mengikuti pembelajaran.',
            'Perlu waktu lebih untuk memahami materi yang kompleks.',
            'Memiliki potensi yang baik, perlu dikembangkan lebih lanjut.',
            'Menunjukkan minat yang cukup terhadap mata pelajaran.',
            'Kemampuan dasar sudah baik, perlu pengembangan lanjutan.',
            'Siswa cukup kooperatif dalam mengikuti instruksi guru.',
            'Memiliki gaya belajar yang unik, perlu pendekatan khusus.',
            'Menunjukkan konsistensi dalam mengerjakan tugas harian.'
        ];
        
        // Generate catatan untuk 4 bulan terakhir
        $startDate = Carbon::now()->subMonths(4)->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        
        // Loop untuk setiap siswa
        foreach ($siswas as $siswa) {
            // Ambil guru yang mengajar di kelas siswa ini
            $guruMapelKelas = $guruMapels->where('kelas', $siswa->kelas->tingkat);
            
            if ($guruMapelKelas->isEmpty()) {
                // Jika tidak ada guru mapel, gunakan guru pertama
                $guruList = $gurus->take(3);
            } else {
                $guruList = $guruMapelKelas->pluck('guru')->unique('guru_id');
            }
            
            // Generate 3-8 catatan per siswa dalam 4 bulan
            $jumlahCatatan = rand(3, 8);
            
            for ($i = 0; $i < $jumlahCatatan; $i++) {
                // Random tanggal dalam rentang 4 bulan
                $tanggal = Carbon::createFromTimestamp(
                    rand($startDate->timestamp, $endDate->timestamp)
                )->format('Y-m-d');
                
                // Pilih guru secara random
                $guru = $guruList->random();
                
                // Tentukan semester dan tahun ajaran berdasarkan tanggal
                $bulan = Carbon::parse($tanggal)->month;
                if ($bulan >= 7 && $bulan <= 12) {
                    $semester = 1;
                    $tahunAjaran = Carbon::parse($tanggal)->year . '/' . (Carbon::parse($tanggal)->year + 1);
                } else {
                    $semester = 2;
                    $tahunAjaran = (Carbon::parse($tanggal)->year - 1) . '/' . Carbon::parse($tanggal)->year;
                }
                
                // Distribusi jenis catatan: 50% positif, 30% observasi, 20% perbaikan
                $random = rand(1, 100);
                if ($random <= 50) {
                    $jenisCatatan = 'Positif';
                    $catatan = $catatanPositif[array_rand($catatanPositif)];
                } elseif ($random <= 80) {
                    $jenisCatatan = 'Observasi';
                    $catatan = $catatanObservasi[array_rand($catatanObservasi)];
                } else {
                    $jenisCatatan = 'Perbaikan';
                    $catatan = $catatanPerbaikan[array_rand($catatanPerbaikan)];
                }
                
                CatatanPerkembangan::create([
                    'siswa_id' => $siswa->siswa_id,
                    'guru_id' => $guru->guru_id,
                    'jenis_catatan' => $jenisCatatan,
                    'catatan' => $catatan,
                    'tanggal' => $tanggal,
                    'semester' => $semester,
                    'tahun_ajaran' => $tahunAjaran,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }
        
        $this->command->info('Data catatan perkembangan berhasil dibuat untuk ' . $siswas->count() . ' siswa.');
    }
}