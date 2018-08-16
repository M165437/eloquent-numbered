<?php

namespace M165437\EloquentNumbered\Test;

use Illuminate\Support\Facades\DB;

class NumberedTest extends TestCase
{

    /** @test */
    function it_sets_number_per_user_on_creation()
    {
        $dummy1 = DummyWithCustomScope::create(['user_id' => 1]);
        $dummy2 = DummyWithCustomScope::create(['user_id' => 2]);
        $dummy3 = DummyWithCustomScope::create(['user_id' => 1]);

        $this->assertEquals(1, $dummy1->fresh()->number);
        $this->assertEquals(1, $dummy2->fresh()->number);
        $this->assertEquals(2, $dummy3->fresh()->number);
    }

    /** @test */
    function it_renumbers_per_user_on_update()
    {
        $dummy1 = DummyWithCustomScope::create(['user_id' => 1]);
        $dummy2 = DummyWithCustomScope::create(['user_id' => 2]);
        $dummy3 = DummyWithCustomScope::create(['user_id' => 1]);

        $dummy2->user_id = 1;
        $dummy2->save();

        $this->assertEquals(1, $dummy1->fresh()->number);
        $this->assertEquals(2, $dummy2->fresh()->number);
        $this->assertEquals(3, $dummy3->fresh()->number);
    }

    /** @test */
    public function it_renumbers_per_user_on_deletion()
    {
        $dummy1 = DummyWithCustomScope::create(['user_id' => 1]);
        $dummy2 = DummyWithCustomScope::create(['user_id' => 2]);
        $dummy3 = DummyWithCustomScope::create(['user_id' => 1]);
        $dummy4 = DummyWithCustomScope::create(['user_id' => 1]);

        $dummy3->delete();

        $this->assertEquals(1, $dummy1->fresh()->number);
        $this->assertEquals(1, $dummy2->fresh()->number);
        $this->assertEquals(2, $dummy4->fresh()->number);
    }

    /** @test */
    function it_removes_number_on_soft_deletion()
    {
        $this->setUpSoftDeletes();

        $dummy = DummyWithSoftDeletes::create();

        $dummy->delete();

        $this->assertNull($dummy->fresh()->number);
    }

    /** @test */
    function it_renumbers_on_restoration()
    {
        $this->setUpSoftDeletes();

        $dummy = DummyWithSoftDeletes::create();

        $dummy->delete();
        $dummy->restore();

        $this->assertEquals(1, $dummy->fresh()->number);
    }
}