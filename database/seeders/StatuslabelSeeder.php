<?php

namespace Database\Seeders;

use App\Models\Statuslabel;
use App\Models\User;
use Illuminate\Database\Seeder;

class StatuslabelSeeder extends Seeder
{
    public function run()
    {
        Statuslabel::truncate();

        $admin = User::where('permissions->superuser', '1')->first() ?? User::factory()->firstAdmin()->create();

        Statuslabel::factory()->rtd()->create([
            'name' => 'Ready to Deploy',
            'created_by' => $admin->id,
        ]);

        Statuslabel::factory()->pending()->create([
            'name' => 'Pending',
            'created_by' => $admin->id,
        ]);

        Statuslabel::factory()->archived()->create([
            'name' => 'Archived',
            'created_by' => $admin->id,
        ]);

        Statuslabel::factory()->outForDiagnostics()->create(['created_by' => $admin->id]);
        Statuslabel::factory()->outForRepair()->create(['created_by' => $admin->id]);
        Statuslabel::factory()->broken()->create(['created_by' => $admin->id]);
        Statuslabel::factory()->lost()->create(['created_by' => $admin->id]);
    }
}
