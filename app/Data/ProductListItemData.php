<?php

namespace App\Data;

use Spatie\LaravelData\Data;
use Spatie\TypeScriptTransformer\Attributes\TypeScript;

/**
 * Type-only DTO: the lean `App.Data.ProductListItemData` shape (Storage index).
 * Payload is built by App\Http\Resources\ProductListItemResource.
 */
#[TypeScript]
class ProductListItemData extends Data
{
    public function __construct(
        public int $id,
        public string $name,
        public string $region,
        public ?string $notes,
        public int $offers_count,
    ) {}
}
