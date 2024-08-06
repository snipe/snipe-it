<?php
namespace Tests\Unit;

use App\Models\Statuslabel;
use Tests\TestCase;

final class StatuslabelTest extends TestCase
{
    public function testRTDStatuslabelAdd(): void
    {
        $statuslabel = Statuslabel::factory()->rtd()->create();
        $this->assertModelExists($statuslabel);
    }

    public function testPendingStatuslabelAdd(): void
    {
        $statuslabel = Statuslabel::factory()->pending()->create();
        $this->assertModelExists($statuslabel);
    }

    public function testArchivedStatuslabelAdd(): void
    {
        $statuslabel = Statuslabel::factory()->archived()->create();
        $this->assertModelExists($statuslabel);
    }

    public function testOutForRepairStatuslabelAdd(): void
    {
        $statuslabel = Statuslabel::factory()->outForRepair()->create();
        $this->assertModelExists($statuslabel);
    }

    public function testBrokenStatuslabelAdd(): void
    {
        $statuslabel = Statuslabel::factory()->broken()->create();
        $this->assertModelExists($statuslabel);
    }

    public function testLostStatuslabelAdd(): void
    {
        $statuslabel = Statuslabel::factory()->lost()->create();
        $this->assertModelExists($statuslabel);
    }
}
