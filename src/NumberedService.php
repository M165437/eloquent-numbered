<?php

namespace M165437\EloquentNumbered;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class NumberedService
{
    /**
     * @param Model $model
     * @return void
     */
    public function renumber(Model $model)
    {
        DB::statement(DB::raw('set @num=0'));

        $column = $this->getNumberColumn($model);
        $value = DB::raw("(SELECT @num := @num + 1)");

        get_class($model)::numbered($model)->update([$column => $value]);
    }

    /**
     * @param Model $model
     * @return void
     */
    public function deleteNumber(Model $model)
    {
        if ($this->isSoftDeleting($model)) {
            $model->{$this->getNumberColumn($model)} = null;
            $model->save();
        }
    }

    /**
     * @param $model
     * @return bool
     */
    private function isSoftDeleting(Model $model)
    {
        return property_exists($model, 'forceDeleting');
    }

    /**
     * @param Model $model
     * @return string
     */
    private function getNumberColumn(Model $model)
    {
        $class = get_class($model);

        return defined($class.'::NUMBER') ? constant($class.'::NUMBER') : 'number';
    }
}