<?php

namespace App\Http\Resources;

use App\Models\Demand;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Full Demand payload for the detail screen (frame 20). Matching TS shape:
 * resources/js/types/demand (`Demand`). The buy-side mirror of OfferResource.
 *
 * @property-read Demand $resource
 */
class DemandResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $demand = $this->resource;
        $progress = $demand->quantity > 0
            ? (int) round($demand->fulfilled_quantity / $demand->quantity * 100)
            : 0;

        return [
            'id' => $demand->id,
            'title' => $demand->title,
            'category' => $demand->category,
            'region' => $demand->region,
            'quantity' => $demand->quantity,
            'fulfilled_quantity' => $demand->fulfilled_quantity,
            'unit' => $demand->unit,
            'quantity_display' => number_format($demand->quantity).' '.$demand->unit,
            'fulfilled_display' => number_format($demand->fulfilled_quantity).' '.$demand->unit,
            'price' => $demand->price,
            'currency' => $demand->currency->value,
            'price_formatted' => $demand->currency->format($demand->price),
            'progress_percent' => $progress,
            'status' => $demand->status->value,
            'merchant_name' => $demand->merchant->name ?? 'Merchant',
            'needed_by' => $demand->needed_by?->format('Y-m-d'),
            'note' => $demand->note,
            // TODO(you) [Feature B]: farmer claims placed against this demand.
            // Symmetric with an offer's orders — load + map them here.
            'claims' => [],
        ];
    }
}
