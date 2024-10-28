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
            'status_type' => 'deployable',
        ]);

        Statuslabel::factory()->pending()->create([
            'name' => 'Pending',
            'created_by' => $admin->id,
            'status_type' => 'pending',
        ]);

        Statuslabel::factory()->archived()->create([
            'name' => 'Archived',
            'created_by' => $admin->id,
            'status_type' => 'archived',
        ]);

        Statuslabel::factory()->outForDiagnostics()->pending()->create(['created_by' => $admin->id]);
        Statuslabel::factory()->outForRepair()->pending()->create(['created_by' => $admin->id]);
        Statuslabel::factory()->broken()->archived()->create(['created_by' => $admin->id]);
        Statuslabel::factory()->lost()->archived()->create(['created_by' => $admin->id]);
    }
}
