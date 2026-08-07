<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDemandRequest;
use App\Http\Resources\DemandResource;
use App\Models\Demand;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

/**
 * Demands = merchant buy-offers, the mirror of Offer (Phase 4, Feature B).
 *
 * SCAFFOLD — action bodies stubbed. The frontend pages (demands/Index,
 * demands/Create, demands/Show) render from these prop shapes.
 */
class DemandController extends Controller
{
    /**
     * The merchant's own Demands (list).
     */
    public function index(): Response
    {
        // TODO(you): the current merchant's demands, mapped with
        // DemandListItemResource::collection(...). Mirror OfferController@index.
        return Inertia::render('demands/Index', [
            'demands' => [], // TODO(you)
        ]);
    }

    /**
     * The "new demand" form (frame 20 left).
     */
    public function create(): Response
    {
        return Inertia::render('demands/Create');
    }

    /**
     * Publish a demand.
     */
    public function store(StoreDemandRequest $request): RedirectResponse
    {
        // TODO(you): create the Demand for the current merchant. Mirror
        // OfferController@store — price arrives as major units; MoneyCast
        // converts. fulfilled_quantity starts at 0.
        return redirect()->route('demands.index');
    }

    /**
     * Demand detail (frame 20 right) — farmers view + claim against it.
     */
    public function show(Demand $demand): Response
    {
        return Inertia::render('demands/Show', [
            'demand' => DemandResource::make($demand->load('merchant')),
        ]);
    }
}
