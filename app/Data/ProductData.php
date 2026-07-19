<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

/**
 * Type-only DTO: the `App.Data.ProductData` shape (detail screens). Payload is
 * built by App\Http\Resources\ProductResource — keep the two in sync. The lean
 * list variant is ProductListItemData.
 */
#[TypeScript]
class ProductData extends Data
{
    public function __construct(
        public int $id,
        public int $user_id,
        public string $name,
        public string $region,
        public ?string $notes,
        public int $offers_count,
        public UserData $farmer,
    ) {}
}
