<?php

namespace App\Enums;

use Spatie\TypeScriptTransformer\Attributes\TypeScript;

/**
 * The allow-listed ways the Market's offer results may be sorted. Same
 * convention as OfferSortOption — typed on both sides via #[TypeScript].
 */
#[TypeScript]
enum MarketSortOption: string
{
    case NEWEST = 'newest';
    case OLDEST = 'oldest';
    case PRICE_ASC = 'price_asc';
    case PRICE_DESC = 'price_desc';
    case QUANTITY = 'quantity';

    /**
     * The default applied when the request names no sort.
     */
    public const DEFAULT = self::NEWEST;

    /**
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
