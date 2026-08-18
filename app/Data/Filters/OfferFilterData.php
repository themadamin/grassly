<?php

namespace App\Data\Filters;

use App\Enums\Currency;
use App\Enums\OfferSortOption;
use App\Enums\OfferStatus;
use App\Http\Requests\Offer\IndexOfferRequest;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

/**
 * The single, normalized filter contract for the offer index.
 *
 * Built from the validated request (::fromRequest) and passed to the pipeline.
 * Every field is nullable because filters are optional — a null field means
 * "don't filter on this" (the matching pipe's `whenPresent` skips it). Emitted
 * to the frontend as `App.Data.OfferFilterData` (via `#[TypeScript]`), so the UI
 * types its filter state against the exact same shape.
 *
 * UNIT NOTE — price_min / price_max are stored here in INTEGER MINOR UNITS
 * (cents). The request receives DECIMAL major units (dollars, like the create
 * form) and ::fromRequest normalizes them ×subunitFactor. That keeps the
 * conversion at the request→DTO boundary (mirroring how MoneyCast converts at
 * the model boundary), so FilterByPriceRange compares straight against the
 * `offers.price` column — also minor units — with no math inside the pipe.
 */
#[TypeScript]
class OfferFilterData extends Data
{
    public function __construct(
        public readonly ?OfferStatus $status = null,
        public readonly ?string $search = null,
        public readonly ?int $price_min = null,
        public readonly ?int $price_max = null,
        public readonly ?int $product_id = null,
        public readonly ?int $region = null,
        public readonly ?OfferSortOption $sort = null,
    ) {}

    /**
     * Assemble the DTO from validated input. Only allow-listed keys are present
     * (see IndexOfferRequest::rules), so nothing unexpected can leak into a pipe.
     */
    public static function fromRequest(IndexOfferRequest $request): self
    {
        /** @var array<string, mixed> $v */
        $v = $request->validated();
        $currency = Currency::USD;

        return new self(
            status: isset($v['status']) ? OfferStatus::from($v['status']) : null,
            search: $v['search'] ?? null,
            // Major dollars → integer minor units, so the pipe needs no conversion.
            price_min: isset($v['price_min']) ? $currency->toMinorUnits((float) $v['price_min']) : null,
            price_max: isset($v['price_max']) ? $currency->toMinorUnits((float) $v['price_max']) : null,
            product_id: isset($v['product_id']) ? (int) $v['product_id'] : null,
            region: isset($v['region']) ? (int) $v['region'] : null,
            sort: isset($v['sort']) ? OfferSortOption::from($v['sort']) : null,
        );
    }
}
