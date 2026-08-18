<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Crop;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Crop>
 */
class CropFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Self-contained: builds its own Category rather than relying on
        // CategorySeeder, so `Crop::factory()->create()` works in isolation
        // (e.g. from ProductFactory) without the taxonomy seeder having run.
        $name = ucfirst($this->faker->unique()->word());

        return [
            'category_id' => Category::factory(),
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
