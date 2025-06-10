<?php

namespace Database\Seeders;

use App\Models\Guru;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $guru = [
            [
                'nuptk' => '1234567890123456',
                'nip' => '196501011990031001',
                'nama' => 'Dr. Ahmad Susanto, S.Pd., M.Pd.',
                'jabatan' => 'Guru Utama',
                'foto' => null,
                'email' => 'ahmad.susanto@sekolah.sch.id',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Pendidikan No. 123, Jakarta Selatan',
                'telepon' => '081234567890',
            ],
            [
                'nuptk' => '2345678901234567',
                'nip' => '197203151995122002',
                'nama' => 'Siti Nurhaliza, S.Pd., M.Si.',
                'jabatan' => 'Guru Madya',
                'foto' => null,
                'email' => 'siti.nurhaliza@sekolah.sch.id',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Mawar No. 45, Depok',
                'telepon' => '081234567891',
            ],
            [
                'nuptk' => '3456789012345678',
                'nip' => '198005102005011003',
                'nama' => 'Budi Santoso, S.Pd.',
                'jabatan' => 'Guru Muda',
                'foto' => null,
                'email' => 'budi.santoso@sekolah.sch.id',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Melati No. 67, Bogor',
                'telepon' => '081234567892',
            ],
            [
                'nuptk' => '4567890123456789',
                'nip' => '198512252010012004',
                'nama' => 'Rina Kartika, S.Pd., M.Pd.',
                'jabatan' => 'Guru Muda',
                'foto' => null,
                'email' => 'rina.kartika@sekolah.sch.id',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Anggrek No. 89, Tangerang',
                'telepon' => '081234567893',
            ],
            [
                'nuptk' => '5678901234567890',
                'nip' => '199001152015031005',
                'nama' => 'Dedi Kurniawan, S.Pd.',
                'jabatan' => 'Guru Pertama',
                'foto' => null,
                'email' => 'dedi.kurniawan@sekolah.sch.id',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'L',
                'alamat' => 'Jl. Kenanga No. 12, Bekasi',
                'telepon' => '081234567894',
            ],
            [
                'nuptk' => '6789012345678901',
                'nip' => '199205202017022006',
                'nama' => 'Maya Sari, S.Pd.',
                'jabatan' => 'Guru Pertama',
                'foto' => null,
                'email' => 'maya.sari@sekolah.sch.id',
                'password' => Hash::make('password123'),
                'jenis_kelamin' => 'P',
                'alamat' => 'Jl. Dahlia No. 34, Jakarta Timur',
                'telepon' => '081234567895',
            ],
        ];

        foreach ($guru as $g) {
            Guru::create($g);
        }
    }
}