<?php

namespace App\Http\Controllers;

use App\Data\Filters\MarketFilterData;
use App\Enums\MarketTab;
use App\Filters\ApplyMarketFilter;
use App\Http\Requests\Market\IndexMarketRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\OfferListItemResource;
use App\Http\Resources\RegionResource;
use App\Models\Category;
use App\Models\Offer;
use App\Models\Region;
use Inertia\Inertia;
use Inertia\Response;

/**
 * The shared Market browse screen: public, on-sale offers (the sell side)
 * with segmented Selling / Buying / All tabs and server-side filters.
 *
 * Invokable — one route, one action (see the "prefer invokable controllers"
 * convention). Buying has no data until Demand exists (Phase 4) — that tab's
 * base query is intentionally empty rather than a special-cased response
 * shape, so the rest of the pipeline/pagination code stays identical either way.
 */
class MarketController extends Controller
{
    public function __invoke(IndexMarketRequest $request, ApplyMarketFilter $applyFilters): Response
    {
        $filters = MarketFilterData::fromRequest($request);
        $tab = $this->resolveTab($request);

        $baseQuery = $tab === MarketTab::BUYING
            ? Offer::query()->whereRaw('1 = 0')
            : Offer::query()->with(['product.crop.category', 'regions'])->onMarket();

        $offers = $applyFilters($baseQuery, $filters)
            ->paginate($request->integer('per_page', 20))
            ->withQueryString();

        return Inertia::render('market/Index', [
            'offers' => OfferListItemResource::collection($offers),
            'tab' => $tab->value,
            'filters' => $filters,
            'categories' => CategoryResource::collection(Category::all()),
            'regions' => RegionResource::collection(Region::all()),
        ]);
    }

    /**
     * Which tab to show: the request's explicit `tab` param, or a role-aware
     * default when none was given.
     */
    private function resolveTab(IndexMarketRequest $request): MarketTab
    {
        $requested = $request->validated('tab');

        if ($requested !== null) {
            return MarketTab::from($requested);
        }

        // TODO(you): role-aware default (see CLAUDE.md -> Domain model):
        // farmers default to Buying, merchants default to Selling. Hint:
        // $request->user()->hasRole(UserRole::Farmer->value) (spatie/laravel-permission)
        // or inspect the UserRole enum directly. Falls back to Selling for now.
        return MarketTab::SELLING;
    }
}
