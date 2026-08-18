<?php

namespace App\Filters\Market;

use App\Data\Filters\MarketFilterData;
use App\Filters\AbstractFilterPipe;
use Closure;
use Illuminate\Database\Eloquent\Builder;

/**
 * Two independent availability narrowings, both optional:
 *  - `availability = available_now` — a quick filter: is this offer's window
 *    open TODAY?
 *  - `date_from` / `date_to` — an explicit date range the buyer cares about;
 *    keep offers whose window OVERLAPS it (not just offers fully inside it).
 *
 * @extends AbstractFilterPipe<MarketFilterData>
 */
class FilterByAvailability extends AbstractFilterPipe
{
    public function handle(Builder $builder, Closure $next): Builder
    {
        $this->whenPresent($builder, $this->filters->availability, function (Builder $builder, $availability): void {
            // TODO(you): when $availability === 'available_now', keep offers
            // whose window brackets TODAY: available_from <= today AND
            // (available_to is null OR available_to >= today).
            // Hint:
            //   $builder->where('available_from', '<=', now())
            //       ->where(fn (Builder $q) => $q->whereNull('available_to')->orWhere('available_to', '>=', now()));
        });

        $this->whenPresent($builder, $this->filters->date_from, function (Builder $builder, $dateFrom): void {
            // TODO(you): OVERLAP test, not a strict "starts after" match — keep
            // offers where available_to is null OR available_to >= $dateFrom.
        });

        $this->whenPresent($builder, $this->filters->date_to, function (Builder $builder, $dateTo): void {
            // TODO(you): keep offers where available_from <= $dateTo.
        });

        return $next($builder);
    }
}
