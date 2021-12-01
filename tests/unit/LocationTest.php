<?php
namespace Tests\Unit;

use App\Models\Location;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\Unit\BaseTest;

class LocationTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testPassesIfNotSelfParent()
    {
        $this->createValidLocation(['id' => 10]);

        $a = Location::factory()->make([
            'name' => 'Test Location',
            'id' => 1,
            'parent_id' => 10,
        ]);

        $this->assertTrue($a->isValid());
    }

    public function testFailsIfSelfParent()
    {
        $a = Location::factory()->make([
            'name' => 'Test Location',
            'id' => 1,
            'parent_id' => 1,
        ]);

        $this->assertFalse($a->isValid());
        $this->assertStringContainsString('The parent id and id must be different', $a->getErrors());
    }
}
