<?php

namespace App\Filters\Offers;

use App\Data\Filters\OfferFilterData;
use App\Filters\AbstractFilterPipe;
use Closure;
use Illuminate\Database\Eloquent\Builder;

/**
 * Free-text search across the offer title and (optionally) its product's name.
 *
 * @extends AbstractFilterPipe<OfferFilterData>
 */
class FilterBySearch extends AbstractFilterPipe
{
    public function handle(Builder $builder, Closure $next): Builder
    {
        $this->whenPresent($builder, $this->filters->search, function (Builder $builder, $term): void {
            // TODO(you): LIKE-match $term against the title, and/or the related
            // product name. Wrap the OR group in a nested closure so it doesn't
            // leak past the base scope (a bare orWhere would widen the query —
            // exactly what the "filters only narrow" rule forbids).
            //
            // Hint:
            //   $builder->where(function (Builder $q) use ($term) {
            //       $q->where('title', 'like', "%{$term}%")
            //         ->orWhereHas('product', fn (Builder $p) => $p->where('name', 'like', "%{$term}%"));
            //   });
            //
            // Concept: whereHas('product', …) filters offers by a condition on the
            // related Product row (a correlated EXISTS subquery).
            $builder->where(function (Builder $q) use ($term) {
                $q->where('title', 'like', "%{$term}%")
                    ->orWhereHas('product', fn (Builder $p) => $p->where('name', 'like', "%{$term}%"));
            });
        });

        return $next($builder);
    }
}
