<?php
namespace Tests\Unit;

use App\Models\Statuslabel;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\Unit\BaseTest;

class StatuslabelTest extends BaseTest
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testRTDStatuslabelAdd()
    {
        $statuslabel = Statuslabel::factory()->rtd()->make();
        $values = [
         'name'        => $statuslabel->name,
         'deployable'  => $statuslabel->deployable,
         'pending'     => $statuslabel->pending,
         'archived'    => $statuslabel->archived,

         ];

        Statuslabel::create($values);
        $this->tester->seeRecord('status_labels', $values);
    }

    public function testPendingStatuslabelAdd()
    {
        $statuslabel = Statuslabel::factory()->pending()->make();
        $values = [
         'name'        => $statuslabel->name,
         'deployable'  => $statuslabel->deployable,
         'pending'     => $statuslabel->pending,
         'archived'    => $statuslabel->archived,
         ];

        Statuslabel::create($values);
        $this->tester->seeRecord('status_labels', $values);
    }

    public function testArchivedStatuslabelAdd()
    {
        $statuslabel = Statuslabel::factory()->archived()->make();
        $values = [
         'name'        => $statuslabel->name,
         'deployable'  => $statuslabel->deployable,
         'pending'     => $statuslabel->pending,
         'archived'    => $statuslabel->archived,
         ];

        Statuslabel::create($values);
        $this->tester->seeRecord('status_labels', $values);
    }

    public function testOutForRepairStatuslabelAdd()
    {
        $statuslabel = Statuslabel::factory()->outForRepair()->make();
        $values = [
         'name'        => $statuslabel->name,
         'deployable'  => $statuslabel->deployable,
         'pending'     => $statuslabel->pending,
         'archived'    => $statuslabel->archived,
         ];

        Statuslabel::create($values);
        $this->tester->seeRecord('status_labels', $values);
    }

    public function testOutForDiagnosticsStatuslabelAdd()
    {
        $statuslabel = Statuslabel::factory()->outForDiagnostics()->make();
        $values = [
         'name'        => $statuslabel->name,
         'deployable'  => $statuslabel->deployable,
         'pending'     => $statuslabel->pending,
         'archived'    => $statuslabel->archived,
         ];

        Statuslabel::create($values);
        $this->tester->seeRecord('status_labels', $values);
    }

    public function testBrokenStatuslabelAdd()
    {
        $statuslabel = Statuslabel::factory()->broken()->make();
        $values = [
         'name'        => $statuslabel->name,
         'deployable'  => $statuslabel->deployable,
         'pending'     => $statuslabel->pending,
         'archived'    => $statuslabel->archived,
         ];

        Statuslabel::create($values);
        $this->tester->seeRecord('status_labels', $values);
    }

    public function testLostStatuslabelAdd()
    {
        $statuslabel = Statuslabel::factory()->lost()->make();
        $values = [
         'name'        => $statuslabel->name,
         'deployable'  => $statuslabel->deployable,
         'pending'     => $statuslabel->pending,
         'archived'    => $statuslabel->archived,
         ];

        Statuslabel::create($values);
        $this->tester->seeRecord('status_labels', $values);
    }
}
