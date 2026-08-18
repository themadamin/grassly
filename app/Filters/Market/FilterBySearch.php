<?php

namespace App\Filters\Market;

use App\Data\Filters\MarketFilterData;
use App\Filters\AbstractFilterPipe;
use Closure;
use Illuminate\Database\Eloquent\Builder;

/**
 * Free-text search across the offer title/description and the crop name.
 *
 * @extends AbstractFilterPipe<MarketFilterData>
 */
class FilterBySearch extends AbstractFilterPipe
{
    public function handle(Builder $builder, Closure $next): Builder
    {
        $this->whenPresent($builder, $this->filters->search, function (Builder $builder, $term): void {
            // TODO(you): LIKE-match $term against the offer title, description,
            // AND the related crop's name — wrap the OR group in a nested
            // closure so it doesn't widen past the base scope (same reasoning
            // as Offer's FilterBySearch: a bare orWhere would widen the query).
            //
            // Hint:
            //   $builder->where(function (Builder $q) use ($term) {
            //       $q->where('title', 'like', "%{$term}%")
            //         ->orWhere('description', 'like', "%{$term}%")
            //         ->orWhereHas('product.crop', fn (Builder $c) => $c->where('name', 'like', "%{$term}%"));
            //   });
            //
            // Concept: whereHas('product.crop', …) reaches two relations deep —
            // Offer belongsTo Product belongsTo Crop — in one correlated subquery.
        });

        return $next($builder);
    }
}
