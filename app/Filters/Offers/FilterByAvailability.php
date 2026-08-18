<?php

namespace App\Filters\Offers;

use App\Data\Filters\OfferFilterData;
use App\Filters\AbstractFilterPipe;
use Closure;
use Illuminate\Database\Eloquent\Builder;

/**
 * Narrow to offers available within a date window (overlap test). Extension stub.
 *
 * Not yet wired to a DTO field — when you add availability filtering, add the
 * date bounds to OfferFilterData + IndexOfferRequest first, then filter here.
 *
 * @extends AbstractFilterPipe<OfferFilterData>
 */
class FilterByAvailability extends AbstractFilterPipe
{
    public function handle(Builder $builder, Closure $next): Builder
    {
        // TODO(you): follow the same pattern. This is a date-WINDOW OVERLAP, not a
        // point match: an offer [available_from, available_to] overlaps a requested
        // [from, to] when available_from <= to AND (available_to is null OR
        // available_to >= from). Add the request fields + DTO props, then gate each
        // side with whenPresent before writing the where.

        return $next($builder);
    }
}
