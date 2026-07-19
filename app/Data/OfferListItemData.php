<?php

namespace App\Data;

use App\Enums\Currency;
use App\Enums\OfferStatus;
use App\Enums\OfferVisibility;
use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

/**
 * Type-only DTO for the lean list shape — source of
 * `App.Data.OfferListItemData`. Payload built by
 * App\Http\Resources\OfferListItemResource; keep the two in sync.
 *
 * Lean: drops the farmer, description, and remaining_display the detail shape
 * (OfferData) carries, but keeps the nested `product` for the card heading.
 */
#[TypeScript]
class OfferListItemData extends Data
{
    public function __construct(
        public int $id,
        public ProductListItemData $product,
        public string $title,
        public string $region,
        public int $total_quantity,
        public int $remaining_quantity,
        public string $unit,
        public string $total_display,
        public float $price,
        public Currency $currency,
        public string $price_formatted,
        public OfferVisibility $visibility,
        public OfferStatus $status,
        public string $available_from,
        public ?string $available_to,
    ) {}
}
