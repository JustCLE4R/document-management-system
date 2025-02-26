<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Department::insert([
            'name' => 'UINSU',
            'type' => 'faculty',
            'parent_id' => null,
        ]);

        // Load JSON file
        $json = File::get(storage_path('json/departments.json'));
        $departments = json_decode($json, true);

        foreach ($departments as $faculty => $programs) {
            // Insert faculty
            $facultyId = Department::insertGetId([
                'name' => $faculty,
                'type' => 'faculty',
                'parent_id' => null,
            ]);

            // Insert programs
            foreach ($programs as $program) {
                Department::insert([
                    'name' => $program,
                    'type' => 'program',
                    'parent_id' => $facultyId,
                ]);
            }
        }
    }
}
