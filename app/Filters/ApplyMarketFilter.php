<?php

namespace App\Filters;

use App\Data\Filters\MarketFilterData;
use App\Filters\Market\FilterByAvailability;
use App\Filters\Market\FilterByCategory;
use App\Filters\Market\FilterByCrop;
use App\Filters\Market\FilterByPriceRange;
use App\Filters\Market\FilterByRegion;
use App\Filters\Market\FilterBySearch;
use App\Filters\Market\SortMarketOffers;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

/**
 * Runs an already-scoped Offer query (see Offer::scopeOnMarket) through the
 * Market filter pipes. Same shape as ApplyOffersFilter — fixed order base
 * scope → filters → sort → paginate, this class owns only the middle two.
 */
class ApplyMarketFilter
{
    public function __construct(private readonly Pipeline $pipeline) {}

    /**
     * @param  Builder<Offer>  $builder  Already scoped to onMarket() (or an
     *                                   intentionally empty query for a tab
     *                                   with no data yet — see MarketController).
     * @return Builder<Offer>
     */
    public function __invoke(Builder $builder, MarketFilterData $filters): Builder
    {
        return $this->pipeline
            ->send($builder)
            ->through([
                new FilterBySearch($filters),
                new FilterByCategory($filters),
                new FilterByCrop($filters),
                new FilterByRegion($filters),
                new FilterByAvailability($filters),
                new FilterByPriceRange($filters),
                new SortMarketOffers($filters),
            ])
            ->thenReturn();
    }
}
