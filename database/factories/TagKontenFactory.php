<?php

namespace Database\Factories;

use App\Models\TagKonten;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TagKonten>
 */
class TagKontenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = TagKonten::class;

    public function definition(): array
    {
        return [
            'konten_id' => $this->faker->numberBetween(1, 10),
            'tag_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
