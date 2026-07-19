<?php

namespace App\Casts;

use App\Enums\Currency;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

/**
 * The money boundary: the column stores INTEGER minor units (cents), the app
 * reads/writes DECIMAL major units (dollars).
 *
 *   get(): DB int cents (999999)  →  decimal dollars (9999.99) the app sees
 *   set(): decimal dollars input  →  int cents actually stored
 *
 * All conversion lives in the Currency enum (toMinorUnits/toMajorUnits), which
 * this reads off the row's own `currency` column — so each offer converts by
 * its own currency's factor. Because storage stays integer, the source of truth
 * is exact; the decimal is only a transient read/edit representation, so avoid
 * doing money ARITHMETIC on it (sum in SQL on the integer column instead).
 *
 * Register on the model:  'price' => MoneyCast::class
 *
 * @implements CastsAttributes<float, float>
 */
class MoneyCast implements CastsAttributes
{
    /**
     * Read the currency from the row being cast, defaulting to USD when the
     * column isn't present yet (e.g. mid-build). All current currencies use
     * factor 100, so the default only matters once a non-2-decimal currency
     * exists AND is assigned in the same call before price — set `currency`
     * before `price` in that case.
     *
     * @param  array<string, mixed>  $attributes
     */
    private function currency(array $attributes): Currency
    {
        return Currency::tryFrom($attributes['currency'] ?? '') ?? Currency::USD;
    }

    /**
     * DB integer minor units → decimal major units. Null stays null so "no
     * price" is distinct from "$0.00".
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value === null
            ? null
            : $this->currency($attributes)->toMajorUnits((int) $value);
    }

    /**
     * Decimal major units → integer minor units for storage. This is where
     * user-entered dollars become the cents the column holds.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $value === null
            ? null
            : $this->currency($attributes)->toMinorUnits((float) $value);
    }
}
