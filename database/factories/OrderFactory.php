<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 *
 * Scaffold. Fill in `definition()` to spin up claims in tinker/tests
 * (Milestone A.1 "see it"). Hint: reference an Offer via
 * Offer::factory() for offer_id, a merchant User for user_id, and snapshot
 * that offer's price onto `price`.
 */
class OrderFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // TODO(you): define default attributes for an Order claim.
        return [];
    }
}
