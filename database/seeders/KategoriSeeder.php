<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->insertKategori(1, 1, 'Kategori 1', 'Visi, Misi, Tujuan dan Startegi');
        $this->insertKategori(2, 1, 'Kategori 2', 'Tata Pamong, Tata Kelola, dan Kerja Sama');
        $this->insertKategori(3, 1, 'Kategori 3', 'Mahasisawa');
        $this->insertKategori(4, 1, 'Kategori 4', 'Sumber Daya Manusia');
        $this->insertKategori(5, 1, 'Kategori 5', 'Keuangan, Sarana dan Prasarana');
        $this->insertKategori(6, 1, 'Kategori 6', 'Pendidikan');
        $this->insertKategori(7, 1, 'Kategori 7', 'Penelitian');
        $this->insertKategori(8, 1, 'Kategori 8', 'Pengabian Kepada Masyarakat');
        $this->insertKategori(9, 1, 'Kategori 9', 'Luaran dan Capaian Tridharma');
    }

    private function insertKategori($id, $department_id, $name, $description)
    {
        Kategori::create([
            'id' => $id,
            'department_id' => $department_id,
            'name' => $name,
            'description' => $description,
        ]);
    }
}
