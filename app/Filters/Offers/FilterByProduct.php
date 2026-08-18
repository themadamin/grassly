<?php

namespace App\Filters\Offers;

use App\Data\Filters\OfferFilterData;
use App\Filters\AbstractFilterPipe;
use Closure;
use Illuminate\Database\Eloquent\Builder;

/**
 * Narrow to a single product. Extension stub — follows the same pattern as the
 * reference pipes (FilterByStatus etc.).
 *
 * @extends AbstractFilterPipe<OfferFilterData>
 */
class FilterByProduct extends AbstractFilterPipe
{
    public function handle(Builder $builder, Closure $next): Builder
    {
        $this->whenPresent($builder, $this->filters->product_id, function (Builder $builder, $productId): void {
            // TODO(you): follow the same pattern as the reference pipes. First
            // confirm whether product is a column on offers (`product_id` — it is,
            // it's the FK) so a plain where suffices, vs. a relation filter.
            // Hint: $builder->where('product_id', $productId);
        });

        return $next($builder);
    }
}
