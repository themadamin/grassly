<?php

namespace App\Filters\Market;

use App\Data\Filters\MarketFilterData;
use App\Filters\AbstractFilterPipe;
use Closure;
use Illuminate\Database\Eloquent\Builder;

/**
 * Narrow to offers whose product references one exact Crop (the typeahead
 * result the user picked — finer-grained than FilterByCategory).
 *
 * @extends AbstractFilterPipe<MarketFilterData>
 */
class FilterByCrop extends AbstractFilterPipe
{
    public function handle(Builder $builder, Closure $next): Builder
    {
        $this->whenPresent($builder, $this->filters->crop, function (Builder $builder, $cropId): void {
            // TODO(you): whereHas('product', …) — product.crop_id is one
            // relation away (unlike FilterByCategory, which goes two deep).
            // Hint:
            //   $builder->whereHas('product', fn (Builder $p) => $p->where('crop_id', $cropId));
        });

        return $next($builder);
    }
}
