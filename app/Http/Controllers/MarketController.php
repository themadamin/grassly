<?php

namespace App\Http\Controllers;

use App\Http\Resources\OfferListItemResource;
use App\Models\Offer;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

/**
 * The shared Market browse screen: public offers (the sell side) with
 * segmented Selling / Buying / All tabs and server-side filters.
 *
 * Invokable — one route, one action (see the "prefer invokable controllers"
 * convention). In Phase 3 only the Selling tab has data; the Buying tab
 * (merchant Demands) is reserved for Phase 4, so the page shows a coming-soon
 * state for it.
 *
 * Concept: an invokable controller has a single `__invoke()` method, so the
 * route binds the class directly (`Route::get('/market', MarketController::class)`)
 * with no method name.
 */
class MarketController extends Controller
{
    public function __invoke(Request $request): Response
    {
        // TODO(you) [Milestone 4.1 + 4.2]: build the browse query and return it.
        //
        // Everything below is a scaffold so the page renders — replace the
        // placeholder values with your real query + filter logic. Work in two
        // passes matching the checklist:
        //
        //  4.1 — the browse query (the Selling tab):
        //    • Only PUBLIC offers appear on the Market. Filter on the
        //      `visibility` column === OfferVisibility::Public. (Consider a
        //      query scope on the Offer model, e.g. scopePublic(), so this
        //      rule lives in one place — Concept: Eloquent local scopes.)
        //    • Only live offers: status === OfferStatus::OnSale (hide draft/closed).
        //    • Eager-load `product` so OfferListItemResource can nest it without
        //      an N+1 (same as OfferController@index). If you decide the card
        //      needs the farmer's name, eager-load `farmer` too AND add that
        //      field to OfferListItemResource/OfferListItemData (see the page's
        //      TODO about the farmer sub-line).
        //    • Reuse OfferListItemResource::collection(...) for the payload.
        //
        //  Role-aware default tab (Concept: request()->user()->hasRole() from
        //    spatie/laravel-permission, or read the UserRole enum):
        //    • farmers default to 'buying', merchants default to 'selling'
        //      (see CLAUDE.md → Domain model). Read the requested tab from
        //      request()->query('tab') and fall back to the role default.
        //    • In Phase 3 the 'buying' tab returns no offers (Demands is Phase 4)
        //      — the page renders its own coming-soon state for that tab.
        //
        //  4.2 — server-side filters (Concept: request()->query() + Eloquent
        //    conditional clauses via ->when($value, fn ($q) => ...)):
        //    • search   → match crop/title/region/farmer (a LIKE across columns)
        //    • crop     → filter by product/crop
        //    • region   → filter by region
        //    • availability → e.g. available_from/available_to windows
        //    Apply them in the query, NOT on the frontend. Echo the active
        //    values back in `filters` so the page can show them (chips + inputs).

        $tab = $request->query('tab', 'selling'); // TODO(you): role-aware default

        $offers = Offer::query()
            ->with('product')
            // TODO(you): ->public()->where('status', OfferStatus::OnSale)
            // TODO(you): ->when(...) filter clauses, then paginate/limit as you like
            ->whereRaw('1 = 0') // placeholder: returns nothing until you write the query
            ->latest()
            ->get();

        return Inertia::render('market/Index', [
            'offers' => OfferListItemResource::collection($offers),
            'tab' => $tab,
            'filters' => [
                'search' => $request->query('search'),
                'crop' => $request->query('crop'),
                'region' => $request->query('region'),
                'availability' => $request->query('availability'),
            ],
        ]);
    }
}
