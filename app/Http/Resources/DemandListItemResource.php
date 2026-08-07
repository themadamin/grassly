<?php

namespace App\Http\Resources;

use App\Models\Demand;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Lean Demand payload for the merchant's Demands index. Matching TS shape:
 * resources/js/types/demand (`DemandListItem`).
 *
 * @property-read Demand $resource
 */
class DemandListItemResource extends JsonResource
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
            'price' => $demand->price,
            'currency' => $demand->currency->value,
            'price_formatted' => $demand->currency->format($demand->price),
            'progress_percent' => $progress,
            'status' => $demand->status->value,
        ];
    }
}
