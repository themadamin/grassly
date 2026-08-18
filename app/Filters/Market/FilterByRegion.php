<?php

namespace App\Filters\Market;

use App\Data\Filters\MarketFilterData;
use App\Filters\AbstractFilterPipe;
use Closure;
use Illuminate\Database\Eloquent\Builder;

/**
 * Narrow to offers that deliver to a region — same `regions` many-to-many
 * relation Offer's own FilterByRegion matches, just on the shared Market's
 * broader (multi-farmer) query. `region` here is a region id (closed list,
 * see RegionSeeder), same shape as `crop` above.
 *
 * @extends AbstractFilterPipe<MarketFilterData>
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
