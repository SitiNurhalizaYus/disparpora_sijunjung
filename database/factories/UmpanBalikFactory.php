<?php

namespace Database\Factories;

use App\Models\UmpanBalik;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UmpanBalik>
 */
class UmpanBalikFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = UmpanBalik::class;

    public function definition(): array
    {
        return [
            'id_pengguna' => $this->faker->numberBetween(1, 12),
            'topik_feedback' => $this->faker->sentence,
            'pesan_feedback' => $this->faker->paragraph,
        ];
    }
}
