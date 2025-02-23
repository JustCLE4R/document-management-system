<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Dokumen;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Database\Seeders\KriteriaSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ProgramStudiSeeder::class);

        $this->createUser('Super Admin', 'superadmin', 'superadmin', 'superadmin', 1);

        $this->createUser('Admin Ilkomp', 'adminilkomp', 'adminilkomp', 'admin', 49);
        $this->createUser('User Ilkomp', 'userilkomp', 'userilkomp', 'user', 49);
        $this->createUser('Admin Manajemen', 'adminmanajemen', 'adminmanajemen', 'admin', 11);
        $this->createUser('User Manajemen', 'usermanajemen', 'usermanajemen', 'user', 11);

        $this->call(KriteriaSeeder::class);

        Dokumen::factory(1415)->create();
    }

    /**
     * Create a user.
     *
     * @param string $name
     * @param string $username
     * @param string $password
     * @param string $email
     * @param int $department
     * @return void
     */
    private function createUser(string $name, string $username, string $password, string $role, int $department): void
    {
        User::create([
            'name' => $name,
            'program_studi_id' => $department,
            'username' => $username,
            'password' => Hash::make($password),
            'role' => $role,
            'remember_token' => Str::random(10),
        ]);
    }
}
