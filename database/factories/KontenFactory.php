<?php

namespace Database\Factories;

use App\Models\Konten;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Konten>
 */
class KontenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Konten::class;

    public function definition(): array
    {
        return [
            'judul' => $this->faker->sentence,
            'konten' => $this->faker->paragraph,
            'gambar' => 'uploads/xxx/noimage.jpg',  
            'kategori_id' => $this->faker->numberBetween(1, 2),
        ];
    }
}
