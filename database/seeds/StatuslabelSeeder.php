<?php
use Illuminate\Database\Seeder;
use App\Models\Statuslabel;


class StatuslabelSeeder extends Seeder
{
    public function run()
    {
      Statuslabel::truncate();
      factory(Statuslabel::class, 'rtd')->create();
      factory(Statuslabel::class, 'pending')->create();
      factory(Statuslabel::class, 'archived')->create();
      factory(Statuslabel::class, 'out_for_diagnostics')->create();
      factory(Statuslabel::class, 'out_for_repair')->create();
      factory(Statuslabel::class, 'broken')->create();
      factory(Statuslabel::class, 'lost')->create();
    }

}
