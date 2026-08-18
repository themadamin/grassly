<?php

namespace App\Filters\Offers;

use App\Data\Filters\OfferFilterData;
use App\Enums\OfferSortOption;
use App\Filters\AbstractFilterPipe;
use Closure;
use Illuminate\Database\Eloquent\Builder;

/**
 * Apply the allow-listed sort. Runs LAST in the pipeline (order after narrowing,
 * before the caller paginates).
 *
 * Unlike the narrowing pipes this ALWAYS orders the query: if no sort was given
 * it falls back to OfferSortOption::DEFAULT (newest first), so results are never
 * returned in undefined order. Because `sort` is a validated enum, the mapping
 * below is total and safe — no user string reaches the `orderBy` column.
 *
 * @extends AbstractFilterPipe<OfferFilterData>
 */
class SortOffers extends AbstractFilterPipe
{
    public function handle(Builder $builder, Closure $next): Builder
    {
        $sort = $this->filters->sort ?? OfferSortOption::DEFAULT;

        // TODO(you): map $sort (an OfferSortOption) to an orderBy column +
        // direction. Use a match() so adding an enum case forces a new arm here.
        //
        // Hint:
        //   match ($sort) {
        //       OfferSortOption::NEWEST    => $builder->latest(),               // created_at desc
        //       OfferSortOption::OLDEST    => $builder->oldest(),               // created_at asc
        //       OfferSortOption::PRICE_ASC => $builder->orderBy('price'),
        //       OfferSortOption::PRICE_DESC=> $builder->orderByDesc('price'),
        //   };
        //
        // Concept: the sort column is chosen from a FIXED enum → column map, never
        // from raw request text, so this can't become an ORDER BY injection.

        return $next($builder);
    }
}
