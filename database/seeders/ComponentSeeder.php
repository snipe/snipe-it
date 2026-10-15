<?php

namespace Database\Seeders;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\Company;
use App\Models\Component;
use App\Models\Location;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ComponentSeeder extends Seeder
{
    public function run()
    {
        // See AssetModelSeeder for the stale-action_log rationale.
        Actionlog::where('item_type', Component::class)->delete();
        Component::truncate();
        DB::table('components_assets')->truncate();

        // Wipe every item file in the public uploads dir.
        $disk = Storage::disk('public');
        foreach ($disk->files('components') as $del_file) {
            Log::debug('Deleting: ' . $del_file);
            try {
                $disk->delete($del_file);
            } catch (\Exception $e) {
                Log::debug($e);
            }
        }

        // Attached files on the private (default) disk.
        foreach (Storage::files('private_uploads/components') as $del_file) {
            Log::debug('Deleting: ' . $del_file);
            try {
                Storage::delete($del_file);
            } catch (\Exception $e) {
                Log::debug($e);
            }
        }

        if (! Company::count()) {
            $this->call(CompanySeeder::class);
        }

        $companyIds = Company::pluck('id');

        if (! Location::count()) {
            $this->call(LocationSeeder::class);
        }

        $locationIds = Location::pluck('id');

        if (! Supplier::count()) {
            $this->call(SupplierSeeder::class);
        }
        $supplierIds = Supplier::pluck('id');

        // See AccessorySeeder for the withInitialAcquisition rationale.
        $randomAcquisition = function () use ($supplierIds) {
            $supplier = Supplier::find($supplierIds->random());
            $cost = fake()->randomFloat(2, 10, 500);
            $date = Carbon::instance(fake()->dateTimeBetween('-1 years', 'now'))->toDateString();

            return compact('supplier', 'cost', 'date');
        };

        foreach (['ramCrucial4', 'ramCrucial8', 'ssdCrucial120', 'ssdCrucial240'] as $state) {
            $acq = $randomAcquisition();
            Component::factory()
                ->{$state}()
                ->withInitialAcquisition($acq['supplier'], $acq['cost'], $acq['date'])
                ->create([
                    'company_id' => $companyIds->random(),
                    'location_id' => $locationIds->random(),
                    'default_supplier_id' => $acq['supplier']->id,
                ]);
        }

        // Check out a couple of each component to random assets so the
        // view page doesn't render an empty checkout list. Components
        // check out to assets (not users). Skipped gracefully if
        // AssetSeeder hasn't run yet.
        $admin = User::where('permissions->superuser', '1')->first();
        $checkoutTargets = Asset::inRandomOrder()->limit(6)->get();
        if ($admin && $checkoutTargets->isNotEmpty()) {
            foreach (Component::all() as $component) {
                foreach ($checkoutTargets->random(min(rand(2, 3), $checkoutTargets->count())) as $asset) {
                    $component->assets()->attach($asset->id, [
                        'created_by' => $admin->id,
                        'assigned_qty' => rand(1, 2),
                    ]);
                }
            }
        }
    }
}
