<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Component;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ComponentSeeder extends Seeder
{
    public function run()
    {
        Component::truncate();
        DB::table('components_assets')->truncate();

        if (! Company::count()) {
            $this->call(CompanySeeder::class);
        }

        $companyIds = Company::all()->pluck('id');

        Component::factory()->ramCrucial4()->create(['company_id' => $companyIds->random()]);
        Component::factory()->ramCrucial8()->create(['company_id' => $companyIds->random()]);
        Component::factory()->ssdCrucial120()->create(['company_id' => $companyIds->random()]);
        Component::factory()->ssdCrucial240()->create(['company_id' => $companyIds->random()]);
    }
}
