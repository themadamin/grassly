<?php

namespace Database\Factories;

use App\Models\Demand;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Demand>
 *
 * Scaffold. Fill in `definition()` to spin up demands in tinker/tests.
 * Hint: a merchant User for user_id, plus title/category/quantity/price/region.
 */
class DemandFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // TODO(you): define default attributes for a Demand.
        return [];
    }
}
