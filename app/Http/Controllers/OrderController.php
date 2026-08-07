<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Orders = claims placed against Offers (Phase 4, Feature A).
 *
 * SCAFFOLD — every action body below is stubbed for you. The frontend pages
 * (orders/Index, orders/Show) already render from these prop shapes; wire the
 * real queries + the claim transaction as your Milestone A.2–A.4 learning.
 */
class OrderController extends Controller
{
    /**
     * The Orders list (frame 19). Role-aware:
     *  - merchant → the claims THEY placed
     *  - farmer   → incoming claims against THEIR offers
     * Filtered by the status tab (all / in_transit / delivered / cancelled).
     */
    public function index(Request $request): Response
    {
        // TODO(you): build the role-scoped, tab-filtered query, then map with
        // OrderListItemResource::collection(...). Concept: request()->user()
        // ->hasRole('farmer'); scope by offer ownership vs. own claims; and a
        // ->when($tab !== 'all', fn ($q) => $q->where('status', $tab)) filter.
        return Inertia::render('orders/Index', [
            'orders' => [], // TODO(you)
            'tab' => $request->query('tab', 'all'),
        ]);
    }

    /**
     * Order detail + delivery tracking (frame 18).
     */
    public function show(Order $order): Response
    {
        // TODO(you): authorize the viewer (policy: buyer or the offer's farmer
        // only), then eager-load what OrderResource needs.
        return Inertia::render('orders/Show', [
            'order' => OrderResource::make(
                $order->load(['offer.farmer', 'offer.product', 'merchant']),
            ),
        ]);
    }

    /**
     * Place a claim against an offer (frame 16 modal → POST here).
     *
     * TODO(you) [Milestone A.2 — the KEY rule]: inside a DB transaction,
     *   1. re-read the offer and assert quantity <= remaining_quantity,
     *   2. create the Order snapshotting the offer's price onto it,
     *   3. decrement offers.remaining_quantity,
     *   4. close the offer (status → closed) if it hits zero.
     * Concept: DB::transaction(fn () => ...) keeps the create + decrement atomic
     * so two merchants can't oversell the same kilo.
     */
    public function store(StoreOrderRequest $request): RedirectResponse
    {
        // TODO(you)
        return redirect()->route('orders.index');
    }
}
