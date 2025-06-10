<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Wali;
use App\Models\Siswa;
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

        // Create students
        $students = [
            [
                'nis' => '2024001',
                'nama' => 'Muhammad Rizki',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2010-05-15',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Merdeka No. 15, Jakarta',
                'telepon' => '081234567890',
                'kelas' => '7A',
                'tahun_masuk' => '2024',
                'status' => 'aktif',
                'catatan' => 'Siswa berprestasi',
                'wali_ids' => [$waliIds[0], $waliIds[1]],
                'hubungan' => ['ayah', 'ibu']
            ],
            [
                'nis' => '2024002',
                'nama' => 'Sari Indah',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2010-08-22',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Merdeka No. 15, Jakarta',
                'telepon' => '081234567890',
                'kelas' => '7B',
                'tahun_masuk' => '2024',
                'status' => 'aktif',
                'catatan' => null,
                'wali_ids' => [$waliIds[0], $waliIds[1]],
                'hubungan' => ['ayah', 'ibu']
            ],
            [
                'nis' => '2024003',
                'nama' => 'Andi Pratama',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2009-12-10',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Gatot Subroto No. 8, Jakarta',
                'telepon' => '081456789012',
                'kelas' => '8A',
                'tahun_masuk' => '2023',
                'status' => 'aktif',
                'catatan' => 'Aktif dalam ekstrakurikuler',
                'wali_ids' => [$waliIds[2]],
                'hubungan' => ['ayah']
            ],
            [
                'nis' => '2024004',
                'nama' => 'Putri Maharani',
                'jenis_kelamin' => 'P',
                'tanggal_lahir' => '2008-03-18',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Diponegoro No. 33, Jakarta',
                'telepon' => '081567890123',
                'kelas' => '9A',
                'tahun_masuk' => '2022',
                'status' => 'aktif',
                'catatan' => 'Ketua kelas',
                'wali_ids' => [$waliIds[3]],
                'hubungan' => ['ibu']
            ],
            [
                'nis' => '2024005',
                'nama' => 'Fajar Nugraha',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2009-07-25',
                'tempat_lahir' => 'Jakarta',
                'alamat' => 'Jl. Gatot Subroto No. 8, Jakarta',
                'telepon' => '081456789012',
                'kelas' => '8B',
                'tahun_masuk' => '2023',
                'status' => 'aktif',
                'catatan' => 'Adik dari Andi Pratama',
                'wali_ids' => [$waliIds[2]],
                'hubungan' => ['ayah']
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
                'kelas' => $studentData['kelas'],
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