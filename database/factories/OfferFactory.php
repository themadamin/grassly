<?php

namespace Database\Factories;

use App\Enums\Currency;
use App\Enums\OfferStatus;
use App\Enums\OfferVisibility;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Region;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Offer>
 */
class OfferFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $availableFrom = $this->faker->dateTimeBetween('now', '+2 months');
        $totalQuantity = $this->faker->numberBetween(500, 50000);

        return [
            'product_id' => Product::factory(),
            // A closure sees resolved attributes, so product_id is already an id here.
            'user_id' => fn (array $attributes) => Product::findOrFail((int) $attributes['product_id'])->user_id,
            'title' => $this->faker->words(3, true),
            'total_quantity' => $totalQuantity,
            'remaining_quantity' => $totalQuantity,
            'unit' => $this->faker->randomElement(['kg', 'ton']),
            'currency' => Currency::USD->value,
            'price' => $this->faker->randomFloat(2, 5, 9999.99),
            'available_from' => $availableFrom,
            'available_to' => $this->faker->optional()->dateTimeBetween($availableFrom, '+6 months'),
            'description' => $this->faker->optional()->sentence(),
            'visibility' => $this->faker->randomElement(OfferVisibility::cases()),
            'status' => $this->faker->randomElement(OfferStatus::cases()),
        ];
    }

    /**
     * Deliverable zones aren't a column — attach them via the pivot after create.
     */
    public function configure(): static
    {
        return $this->afterCreating(function (Offer $offer): void {
            $offer->regions()->attach(
                Region::factory()->count($this->faker->numberBetween(1, 3))->create(),
            );
        });
    }
}
