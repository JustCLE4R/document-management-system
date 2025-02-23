<?php

namespace Database\Seeders;

use App\Models\Kriteria;
use Illuminate\Database\Seeder;

class KriteriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['id' => 1, 'nama' => 'Kriteria 1'],
            ['id' => 2, 'nama' => 'Kriteria 2'],
            ['id' => 3, 'nama' => 'Kriteria 3'],
            ['id' => 4, 'nama' => 'Kriteria 4'],
            ['id' => 5, 'nama' => 'Kriteria 5'],
            ['id' => 6, 'nama' => 'Kriteria 6'],
            ['id' => 7, 'nama' => 'Kriteria 7'],
            ['id' => 8, 'nama' => 'Kriteria 8'],
            ['id' => 9, 'nama' => 'Kriteria 9'],
            ['id' => 10, 'nama' => 'Kondisi Eksternal'],
            ['id' => 11, 'nama' => 'Profil Institusi'],
            ['id' => 12, 'nama' => 'Analisis & Penetapan Program Pengembangan'],
        ];

        Kriteria::insert($data);
    }
}
