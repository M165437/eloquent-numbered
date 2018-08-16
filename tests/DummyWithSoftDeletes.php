<?php

namespace M165437\EloquentNumbered\Test;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use M165437\EloquentNumbered\Numbered;

class DummyWithSoftDeletes extends Model
{
    use SoftDeletes, Numbered;

    protected $table = 'dummies';
    protected $guarded = [];
    public $timestamps = false;
}