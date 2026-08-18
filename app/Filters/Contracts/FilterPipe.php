<?php

namespace App\Filters\Contracts;

use Closure;
use Illuminate\Database\Eloquent\Builder;

/**
 * A single, composable filter step for Illuminate\Pipeline.
 *
 * Each pipe receives the query being built, may NARROW it (never widen — see the
 * "filters only narrow" rule in CLAUDE.md → Filtering), then hands off to the
 * next pipe via $next. The base query scope (authorization) is applied by the
 * caller BEFORE the pipeline runs, so a pipe can only ever add constraints on
 * top of an already-authorized query.
 *
 * @phpstan-type PipeCallable Closure(Builder<*>): Builder<*>
 */
interface FilterPipe
{
    /**
     * @param  Builder<*>  $builder
     * @param  Closure(Builder<*>): Builder<*>  $next
     * @return Builder<*>
     */
    public function handle(Builder $builder, Closure $next): Builder;
}
