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
            'user_id' => $admin->id,
        ]);

        Statuslabel::factory()->pending()->create([
            'name' => 'Pending',
            'user_id' => $admin->id,
        ]);

        Statuslabel::factory()->archived()->create([
            'name' => 'Archived',
            'user_id' => $admin->id,
        ]);

        Statuslabel::factory()->outForDiagnostics()->create(['user_id' => $admin->id]);
        Statuslabel::factory()->outForRepair()->create(['user_id' => $admin->id]);
        Statuslabel::factory()->broken()->create(['user_id' => $admin->id]);
        Statuslabel::factory()->lost()->create(['user_id' => $admin->id]);
    }
}
