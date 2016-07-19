<?php
use App\Models\Statuslabel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class StatuslabelTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    use DatabaseMigrations;

    public function testRTDStatuslabelAdd()
    {
      $statuslabel = factory(Statuslabel::class, 'rtd')->make();
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
      $statuslabel = factory(Statuslabel::class, 'pending')->make();
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
      $statuslabel = factory(Statuslabel::class, 'archived')->make();
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
      $statuslabel = factory(Statuslabel::class, 'out_for_repair')->make();
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
      $statuslabel = factory(Statuslabel::class, 'out_for_diagnostics')->make();
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
      $statuslabel = factory(Statuslabel::class, 'broken')->make();
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
      $statuslabel = factory(Statuslabel::class, 'lost')->make();
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
