<?php

namespace App\Data\Filters;

use App\Enums\Currency;
use App\Enums\MarketSortOption;
use App\Http\Requests\Market\IndexMarketRequest;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

/**
 * The normalized filter contract for the Market browse. Same shape/role as
 * OfferFilterData — every field optional, built via ::fromRequest, emitted to
 * the frontend as `App.Data.Filters.MarketFilterData` (via #[TypeScript]).
 *
 * UNIT NOTE — price_min / price_max are INTEGER MINOR UNITS here (cents), same
 * as OfferFilterData: ::fromRequest converts the incoming major-unit dollars
 * ×subunitFactor, so FilterByPriceRange compares straight against the
 * `offers.price` column with no math inside the pipe.
 *
 * `tab` (Selling/Buying/All) is NOT a field here — it decides which BASE QUERY
 * the pipeline runs against (see MarketController), not something a filter
 * pipe narrows, so it stays outside this DTO (same reasoning as `per_page`
 * staying outside OfferFilterData).
 */
#[TypeScript]
class MarketFilterData extends Data
{
    public function __construct(
        public readonly ?string $search = null,
        public readonly ?int $category = null,
        public readonly ?int $crop = null,
        public readonly ?int $region = null,
        public readonly ?string $availability = null,
        public readonly ?string $date_from = null,
        public readonly ?string $date_to = null,
        public readonly ?int $price_min = null,
        public readonly ?int $price_max = null,
        public readonly ?MarketSortOption $sort = null,
    ) {}

    public static function fromRequest(IndexMarketRequest $request): self
    {
        /** @var array<string, mixed> $v */
        $v = $request->validated();
        $currency = Currency::USD;

        return new self(
            search: $v['search'] ?? null,
            category: isset($v['category']) ? (int) $v['category'] : null,
            crop: isset($v['crop']) ? (int) $v['crop'] : null,
            region: isset($v['region']) ? (int) $v['region'] : null,
            availability: $v['availability'] ?? null,
            date_from: $v['date_from'] ?? null,
            date_to: $v['date_to'] ?? null,
            price_min: isset($v['price_min']) ? $currency->toMinorUnits((float) $v['price_min']) : null,
            price_max: isset($v['price_max']) ? $currency->toMinorUnits((float) $v['price_max']) : null,
            sort: isset($v['sort']) ? MarketSortOption::from($v['sort']) : null,
        );
    }
}
