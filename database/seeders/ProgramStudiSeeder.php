<?php

namespace Database\Seeders;

use App\Models\ProgramStudi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class ProgramStudiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Using file_get_contents to get the content of the JSON file
        $jsonFile = storage_path('json/ProgramStudi.json');
        $jsonData = File::get($jsonFile); // Using File facade to get file content
        $programStudi = json_decode($jsonData, true)['Program Studi'] ?? [];
        
        // Iterating over the decoded data and creating records
        foreach ($programStudi as $namaProgramStudi) {
            ProgramStudi::create(['nama' => $namaProgramStudi]);
        }
    }
}
