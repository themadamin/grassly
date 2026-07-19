<?php

namespace App\Http\Resources;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Builds the JSON payload for a single Offer (show/edit screens), including the
 * money/quantity display formatting. Matching TS shape: App\Data\OfferData.
 *
 * Needs `product` and `farmer` relations loaded (controller loads both).
 *
 * @property-read Offer $resource
 */
class OfferResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $offer = $this->resource;

        return [
            'id' => $offer->id,
            'user_id' => $offer->user_id,
            'farmer' => UserResource::make($offer->farmer),
            'product' => ProductListItemResource::make($offer->product),
            'title' => $offer->title,
            // Quantity is an integer in `unit`; *_display are the presentation
            // strings (e.g. "2,400 kg"). remaining decrements via orders (Phase 4).
            'total_quantity' => $offer->total_quantity,
            'remaining_quantity' => $offer->remaining_quantity,
            'unit' => $offer->unit,
            'total_display' => number_format($offer->total_quantity).' '.$offer->unit,
            'remaining_display' => number_format($offer->remaining_quantity).' '.$offer->unit,
            'region' => $offer->region,
            // MoneyCast exposes `price` as a decimal (per unit); currency formats it.
            'price' => $offer->price,
            'currency' => $offer->currency->value,
            'price_formatted' => $offer->currency->format($offer->price),
            'visibility' => $offer->visibility->value,
            'status' => $offer->status->value,
            'description' => $offer->description,
            'available_from' => $offer->available_from->format('Y-m-d'),
            'available_to' => $offer->available_to?->format('Y-m-d'),
        ];
    }
}
