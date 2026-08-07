<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Lean Product payload for the Storage index list. Matching TS shape:
 * resources/js/types/product (`ProductListItem`).
 *
 * @property-read Product $resource
 */
class ProductListItemResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product = $this->resource;

        return [
            'id' => $product->id,
            'name' => $product->name,
            'region' => $product->region,
            'notes' => $product->notes,
            // 0 unless the query loaded the count (withCount('offers')).
            'offers_count' => (int) ($product->offers_count ?? 0),
        ];
    }
}
