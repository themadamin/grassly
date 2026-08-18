<?php

namespace Database\Factories;

use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Region>
 */
class RegionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Self-contained (doesn't rely on RegionSeeder's curated list) so
        // tests/tinker can create regions in isolation. unique() avoids
        // colliding with the `name`/`slug` unique constraints.
        $name = ucfirst($this->faker->unique()->city());

        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }
}
