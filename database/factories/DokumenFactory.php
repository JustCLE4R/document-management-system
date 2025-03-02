<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Dokumen>
 */
class DokumenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomElement([1, 2, 4]),
            'name' => $this->faker->realText(20),
            'kriteria_id' => $this->faker->numberBetween(1, 9),
            'sub_kriteria' => $this->faker->realText(30),
            'catatan' => $this->faker->realText(100),
            'tipe' => $this->faker->randomElement(['PDF', 'URL', 'Image']),
            'path' => $this->faker->imageUrl(),
            'views' => $this->faker->numberBetween(0, 10000),
            'revisions' => $this->faker->numberBetween(0, 10),
            'created_at' => $this->faker->dateTimeBetween('-2 year', 'now'),
        ];
    }

    
}
