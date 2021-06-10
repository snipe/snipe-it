<?php

use App\Models\Statuslabel;
use Illuminate\Database\Seeder;

class StatuslabelSeeder extends Seeder
{
    public function run()
    {
        Statuslabel::truncate();
        factory(Statuslabel::class)->states('rtd')->create(['name' => 'Ready to Deploy']);
        factory(Statuslabel::class)->states('pending')->create(['name' => 'Pending']);
        factory(Statuslabel::class)->states('archived')->create(['name' => 'Archived']);
        factory(Statuslabel::class)->states('out_for_diagnostics')->create();
        factory(Statuslabel::class)->states('out_for_repair')->create();
        factory(Statuslabel::class)->states('broken')->create();
        factory(Statuslabel::class)->states('lost')->create();
    }
}
