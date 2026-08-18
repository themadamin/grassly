<?php

namespace App\Filters\Offers;

use App\Data\Filters\OfferFilterData;
use App\Filters\AbstractFilterPipe;
use Closure;
use Illuminate\Database\Eloquent\Builder;

/**
 * Narrow to a single OfferStatus (draft / on_sale / closed).
 *
 * The UI's segmented control has an extra "All" tab — that means NO status
 * filter, and the frontend sends no `status` param for it, so `whenPresent`
 * already skips this pipe. There is no "all" enum case.
 *
 * @extends AbstractFilterPipe<OfferFilterData>
 */
class FilterByStatus extends AbstractFilterPipe
{
    public function handle(Builder $builder, Closure $next): Builder
    {
        $this->whenPresent($builder, $this->filters->status, function (Builder $builder, $status): void {
            // TODO(you): narrow the query to this status.
            // $status is an OfferStatus enum instance (already validated). Eloquent
            // will use its ->value when compared against the string column.
            // Hint: $builder->where('status', $status);
        });

        return $next($builder);
    }
}
