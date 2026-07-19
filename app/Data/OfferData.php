<?php

namespace App\Data;

use App\Enums\Currency;
use App\Enums\OfferStatus;
use App\Enums\OfferVisibility;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

/**
 * Type-only DTO: the single source of the `App.Data.OfferData` TypeScript shape.
 *
 * SINGLE RESPONSIBILITY: declares the wire shape only — no mapping, no
 * formatting. The payload is built by App\Http\Resources\OfferResource; keep the
 * two in sync (add/rename/remove a field in both or the TS type lies).
 *
 * Post-reshape: an offer belongs to a `product` (nested lean), sells
 * `total_quantity`/`remaining_quantity` in `unit`, has `visibility`, and a
 * per-unit decimal `price` + preformatted `price_formatted`. Dates are 'Y-m-d'.
 */
#[TypeScript]
class OfferData extends Data
{
    public function __construct(
        public int $id,
        public int $user_id,
        public UserData $farmer,
        public ProductListItemData $product,
        // Kept, first-class field: a short farmer-authored headline for the offer.
        public string $title,
        public int $total_quantity,
        public int $remaining_quantity,
        public string $unit,
        public string $total_display,
        public string $remaining_display,
        public string $region,
        public float $price,
        public Currency $currency,
        public string $price_formatted,
        public OfferVisibility $visibility,
        public OfferStatus $status,
        public ?string $description,
        public string $available_from,
        public ?string $available_to,
    ) {}
}
