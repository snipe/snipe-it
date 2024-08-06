<?php
namespace Tests\Unit;

use App\Models\AssetMaintenance;
use Tests\TestCase;

class AssetMaintenanceTest extends TestCase
{
    public function testZerosOutWarrantyIfBlank()
    {
        $c = new AssetMaintenance;
        $c->is_warranty = '';
        $this->assertTrue($c->is_warranty === 0);
        $c->is_warranty = '4';
        $this->assertTrue($c->is_warranty == 4);
    }

    public function testSetsCostsAppropriately()
    {
        $c = new AssetMaintenance();
        $c->cost = '0.00';
        $this->assertTrue($c->cost === null);
        $c->cost = '9.54';
        $this->assertTrue($c->cost === 9.54);
        $c->cost = '9.50';
        $this->assertTrue($c->cost === 9.5);
    }

    public function testNullsOutNotesIfBlank()
    {
        $c = new AssetMaintenance;
        $c->notes = '';
        $this->assertTrue($c->notes === null);
        $c->notes = 'This is a long note';
        $this->assertTrue($c->notes === 'This is a long note');
    }

    public function testNullsOutCompletionDateIfBlankOrInvalid()
    {
        $c = new AssetMaintenance;
        $c->completion_date = '';
        $this->assertTrue($c->completion_date === null);
        $c->completion_date = '0000-00-00';
        $this->assertTrue($c->completion_date === null);
    }
}
