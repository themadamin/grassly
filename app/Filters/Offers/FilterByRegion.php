<?php

namespace App\Filters\Offers;

use App\Data\Filters\OfferFilterData;
use App\Filters\AbstractFilterPipe;
use Closure;
use Illuminate\Database\Eloquent\Builder;

/**
 * Narrow to offers that deliver to a region. `region` is a region id (closed
 * list, see RegionSeeder) matched against the offer's `regions` (many-to-many
 * deliverable zones).
 *
 * @extends AbstractFilterPipe<OfferFilterData>
 */
class FilterByRegion extends AbstractFilterPipe
{
    public function handle(Builder $builder, Closure $next): Builder
    {
        $this->whenPresent($builder, $this->filters->region, function (Builder $builder, $regionId): void {
            $builder->whereHas('regions', fn (Builder $query) => $query->where('regions.id', $regionId));
        });

        return $next($builder);
    }
}
