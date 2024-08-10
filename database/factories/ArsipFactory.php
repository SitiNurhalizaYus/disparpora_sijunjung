<?php

namespace Database\Factories;

use App\Models\Arsip;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Arsip>
 */
class ArsipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Arsip::class;

    public function definition(): array
    {
        return [
            'tahun' => $this->faker->year(), // Menghasilkan tahun acak
            'bulan' => $this->faker->numberBetween(1, 12), // Menghasilkan bulan acak dari 1 hingga 12
            'label_slug' => $this->faker->slug(),
        ];
    }
}
