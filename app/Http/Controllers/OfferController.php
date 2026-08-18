<?php

namespace App\Http\Controllers;

use App\Data\Filters\OfferFilterData;
use App\Enums\OfferStatus;
use App\Enums\OfferVisibility;
use App\Filters\ApplyOffersFilter;
use App\Http\Requests\Offer\IndexOfferRequest;
use App\Http\Requests\StoreOfferRequest;
use App\Http\Requests\UpdateOfferRequest;
use App\Http\Resources\OfferListItemResource;
use App\Http\Resources\OfferResource;
use App\Http\Resources\ProductListItemResource;
use App\Http\Resources\RegionResource;
use App\Models\Offer;
use App\Models\Product;
use App\Models\Region;
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
     *
     * Fixed order: base scope → filters → sort → paginate. The base scope
     * (whereOwnedBy) is applied FIRST and is not a user-supplied filter — the
     * pipeline can only narrow it, never widen it, so no query param can surface
     * another farmer's offers.
     */
    public function index(IndexOfferRequest $request, ApplyOffersFilter $applyFilters): Response
    {
        $filters = OfferFilterData::fromRequest($request);

        $offers = $applyFilters(
            Offer::query()
                ->with(['product.crop.category', 'regions'])
                ->whereOwnedBy($request->user()),
            $filters,
        )
            ->paginate($request->integer('per_page', 20))
            ->withQueryString();

        return Inertia::render('offers/Index', [
            'offers' => OfferListItemResource::collection($offers),
            'filters' => $filters,
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
            'regions' => RegionResource::collection(Region::all()),
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
        $regionIds = $data['region_ids'];
        unset($data['region_ids']);

        $offer = Offer::create([
            ...$data,
            'user_id' => $request->user()->id,
            'remaining_quantity' => $data['total_quantity'],
        ]);

        $offer->regions()->sync($regionIds);

        return redirect()->route('offers.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Offer $offer): Response
    {
        return Inertia::render('offers/Show', [
            'offer' => OfferResource::make($offer->load(['product.crop.category', 'farmer', 'regions'])),
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
            'offer' => OfferResource::make($offer->load(['product.crop.category', 'farmer', 'regions'])),
            'statuses' => OfferStatus::options(),
            'visibilities' => OfferVisibility::options(),
            'products' => ProductListItemResource::collection($this->farmerProducts()),
            'regions' => RegionResource::collection(Region::all()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOfferRequest $request, Offer $offer): RedirectResponse
    {
        $data = $request->validated();
        $regionIds = $data['region_ids'];
        unset($data['region_ids']);

        // TODO(Phase 4): stop resetting remaining_quantity once orders decrement it.
        $offer->update([
            ...$data,
            'remaining_quantity' => $data['total_quantity'],
        ]);

        $offer->regions()->sync($regionIds);

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
            ->with('crop.category')
            ->orderBy('name')
            ->get();
    }
}
