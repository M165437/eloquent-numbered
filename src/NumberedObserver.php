<?php

namespace M165437\EloquentNumbered;

use Illuminate\Database\Eloquent\Model;

class NumberedObserver
{
    /**
     * @var \M165437\EloquentNumbered\NumberedService
     */
    protected $service;

    /**
     * @param \M165437\EloquentNumbered\NumberedService $service
     */
    public function __construct(NumberedService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Model $model
     * @return void
     */
    public function created(Model $model)
    {
        $this->service->renumber($model);
    }

    /**
     * @param Model $model
     * @return void
     */
    public function updated(Model $model)
    {
        $this->service->renumber($model);
    }

    /**
     * @param Model $model
     * @return void
     */
    public function deleted(Model $model)
    {
        $this->service->deleteNumber($model);
        $this->service->renumber($model);
    }

    /**
     * @param Model $model
     * @return void
     */
    public function restored(Model $model)
    {
        $this->service->renumber($model);
    }
}