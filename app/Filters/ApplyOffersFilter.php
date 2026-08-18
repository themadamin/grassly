<?php

namespace App\Filters;

use App\Data\Filters\OfferFilterData;
use App\Filters\Offers\FilterByAvailability;
use App\Filters\Offers\FilterByPriceRange;
use App\Filters\Offers\FilterByProduct;
use App\Filters\Offers\FilterByRegion;
use App\Filters\Offers\FilterBySearch;
use App\Filters\Offers\FilterByStatus;
use App\Filters\Offers\SortOffers;
use App\Models\Offer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pipeline\Pipeline;

/**
 * Runs an already-authorized Offer query through the offer filter pipes.
 *
 * FIXED ORDER (see CLAUDE.md → Filtering): base scope → filters → sort →
 * paginate. This class owns only the middle two: the CALLER applies the base
 * (authorization) scope first and paginates the result — pagination is NOT done
 * here so the caller controls page size and `withQueryString()`. Every pipe is
 * constructed with the same DTO; each narrows the query or (SortOffers) orders
 * it, and none can widen past the base scope it was handed.
 */
class ApplyOffersFilter
{
    public function __construct(private readonly Pipeline $pipeline) {}

    /**
     * @param  Builder<Offer>  $builder  Already scoped to the authorized set.
     * @return Builder<Offer>
     */
    public function __invoke(Builder $builder, OfferFilterData $filters): Builder
    {
        return $this->pipeline
            ->send($builder)
            ->through([
                new FilterBySearch($filters),
                new FilterByStatus($filters),
                new FilterByPriceRange($filters),
                new FilterByProduct($filters),
                new FilterByRegion($filters),
                new FilterByAvailability($filters),
                new SortOffers($filters),
            ])
            ->thenReturn();
    }
}
