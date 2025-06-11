<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kurikulum;

class KurikulumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kurikulums = [
            [
                'nama_kurikulum' => 'Kurikulum 2013',
                'tahun_ajaran' => '2023/2024'
            ],
            [
                'nama_kurikulum' => 'Kurikulum Merdeka',
                'tahun_ajaran' => '2024/2025'
            ],
            [
                'nama_kurikulum' => 'Kurikulum 2013 Revisi',
                'tahun_ajaran' => '2022/2023'
            ],
            [
                'nama_kurikulum' => 'Kurikulum Prototype',
                'tahun_ajaran' => '2021/2022'
            ]
        ];

        foreach ($kurikulums as $kurikulum) {
            Kurikulum::create($kurikulum);
        }
    }
}