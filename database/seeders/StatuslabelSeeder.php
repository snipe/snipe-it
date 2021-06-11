<?php

namespace Database\Seeders;

use App\Models\Statuslabel;
use Illuminate\Database\Seeder;

class StatuslabelSeeder extends Seeder
{
    public function run()
    {
        Statuslabel::truncate();
        Statuslabel::factory()->count(1)->statuslabelRtd()->create();
        Statuslabel::factory()->count(1)->statuslabelPending()->create();
        Statuslabel::factory()->count(1)->statuslabelArchived()->create();
        Statuslabel::factory()->count(1)->statuslabelDiagnostics()->create();
        Statuslabel::factory()->count(1)->statuslabelRepair()->create();
        Statuslabel::factory()->count(1)->statuslabelBroken()->create();
        Statuslabel::factory()->count(1)->statuslabelLost()->create();
    }
}
