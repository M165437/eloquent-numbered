<?php

namespace M165437\EloquentNumbered\Test;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    public function setUp()
    {
        parent::setUp();

        $this->setUpDatabase();
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'port' => '3306',
            'database' => 'numbered_testing',
            'username' => 'root',
            'password' => ''
        ]);
    }

    protected function setUpDatabase()
    {
        DB::enableQueryLog();

        Schema::dropIfExists('dummies');

        Schema::create('dummies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->default(1);
            $table->integer('number')->nullable();
            $table->timestamps();
        });
    }

    protected function setUpSoftDeletes()
    {
        Schema::table('dummies', function (Blueprint $table) {
            $table->softDeletes();
        });
    }
}
