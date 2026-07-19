<?php

namespace App\Enums;

/**
 * Supported currencies + everything money-related, in one place.
 *
 * USD only today, but every per-currency rule — symbol, decimal places, the
 * minor-unit factor, the max price, AND the conversion + display formatting —
 * lives here. Adding a currency later is a local change: add a `case` and its
 * arm in each match() below; nothing outside this enum hardcodes '$' or '/100'.
 *
 * Money convention: the DB stores INTEGER minor units (cents); the app works in
 * DECIMAL major units (dollars). MoneyCast uses toMinorUnits()/toMajorUnits()
 * to convert at the model boundary, so the rest of the app only ever sees a
 * plain decimal.
 */
enum Currency: string
{
    case USD = 'USD';

    /** Symbol rendered before the amount (prefix position for USD). */
    public function symbol(): string
    {
        return match ($this) {
            self::USD => '$',
        };
    }

    /** Decimal places of the major unit. USD → 2; JPY would be 0, BHD 3. */
    public function decimals(): int
    {
        return match ($this) {
            self::USD => 2,
        };
    }

    /** Minor units per major unit (10^decimals). USD → 100. */
    public function subunitFactor(): int
    {
        return 10 ** $this->decimals();
    }

    /** Max offer price in MINOR units (business rule). USD → 999999 = $9,999.99. */
    public function maxMinorUnits(): int
    {
        return match ($this) {
            self::USD => 999_999,
        };
    }

    /** Max offer price in MAJOR units, for validation rules. USD → 9999.99. */
    public function maxMajorUnits(): float
    {
        return $this->maxMinorUnits() / $this->subunitFactor();
    }

    /**
     * DECIMAL major units → INTEGER minor units, for storage. round() (never a
     * bare cast) so 12.10 → 1210, not 1209 — the only float→int step, isolated
     * here.
     */
    public function toMinorUnits(float $majorUnits): int
    {
        return (int) round($majorUnits * $this->subunitFactor());
    }

    /** INTEGER minor units → DECIMAL major units, for reading (999999 → 9999.99). */
    public function toMajorUnits(int $minorUnits): float
    {
        return $minorUnits / $this->subunitFactor();
    }

    /**
     * Decimal major units → display string with symbol + grouping:
     * 9999.99 → "$9,999.99". number_format groups thousands with ',' (American
     * convention) and pads to this currency's decimals.
     */
    public function format(float $majorUnits): string
    {
        return $this->symbol().number_format($majorUnits, $this->decimals());
    }
}
