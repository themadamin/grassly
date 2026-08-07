<?php

namespace App\Http\Resources;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Full Order payload for the detail + delivery-tracking screen (frame 18).
 * Matching TS shape: resources/js/types/order (`Order`). Needs `offer` (with `farmer` +
 * `product`) and `merchant` loaded.
 *
 * @property-read Order $resource
 */
class OrderResource extends JsonResource
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $order = $this->resource;
        $unit = $order->offer->unit ?? '';

        return [
            'id' => $order->id,
            'reference' => sprintf('OR-%04d', $order->id),
            'item' => $order->offer->title ?? '—',
            'quantity' => $order->quantity,
            'unit' => $unit,
            'quantity_display' => number_format($order->quantity).' '.$unit,
            // Snapshot price per unit; total = price × quantity, formatted in PHP.
            'price' => $order->price,
            'currency' => $order->currency->value,
            'price_formatted' => $order->currency->format($order->price),
            'total_formatted' => $order->currency->format($order->price * $order->quantity),
            'status' => $order->status->value,
            'seller_name' => $order->offer->farmer->name ?? 'Farmer',
            'buyer_name' => $order->merchant->name ?? 'Merchant',
            'delivery_window' => $order->delivery_window,
            // TODO(you): no destination column yet — derive from a merchant
            // profile/address when that exists, or add a column. Null for now.
            'destination' => null,
            'note' => $order->note,
            'placed_at' => $order->created_at->format('M j, Y'),
        ];
    }
}
