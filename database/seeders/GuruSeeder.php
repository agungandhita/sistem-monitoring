<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Guru;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gurus = [
            [
                'nuptk' => '1234567890123456',
                'nip' => '196501011990031001',
                'nama' => 'Ahmad Hidayat, S.Pd',
                'jenis_kelamin' => 'laki-laki',
                'alamat' => 'Jl. Pendidikan No. 123, Jakarta',
                'tanggal_lahir' => '1965-01-01',
                'nomor_hp' => '081234567890',
                'email' => 'ahmad.hidayat@sekolah.com',
                'password' => Hash::make('password123'),
                'jabatan' => 'Guru Kelas',
                'tahun_masuk' => '1990'
            ],
            [
                'nuptk' => '2345678901234567',
                'nip' => '197203151995122002',
                'nama' => 'Siti Nurhaliza, S.Pd',
                'jenis_kelamin' => 'perempuan',
                'alamat' => 'Jl. Mawar No. 45, Jakarta',
                'tanggal_lahir' => '1972-03-15',
                'nomor_hp' => '081234567891',
                'email' => 'siti.nurhaliza@sekolah.com',
                'password' => Hash::make('password123'),
                'jabatan' => 'Guru Mata Pelajaran',
                'tahun_masuk' => '1995'
            ],
            [
                'nuptk' => '3456789012345678',
                'nip' => '198006102005011003',
                'nama' => 'Budi Santoso, S.Pd',
                'jenis_kelamin' => 'laki-laki',
                'alamat' => 'Jl. Melati No. 67, Jakarta',
                'tanggal_lahir' => '1980-06-10',
                'nomor_hp' => '081234567892',
                'email' => 'budi.santoso@sekolah.com',
                'password' => Hash::make('password123'),
                'jabatan' => 'Guru Olahraga',
                'tahun_masuk' => '2005'
            ],
            [
                'nuptk' => '4567890123456789',
                'nip' => '198512252010012004',
                'nama' => 'Dewi Sartika, S.Pd',
                'jenis_kelamin' => 'perempuan',
                'alamat' => 'Jl. Anggrek No. 89, Jakarta',
                'tanggal_lahir' => '1985-12-25',
                'nomor_hp' => '081234567893',
                'email' => 'dewi.sartika@sekolah.com',
                'password' => Hash::make('password123'),
                'jabatan' => 'Guru Seni',
                'tahun_masuk' => '2010'
            ],
            [
                'nuptk' => '5678901234567890',
                'nip' => '197809182003021005',
                'nama' => 'Rudi Hermawan, S.Pd',
                'jenis_kelamin' => 'laki-laki',
                'alamat' => 'Jl. Kenanga No. 12, Jakarta',
                'tanggal_lahir' => '1978-09-18',
                'nomor_hp' => '081234567894',
                'email' => 'rudi.hermawan@sekolah.com',
                'password' => Hash::make('password123'),
                'jabatan' => 'Kepala Sekolah',
                'tahun_masuk' => '2003'
            ],
            [
                'nuptk' => '6789012345678901',
                'nip' => '198304072008012006',
                'nama' => 'Rina Marlina, S.Pd',
                'jenis_kelamin' => 'perempuan',
                'alamat' => 'Jl. Dahlia No. 34, Jakarta',
                'tanggal_lahir' => '1983-04-07',
                'nomor_hp' => '081234567895',
                'email' => 'rina.marlina@sekolah.com',
                'password' => Hash::make('password123'),
                'jabatan' => 'Guru Bahasa',
                'tahun_masuk' => '2008'
            ]
        ];

        foreach ($gurus as $guru) {
            Guru::create($guru);
        }
    }
}