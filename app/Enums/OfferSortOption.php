<?php

namespace App\Enums;

use Spatie\TypeScriptTransformer\Attributes\TypeScript;

/**
 * The allow-listed ways an offer index may be sorted.
 *
 * This is deliberately a backed enum rather than a loose string so the set of
 * legal sorts is typed on BOTH sides: PHP validates against it (IndexOfferRequest
 * uses `Rule::enum` / `values()`), and `#[TypeScript]` emits it as
 * `App.Enums.OfferSortOption` for the frontend sort dropdown. Adding a sort =
 * add a case here (and its column/direction arm in SortOffers) — nothing else.
 */
#[TypeScript]
enum OfferSortOption: string
{
    case NEWEST = 'newest';
    case OLDEST = 'oldest';
    case PRICE_ASC = 'price_asc';
    case PRICE_DESC = 'price_desc';

    /**
     * The default applied when the request names no sort. Keep in sync with
     * SortOffers' fallback so "no sort param" and "?sort=newest" behave the same.
     */
    public const DEFAULT = self::NEWEST;

    /**
     * All values as plain strings, for the `in:` / `Rule::enum` validation rule.
     *
     * @return array<int, string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
