<?php

namespace App\Filters\Market;

use App\Data\Filters\MarketFilterData;
use App\Filters\AbstractFilterPipe;
use Closure;
use Illuminate\Database\Eloquent\Builder;

/**
 * Narrow to offers whose product's crop belongs to a given Category (the
 * category CHIPS in the filter panel — coarser than a single crop).
 *
 * @extends AbstractFilterPipe<MarketFilterData>
 */
class FilterByCategory extends AbstractFilterPipe
{
    public function handle(Builder $builder, Closure $next): Builder
    {
        $this->whenPresent($builder, $this->filters->category, function (Builder $builder, $categoryId): void {
            // TODO(you): reach two relations deep — Offer -> Product -> Crop ->
            // category_id. whereHas('product.crop', …) does this in one
            // correlated subquery, same idea as FilterBySearch above.
            // Hint:
            //   $builder->whereHas('product.crop', fn (Builder $c) => $c->where('category_id', $categoryId));
        });

        return $next($builder);
    }
}
