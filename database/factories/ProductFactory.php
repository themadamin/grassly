<?php

namespace Database\Factories;

use App\Models\Crop;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => $this->faker->randomElement(['Wheat', 'Maize', 'Rice', 'Barley', 'Potatoes', 'Soybeans', 'Tomatoes']),
            'crop_id' => Crop::factory(),
            'notes' => $this->faker->optional()->sentence(),
        ];
    }
}
