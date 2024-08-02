<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Event::class;

    public function definition(): array
    {
        return [
            'nama_acara' => $this->faker->sentence,
            'tanggal_acara' => $this->faker->date,
            'deskripsi' => $this->faker->paragraph,
            // 'gambar' => 'img/' . $this->faker->word . '.jpg',
            'gambar' => 'uploads/xxx/noimage.jpg',  
            'link_event' => $this->faker->url,
            'admin_id' => $this->faker->numberBetween(1, 2),
        ];
    }
}
