<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Dokumen;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Database\Seeders\KategoriSeeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(DepartmentsSeeder::class);

        $this->createUser('Super Admin', 'superadmin', 'superadmin', 'superadmin', 1);

        $this->createUser('Admin Ilkomp', 'adminilkomp', 'adminilkomp', 'admin', 55);
        $this->createUser('User Ilkomp', 'userilkomp', 'userilkomp', 'user', 55);
        $this->createUser('Admin Manajemen', 'adminmanajemen', 'adminmanajemen', 'admin', 13);
        $this->createUser('User Manajemen', 'usermanajemen', 'usermanajemen', 'user', 13);

        $this->call(KategoriSeeder::class);

        Dokumen::factory(1415)->sequence(
            ['revisions' => 10], 
            ['revisions' => 10], 
            ['revisions' => 10], 
            ...array_fill(0, 1412, ['revisions' => fake()->biasedNumberBetween(0, 10, 'sqrt')])
        )->create();
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
            'department_id' => $department,
            'username' => $username,
            'password' => Hash::make($password),
            'role' => $role,
            'remember_token' => Str::random(10),
        ]);
    }
}
