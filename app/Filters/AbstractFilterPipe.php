<?php

namespace App\Filters;

use App\Filters\Contracts\FilterPipe;
use Illuminate\Database\Eloquent\Builder;

/**
 * Shared base for every filter pipe.
 *
 * Holds the normalized filter DTO (injected once, when the pipeline is
 * assembled) and offers `whenPresent()` so each concrete pipe runs its query
 * fragment ONLY when its value is actually set — an absent filter is a no-op,
 * never an empty `where` that would match nothing.
 *
 * Reusable across models via a generic: a concrete pipe declares which DTO it
 * carries with `@extends AbstractFilterPipe<OfferFilterData>`, which lets static
 * analysis (and your editor) type `$this->filters->...` correctly even though
 * the base itself only knows it holds "some filter object".
 *
 * @template TFilter of object
 */
abstract class AbstractFilterPipe implements FilterPipe
{
    /**
     * @param  TFilter  $filters
     */
    public function __construct(protected readonly object $filters) {}

    /**
     * Run $callback only when $value is meaningfully present.
     *
     * "Present" = not null and not an empty string — so `?status=` (blank) and a
     * missing key both skip. The builder is passed THROUGH to the callback (not
     * captured via `use`) so each pipe's body reads `$builder->where(...)` with
     * no closure-capture bookkeeping; the value comes second, already unwrapped.
     * Eloquent builders mutate in place, so nothing is returned.
     *
     * @param  Builder<*>  $builder
     * @param  callable(Builder<*>, mixed): void  $callback
     */
    protected function whenPresent(Builder $builder, mixed $value, callable $callback): void
    {
        if ($value === null || $value === '') {
            return;
        }

        $callback($builder, $value);
    }
}
