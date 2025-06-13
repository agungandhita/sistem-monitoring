<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wali;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create guardian users and profiles
        $guardians = [
            [
                'nama' => 'Ahmad Suryanto',
                'email' => 'ahmad.suryanto@email.com',
                'alamat' => 'Jl. Merdeka No. 15, Jakarta',
                'telepon' => '081234567890',
                'pekerjaan' => 'Pegawai Swasta',
                'jenis_kelamin' => 'L'
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'email' => 'siti.nurhaliza@email.com',
                'alamat' => 'Jl. Sudirman No. 22, Jakarta',
                'telepon' => '081345678901',
                'pekerjaan' => 'Ibu Rumah Tangga',
                'jenis_kelamin' => 'P'
            ],
            [
                'nama' => 'Budi Santoso',
                'email' => 'budi.santoso@email.com',
                'alamat' => 'Jl. Gatot Subroto No. 8, Jakarta',
                'telepon' => '081456789012',
                'pekerjaan' => 'Wiraswasta',
                'jenis_kelamin' => 'L'
            ],
            [
                'nama' => 'Dewi Sartika',
                'email' => 'dewi.sartika@email.com',
                'alamat' => 'Jl. Diponegoro No. 33, Jakarta',
                'telepon' => '081567890123',
                'pekerjaan' => 'Guru',
                'jenis_kelamin' => 'P'
            ]
        ];

        $waliIds = [];
        foreach ($guardians as $guardian) {
            // Create user account
            $user = User::create([
                'nama' => $guardian['nama'],
                'email' => $guardian['email'],
                'password' => Hash::make('password123'),
                'alamat' => $guardian['alamat'],
                'telepon' => $guardian['telepon'],
                'role' => 'wali'
            ]);

            // Create wali profile
            $wali = Wali::create([
                'user_id' => $user->user_id,
                'nama' => $guardian['nama'],
                'alamat' => $guardian['alamat'],
                'telepon' => $guardian['telepon'],
                'pekerjaan' => $guardian['pekerjaan'],
                'jenis_kelamin' => $guardian['jenis_kelamin']
            ]);

            $waliIds[] = $wali->wali_id;
        }

        // Get kelas IDs for mapping
        $kelasMap = [
            '1' => Kelas::where('nama_kelas', '1A')->first()->kelas_id,
            '2' => Kelas::where('nama_kelas', '2A')->first()->kelas_id,
            '3' => Kelas::where('nama_kelas', '3A')->first()->kelas_id,
            '4' => Kelas::where('nama_kelas', '4A')->first()->kelas_id,
            '5' => Kelas::where('nama_kelas', '5A')->first()->kelas_id,
            '6' => Kelas::where('nama_kelas', '6A')->first()->kelas_id,
        ];

        // Create students for grades 1-6
        $students = [
            // Kelas 1
            [
                'nis' => '2024001',
                'nama' => 'Ahmad Fauzi',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2017-05-15',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Merdeka No. 15, Jakarta',
                'telepon' => '081234567890',
                'kelas' => '1',
                'tahun_masuk' => '2024',
                'status' => 'aktif',
                'catatan' => 'Siswa baru',
                'wali_ids' => [$waliIds[0], $waliIds[1]],
                'hubungan' => ['ayah', 'ibu']
            ],
            [
                'nis' => '2024002',
                'nama' => 'Siti Aisyah',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2017-08-22',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Sudirman No. 22, Jakarta',
                'telepon' => '081345678901',
                'kelas' => '1',
                'tahun_masuk' => '2024',
                'status' => 'aktif',
                'catatan' => null,
                'wali_ids' => [$waliIds[1]],
                'hubungan' => ['ibu']
            ],
            // Kelas 2
            [
                'nis' => '2023001',
                'nama' => 'Budi Santoso Jr',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2016-12-10',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Gatot Subroto No. 8, Jakarta',
                'telepon' => '081456789012',
                'kelas' => '2',
                'tahun_masuk' => '2023',
                'status' => 'aktif',
                'catatan' => 'Aktif dalam kegiatan kelas',
                'wali_ids' => [$waliIds[2]],
                'hubungan' => ['ayah']
            ],
            [
                'nis' => '2023002',
                'nama' => 'Dewi Putri',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2016-03-18',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Diponegoro No. 33, Jakarta',
                'telepon' => '081567890123',
                'kelas' => '2',
                'tahun_masuk' => '2023',
                'status' => 'aktif',
                'catatan' => 'Rajin belajar',
                'wali_ids' => [$waliIds[3]],
                'hubungan' => ['ibu']
            ],
            // Kelas 3
            [
                'nis' => '2022001',
                'nama' => 'Muhammad Rizki',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2015-07-25',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Merdeka No. 15, Jakarta',
                'telepon' => '081234567890',
                'kelas' => '3',
                'tahun_masuk' => '2022',
                'status' => 'aktif',
                'catatan' => 'Siswa berprestasi',
                'wali_ids' => [$waliIds[0]],
                'hubungan' => ['ayah']
            ],
            [
                'nis' => '2022002',
                'nama' => 'Fatimah Zahra',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2015-11-12',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Sudirman No. 22, Jakarta',
                'telepon' => '081345678901',
                'kelas' => '3',
                'tahun_masuk' => '2022',
                'status' => 'aktif',
                'catatan' => 'Ketua kelas',
                'wali_ids' => [$waliIds[1]],
                'hubungan' => ['ibu']
            ],
            // Kelas 4
            [
                'nis' => '2021001',
                'nama' => 'Ali Rahman',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2014-04-08',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Gatot Subroto No. 8, Jakarta',
                'telepon' => '081456789012',
                'kelas' => '4',
                'tahun_masuk' => '2021',
                'status' => 'aktif',
                'catatan' => 'Suka matematika',
                'wali_ids' => [$waliIds[2]],
                'hubungan' => ['ayah']
            ],
            [
                'nis' => '2021002',
                'nama' => 'Khadijah Nur',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2014-09-15',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Diponegoro No. 33, Jakarta',
                'telepon' => '081567890123',
                'kelas' => '4',
                'tahun_masuk' => '2021',
                'status' => 'aktif',
                'catatan' => 'Gemar membaca',
                'wali_ids' => [$waliIds[3]],
                'hubungan' => ['ibu']
            ],
            // Kelas 5
            [
                'nis' => '2020001',
                'nama' => 'Umar Faruq',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2013-01-20',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Merdeka No. 15, Jakarta',
                'telepon' => '081234567890',
                'kelas' => '5',
                'tahun_masuk' => '2020',
                'status' => 'aktif',
                'catatan' => 'Aktif dalam olahraga',
                'wali_ids' => [$waliIds[0]],
                'hubungan' => ['ayah']
            ],
            [
                'nis' => '2020002',
                'nama' => 'Aminah Sari',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2013-06-30',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Sudirman No. 22, Jakarta',
                'telepon' => '081345678901',
                'kelas' => '5',
                'tahun_masuk' => '2020',
                'status' => 'aktif',
                'catatan' => 'Suka seni',
                'wali_ids' => [$waliIds[1]],
                'hubungan' => ['ibu']
            ],
            // Kelas 6
            [
                'nis' => '2019001',
                'nama' => 'Yusuf Ibrahim',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2012-10-05',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Gatot Subroto No. 8, Jakarta',
                'telepon' => '081456789012',
                'kelas' => '6',
                'tahun_masuk' => '2019',
                'status' => 'aktif',
                'catatan' => 'Calon ketua OSIS',
                'wali_ids' => [$waliIds[2]],
                'hubungan' => ['ayah']
            ],
            [
                'nis' => '2019002',
                'nama' => 'Maryam Husna',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2012-12-25',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Diponegoro No. 33, Jakarta',
                'telepon' => '081567890123',
                'kelas' => '6',
                'tahun_masuk' => '2019',
                'status' => 'aktif',
                'catatan' => 'Siswa teladan',
                'wali_ids' => [$waliIds[3]],
                'hubungan' => ['ibu']
            ]
        ];

        foreach ($students as $studentData) {
            $siswa = Siswa::create([
                'nis' => $studentData['nis'],
                'nama' => $studentData['nama'],
                'jenis_kelamin' => $studentData['jenis_kelamin'],
                'tanggal_lahir' => $studentData['tanggal_lahir'],
                'tempat_lahir' => $studentData['tempat_lahir'],
                'alamat' => $studentData['alamat'],
                'telepon' => $studentData['telepon'],
                'kelas_id' => $kelasMap[$studentData['kelas']],
                'tahun_masuk' => $studentData['tahun_masuk'],
                'status' => $studentData['status'],
                'catatan' => $studentData['catatan']
            ]);

            // Attach guardians with relationship
            foreach ($studentData['wali_ids'] as $index => $wali_id) {
                $hubungan = $studentData['hubungan'][$index];
                $siswa->walis()->attach($wali_id, ['hubungan' => $hubungan]);
            }
        }
    }
}