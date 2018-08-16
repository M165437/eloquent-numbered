<?php

namespace M165437\EloquentNumbered\Test;

use Illuminate\Database\Eloquent\Model;
use M165437\EloquentNumbered\Numbered;

class DummyWithCustomScope extends Model
{
    use Numbered;

    protected $table = 'dummies';
    protected $guarded = [];
    public $timestamps = false;

    public function scopeNumbered($query, $model = null)
    {
        return $query->oldest()
            ->when($model, function ($query, $model) {
                return $query->where('user_id', $model->user_id);
            });
    }
}