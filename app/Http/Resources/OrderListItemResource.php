<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Lean Order payload for LIST rows (Orders list + campaign-detail claims list).
 * Matching TS shape: resources/js/types/order (`OrderListItem`). Needs `offer` (with its
 * `farmer`) and `merchant` loaded for the item title + counterparty name.
 *
 * @property-read Order $resource
 */
class OrderListItemResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $order = $this->resource;

        // Counterparty is role-relative: a merchant sees the selling farmer; a
        // farmer (incoming claims) sees the buying merchant.
        // TODO(you): confirm this matches how your controller scopes each list.
        $viewerIsFarmer = $request->user()?->hasRole('farmer') ?? false;
        $counterparty = $viewerIsFarmer
            ? ($order->merchant->name ?? 'Merchant')
            : ($order->offer->farmer->name ?? 'Farmer');

        return [
            'id' => $order->id,
            'reference' => sprintf('OR-%04d', $order->id),
            'item' => $order->offer->title ?? '—',
            'counterparty' => $counterparty,
            'quantity' => $order->quantity,
            'quantity_display' => number_format($order->quantity).' '.($order->offer->unit ?? ''),
            'status' => $order->status->value,
            'placed_at' => $order->created_at->format('M j'),
        ];
    }
}
