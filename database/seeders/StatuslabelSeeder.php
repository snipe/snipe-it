<?php

namespace Database\Seeders;

use App\Models\Statuslabel;
use Illuminate\Database\Seeder;

class StatuslabelSeeder extends Seeder
{
    public function run()
    {
        Statuslabel::truncate();
        Statuslabel::factory()->rtd()->create(['name' => 'Ready to Deploy']);
        Statuslabel::factory()->pending()->create(['name' => 'Pending']);
        Statuslabel::factory()->archived()->create(['name' => 'Archived']);
        Statuslabel::factory()->outForDiagnostics()->create();
        Statuslabel::factory()->outForRepair()->create();
        Statuslabel::factory()->broken()->create();
        Statuslabel::factory()->lost()->create();
    }
}
