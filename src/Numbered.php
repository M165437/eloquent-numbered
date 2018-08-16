<?php

namespace M165437\EloquentNumbered;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * @method static Builder numbered(Model $obj)
 */
trait Numbered
{
    /**
     * Boot Numbered Observer for event handling.
     *
     * @return void
     */
    public static function bootNumbered()
    {
        self::observe(NumberedObserver::class);
    }

    /**
     * Scope a query to number.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return \Illuminate\Database\Query\Builder
     */
    public function scopeNumbered(Builder $query, Model $model)
    {
        return $query->oldest();
    }
}