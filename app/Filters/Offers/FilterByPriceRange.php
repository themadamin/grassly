<?php

namespace App\Filters\Offers;

use App\Data\Filters\OfferFilterData;
use App\Filters\AbstractFilterPipe;
use Closure;
use Illuminate\Database\Eloquent\Builder;

/**
 * Narrow to offers whose price sits within [price_min, price_max].
 *
 * UNIT: both bounds are already INTEGER MINOR UNITS here — OfferFilterData::
 * fromRequest normalized the incoming major-unit dollars ×subunitFactor. The
 * `offers.price` column is ALSO minor units, so compare directly; do NOT ×100
 * again in this pipe. (This is the deliberate unit decision — see the note on
 * OfferFilterData.) Either bound may be null independently.
 *
 * @extends AbstractFilterPipe<OfferFilterData>
 */
class FilterByPriceRange extends AbstractFilterPipe
{
    public function handle(Builder $builder, Closure $next): Builder
    {
        $this->whenPresent($builder, $this->filters->price_min, function (Builder $builder, $min): void {
            // TODO(you): keep offers priced at or above $min (minor units).
            // Hint: $builder->where('price', '>=', $min);
        });

        $this->whenPresent($builder, $this->filters->price_max, function (Builder $builder, $max): void {
            // TODO(you): keep offers priced at or below $max (minor units).
            // Hint: $builder->where('price', '<=', $max);
        });

        return $next($builder);
    }
}
