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
                'nip' => '198501012010011001',
                'nama' => 'Dr. Ahmad Hidayat, S.Pd., M.Pd.',
                'jenis_kelamin' => 'laki-laki',
                'alamat' => 'Jl. Pendidikan No. 123, Jakarta Selatan',
                'tanggal_lahir' => '1985-01-01',
                'nomor_hp' => '081234567890',
                'email' => 'ahmad.hidayat@sekolah.com',
                'password' => Hash::make('password123'),
                'jabatan' => 'Guru Matematika',
                'tahun_masuk' => '2010'
            ],
            [
                'nuptk' => '2345678901234567',
                'nip' => '198702152011012002',
                'nama' => 'Siti Nurhaliza, S.Pd.',
                'jenis_kelamin' => 'perempuan',
                'alamat' => 'Jl. Mawar No. 45, Jakarta Timur',
                'tanggal_lahir' => '1987-02-15',
                'nomor_hp' => '081234567891',
                'email' => 'siti.nurhaliza@sekolah.com',
                'password' => Hash::make('password123'),
                'jabatan' => 'Guru Bahasa Indonesia',
                'tahun_masuk' => '2011'
            ],
            [
                'nuptk' => '3456789012345678',
                'nip' => '198903202012013003',
                'nama' => 'Budi Santoso, S.Si., M.Pd.',
                'jenis_kelamin' => 'laki-laki',
                'alamat' => 'Jl. Melati No. 67, Jakarta Barat',
                'tanggal_lahir' => '1989-03-20',
                'nomor_hp' => '081234567892',
                'email' => 'budi.santoso@sekolah.com',
                'password' => Hash::make('password123'),
                'jabatan' => 'Guru Fisika',
                'tahun_masuk' => '2012'
            ],
            [
                'nuptk' => '4567890123456789',
                'nip' => '199004252013014004',
                'nama' => 'Rina Kartika, S.Pd.',
                'jenis_kelamin' => 'perempuan',
                'alamat' => 'Jl. Anggrek No. 89, Jakarta Utara',
                'tanggal_lahir' => '1990-04-25',
                'nomor_hp' => '081234567893',
                'email' => 'rina.kartika@sekolah.com',
                'password' => Hash::make('password123'),
                'jabatan' => 'Guru Kimia',
                'tahun_masuk' => '2013'
            ],
            [
                'nuptk' => '5678901234567890',
                'nip' => '198806102014015005',
                'nama' => 'Dedi Kurniawan, S.Pd.',
                'jenis_kelamin' => 'laki-laki',
                'alamat' => 'Jl. Kenanga No. 12, Jakarta Pusat',
                'tanggal_lahir' => '1988-06-10',
                'nomor_hp' => '081234567894',
                'email' => 'dedi.kurniawan@sekolah.com',
                'password' => Hash::make('password123'),
                'jabatan' => 'Guru Biologi',
                'tahun_masuk' => '2014'
            ],
            [
                'nuptk' => '6789012345678901',
                'nip' => '199105182015016006',
                'nama' => 'Maya Sari, S.Pd.',
                'jenis_kelamin' => 'perempuan',
                'alamat' => 'Jl. Dahlia No. 34, Jakarta Selatan',
                'tanggal_lahir' => '1991-05-18',
                'nomor_hp' => '081234567895',
                'email' => 'maya.sari@sekolah.com',
                'password' => Hash::make('password123'),
                'jabatan' => 'Guru Sejarah',
                'tahun_masuk' => '2015'
            ]
        ];

        foreach ($gurus as $guru) {
            Guru::create($guru);
        }
    }
}