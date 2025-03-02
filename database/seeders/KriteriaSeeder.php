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
        $this->insertKriteria(1, 1, 'Kriteria 1', 'Visi, Misi, Tujuan dan Startegi');
        $this->insertKriteria(2, 1, 'Kriteria 2', 'Tata Pamong, Tata Kelola, dan Kerja Sama');
        $this->insertKriteria(3, 1, 'Kriteria 3', 'Mahasisawa');
        $this->insertKriteria(4, 1, 'Kriteria 4', 'Sumber Daya Manusia');
        $this->insertKriteria(5, 1, 'Kriteria 5', 'Keuangan, Sarana dan Prasarana');
        $this->insertKriteria(6, 1, 'Kriteria 6', 'Pendidikan');
        $this->insertKriteria(7, 1, 'Kriteria 7', 'Penelitian');
        $this->insertKriteria(8, 1, 'Kriteria 8', 'Pengabian Kepada Masyarakat');
        $this->insertKriteria(9, 1, 'Kriteria 9', 'Luaran dan Capaian Tridharma');
    }

    private function insertKriteria($id, $department_id, $name, $description)
    {
        Kriteria::create([
            'id' => $id,
            'department_id' => $department_id,
            'name' => $name,
            'description' => $description,
        ]);
    }
}
