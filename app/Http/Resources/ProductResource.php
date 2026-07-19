<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Builds the JSON payload for a single Product (show/edit). Matching TS shape:
 * App\Data\ProductData. Needs the `farmer` relation loaded.
 *
 * @property-read Product $resource
 */
class ProductResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product = $this->resource;

        return [
            'id' => $product->id,
            'user_id' => $product->user_id,
            'name' => $product->name,
            'region' => $product->region,
            'notes' => $product->notes,
            // 0 unless the query loaded the count (withCount/loadCount('offers')).
            'offers_count' => (int) ($product->offers_count ?? 0),
            'farmer' => UserResource::make($product->farmer),
        ];
    }
}
