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
            ['id' => 1, 'name' => 'Kriteria 1', 'description' => 'Visi, Misi, Tujuan dan Startegi'],
            ['id' => 2, 'name' => 'Kriteria 2', 'description' => 'Tata Pamong, Tata Kelola, dan Kerja Sama'],
            ['id' => 3, 'name' => 'Kriteria 3', 'description' => 'Mahasisawa'],
            ['id' => 4, 'name' => 'Kriteria 4', 'description' => 'Sumber Daya Manusia'],
            ['id' => 5, 'name' => 'Kriteria 5', 'description' => 'Keuangan, Sarana dan Prasarana'],
            ['id' => 6, 'name' => 'Kriteria 6', 'description' => 'Pendidikan'],
            ['id' => 7, 'name' => 'Kriteria 7', 'description' => 'Penelitian'],
            ['id' => 8, 'name' => 'Kriteria 8', 'description' => 'Pengabian Kepada Masyarakat'],
            ['id' => 9, 'name' => 'Kriteria 9', 'description' => 'Luaran dan Capaian Tridharma'],
            // ['id' => 10, 'name' => 'Kondisi Eksternal'],
            // ['id' => 11, 'name' => 'Profil Institusi'],
            // ['id' => 12, 'name' => 'Analisis & Penetapan Program Pengembangan'],
        ];

        Kriteria::insert($data);
    }
}
