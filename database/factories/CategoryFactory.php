<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Self-contained (doesn't rely on CategorySeeder's curated list) so
        // tests/tinker can create categories in isolation. unique() avoids
        // colliding with the `name`/`slug` unique constraints.
        $name = ucfirst($this->faker->unique()->word());

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
