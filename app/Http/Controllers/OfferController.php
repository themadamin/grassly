<?php

namespace App\Http\Controllers;

use App\Enums\OfferStatus;
use App\Enums\OfferVisibility;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Http\Resources\OfferListItemResource;
use App\Http\Resources\OfferResource;
use App\Http\Resources\ProductListItemResource;
use App\Models\Offer;
use App\Models\Product;
use App\Policies\OfferPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

#[UsePolicy(OfferPolicy::class)]
class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        // Eager load product so the list resource can nest it without an N+1
        // (and without tripping preventLazyLoading).
        $offers = Offer::query()
            ->with('product')
            ->where('user_id', request()->user()->id)
            ->latest()
            ->get();

        return Inertia::render('offers/Index', [
            'offers' => OfferListItemResource::collection($offers),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('offers/Create', [
            'statuses' => OfferStatus::options(),
            'visibilities' => OfferVisibility::options(),
            'products' => ProductListItemResource::collection($this->farmerProducts()),
            // Pre-select a product when arriving from a product page's shortcut.
            'selectedProductId' => request()->integer('product_id') ?: null,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOfferRequest $request): RedirectResponse
    {
        $data = $request->validated();

        // No order claims yet in Phase 3, so remaining starts equal to total.
        // price arrives as decimal dollars; MoneyCast converts to minor units.
        Offer::create([
            ...$data,
            'user_id' => $request->user()->id,
            'remaining_quantity' => $data['total_quantity'],
        ]);

        return redirect()->route('offers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Offer $offer): Response
    {
        return Inertia::render('offers/Show', [
            'offer' => OfferResource::make($offer->load(['product', 'farmer'])),
            // TODO(you) [Milestone A.3]: the claims (orders) placed against this
            // offer, mapped with OrderListItemResource::collection(...). Farmer
            // (owner) sees all incoming claims; a merchant sees just their own.
            // Empty until Phase 4 orders exist — the campaign-detail claims list
            // renders from this.
            'claims' => [],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Offer $offer): Response
    {
        return Inertia::render('offers/Edit', [
            'offer' => OfferResource::make($offer->load(['product', 'farmer'])),
            'statuses' => OfferStatus::options(),
            'visibilities' => OfferVisibility::options(),
            'products' => ProductListItemResource::collection($this->farmerProducts()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOfferRequest $request, Offer $offer): RedirectResponse
    {
        $data = $request->validated();

        // Phase 3 has no order claims, so remaining tracks total.
        // TODO(Phase 4): stop resetting remaining_quantity once orders decrement it.
        $offer->update([
            ...$data,
            'remaining_quantity' => $data['total_quantity'],
        ]);

        return redirect()->route('offers.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Offer $offer): RedirectResponse
    {
        $offer->delete();

        return redirect()->route('offers.index');
    }

    /**
     * The current farmer's products, for the offer form's product picker.
     *
     * @return Collection<int, Product>
     */
    private function farmerProducts(): Collection
    {
        return Product::query()
            ->where('user_id', request()->user()->id)
            ->orderBy('name')
            ->get();
    }
}
