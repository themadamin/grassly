<?php

namespace App\Filters\Market;

use App\Data\Filters\MarketFilterData;
use App\Filters\AbstractFilterPipe;
use Closure;
use Illuminate\Database\Eloquent\Builder;

/**
 * Narrow to offers priced within [price_min, price_max] — same UNIT rule as
 * Offer's FilterByPriceRange: both bounds already arrive as INTEGER MINOR
 * UNITS (MarketFilterData::fromRequest converted them), so compare directly
 * against `offers.price`, no ×100 in here.
 *
 * @extends AbstractFilterPipe<MarketFilterData>
 */
class FilterByPriceRange extends AbstractFilterPipe
{
    public function handle(Builder $builder, Closure $next): Builder
    {
        $this->whenPresent($builder, $this->filters->price_min, function (Builder $builder, $min): void {
            // TODO(you): $builder->where('price', '>=', $min);
        });

        $this->whenPresent($builder, $this->filters->price_max, function (Builder $builder, $max): void {
            // TODO(you): $builder->where('price', '<=', $max);
        });

        return $next($builder);
    }
}
