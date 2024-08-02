<?php

namespace Database\Factories;

use App\Models\Survei;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Survei>
 */
class SurveiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Survei::class;

    public function definition(): array
    {
        return [
            'pertanyaan' => $this->faker->sentence,
            'pilihan_1' => 'Sangat Baik',
            'pilihan_2' => 'Baik',
            'pilihan_3' => 'Cukup',
            'pilihan_4' => 'Buruk',
            'total_pilihan_1' => $this->faker->numberBetween(0, 100),
            'total_pilihan_2' => $this->faker->numberBetween(0, 100),
            'total_pilihan_3' => $this->faker->numberBetween(0, 100),
            'total_pilihan_4' => $this->faker->numberBetween(0, 100),
        ];
    }
}
