<?php
use App\Models\Location;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LocationTest extends BaseTest
{
    /**
    * @var \UnitTester
    */
    protected $tester;

    public function testPassesIfNotSelfParent() {
        $this->createValidLocation(['id' => 10]);

        $a = factory(Location::class)->make([
            'name' => 'Test Location',
            'id' => 1,
            'parent_id' => 10,
        ]);

        $this->assertTrue($a->isValid());

    }

    public function testFailsIfSelfParent() {

        $a = factory(Location::class)->make([
            'name' => 'Test Location',
            'id' => 1,
            'parent_id' => 1,
        ]);

        $this->assertFalse($a->isValid());
        $this->assertStringContainsString("The parent id and id must be different", $a->getErrors());


    }

}
