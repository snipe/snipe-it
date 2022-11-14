<?php
namespace Tests\Unit;

use App\Models\AssetMaintenance;
use Tests\Unit\BaseTest;
use Carbon\Carbon;

class AssetMaintenanceTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @test
     */
    public function it_zeros_out_warranty_if_blank()
    {
        $c = new AssetMaintenance;
        $c->is_warranty = '';
        $this->assertTrue($c->is_warranty === 0);
        $c->is_warranty = '4';
        $this->assertTrue($c->is_warranty == 4);
    }

    /**
     * @test
     */
    public function it_sets_costs_appropriately()
    {
        $c = new AssetMaintenance();
        $c->cost = '0.00';
        $this->assertTrue($c->cost === null);
        $c->cost = '9.54';
        $this->assertTrue($c->cost === 9.54);
        $c->cost = '9.50';
        $this->assertTrue($c->cost === 9.5);
    }

    /**
     * @test
     */
    public function it_nulls_out_notes_if_blank()
    {
        $c = new AssetMaintenance;
        $c->notes = '';
        $this->assertTrue($c->notes === null);
        $c->notes = 'This is a long note';
        $this->assertTrue($c->notes === 'This is a long note');
    }

    /**
     * @test
     */
    public function it_nulls_out_completion_date_if_blank_or_invalid()
    {
        $c = new AssetMaintenance;
        $c->completion_date = '';
        $this->assertTrue($c->completion_date === null);
        $c->completion_date = '0000-00-00';
        $this->assertTrue($c->completion_date === null);
        $c->completion_date = '2017-05-12';
        $this->assertTrue($c->completion_date == Carbon::parse('2017-05-12'));
    }
}
