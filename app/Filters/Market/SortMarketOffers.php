<?php

namespace App\Filters\Market;

use App\Data\Filters\MarketFilterData;
use App\Enums\MarketSortOption;
use App\Filters\AbstractFilterPipe;
use Closure;
use Illuminate\Database\Eloquent\Builder;

/**
 * Apply the allow-listed sort. Runs LAST, same role as Offer's SortOffers:
 * always orders the query (falls back to MarketSortOption::DEFAULT when no
 * sort was given), so results are never returned in undefined order.
 *
 * @extends AbstractFilterPipe<MarketFilterData>
 */
class SortMarketOffers extends AbstractFilterPipe
{
    public function handle(Builder $builder, Closure $next): Builder
    {
        $sort = $this->filters->sort ?? MarketSortOption::DEFAULT;

        // TODO(you): map $sort to an orderBy column + direction with match().
        // QUANTITY means "most available first" — order by remaining_quantity.
        //
        // Hint:
        //   match ($sort) {
        //       MarketSortOption::NEWEST     => $builder->latest(),
        //       MarketSortOption::OLDEST     => $builder->oldest(),
        //       MarketSortOption::PRICE_ASC  => $builder->orderBy('price'),
        //       MarketSortOption::PRICE_DESC => $builder->orderByDesc('price'),
        //       MarketSortOption::QUANTITY   => $builder->orderByDesc('remaining_quantity'),
        //   };

        return $next($builder);
    }
}
