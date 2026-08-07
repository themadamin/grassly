<?php

namespace App\Http\Resources;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Lean Offer payload for LIST screens (index/market cards) — no farmer,
 * description, or availability text beyond dates. Matching TS shape:
 * resources/js/types/offer (`OfferListItem`). Needs `product` loaded (index eager loads it).
 *
 * @property-read Offer $resource
 */
class OfferListItemResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $offer = $this->resource;

        return [
            'id' => $offer->id,
            'product' => ProductListItemResource::make($offer->product),
            'title' => $offer->title,
            'region' => $offer->region,
            'total_quantity' => $offer->total_quantity,
            'remaining_quantity' => $offer->remaining_quantity,
            'unit' => $offer->unit,
            'total_display' => number_format($offer->total_quantity).' '.$offer->unit,
            'price' => $offer->price,
            'currency' => $offer->currency->value,
            'price_formatted' => $offer->currency->format($offer->price),
            'visibility' => $offer->visibility->value,
            'status' => $offer->status->value,
            'status_label' => $offer->status->label(),
            'available_from' => $offer->available_from->format('Y-m-d'),
            'available_to' => $offer->available_to?->format('Y-m-d'),
        ];
    }
}
