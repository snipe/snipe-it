<?php

namespace Database\Seeders;

use App\Models\Accessory;
use App\Models\AccessoryCheckout;
use App\Models\Actionlog;
use App\Models\Location;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AccessorySeeder extends Seeder
{
    public function run()
    {
        // See AssetModelSeeder for the stale-action_log rationale.
        Actionlog::where('item_type', Accessory::class)->delete();
        Accessory::truncate();
        DB::table('accessories_checkout')->truncate();

        if (! Location::count()) {
            $this->call(LocationSeeder::class);
        }

        $locationIds = Location::pluck('id');

        if (! Supplier::count()) {
            $this->call(SupplierSeeder::class);
        }

        $supplierIds = Supplier::pluck('id');

        $admin = User::where('permissions->superuser', '1')->first() ?? User::factory()->firstAdmin()->create();

        // Build a fresh acquisition payload per accessory so demo rows
        // don't all share the same supplier / cost / date. The seeded
        // supplier also seeds the parent's default_supplier_id template
        // so future adjust-quantity events pre-populate with it.
        //
        // withInitialAcquisition enriches the observer-written Order +
        // OrderItem with realistic acquisition metadata. The observer
        // alone leaves those fields null because form-driven creates
        // enrich them via enrichInitialOrderFromRequest, which a seeder
        // can't invoke.
        $randomAcquisition = function () use ($supplierIds) {
            $supplier = Supplier::find($supplierIds->random());
            $cost = fake()->randomFloat(2, 5, 250);
            $date = Carbon::instance(fake()->dateTimeBetween('-1 years', 'now'))->toDateString();

            return compact('supplier', 'cost', 'date');
        };

        foreach (['appleUsbKeyboard', 'appleBtKeyboard', 'appleMouse', 'microsoftMouse'] as $state) {
            $acq = $randomAcquisition();
            Accessory::factory()
                ->{$state}()
                ->withInitialAcquisition($acq['supplier'], $acq['cost'], $acq['date'])
                ->create([
                    'location_id' => $locationIds->random(),
                    'default_supplier_id' => $acq['supplier']->id,
                    'created_by' => $admin->id,
                ]);
        }

        // Extra low-stock accessories so the dashboard's low-stock
        // widget and the top-nav alert bell have realistic rows to
        // display in a fresh demo. Qty stays >= the max seeded
        // checkouts_count below (4) so the alert bell's `remaining =
        // qty - checkouts_count` calc doesn't go negative on any of
        // these rows. min_amt sits above qty so they still register
        // as low-stock (remaining < min_amt) even after checkouts.
        foreach ([
            ['name' => 'USB-C Hubs', 'qty' => 5, 'min_amt' => 10],
            ['name' => 'Wireless Headsets', 'qty' => 4, 'min_amt' => 12],
        ] as $lowStock) {
            $acq = $randomAcquisition();
            Accessory::factory()
                ->withInitialAcquisition($acq['supplier'], $acq['cost'], $acq['date'])
                ->create(array_merge($lowStock, [
                    'location_id' => $locationIds->random(),
                    'default_supplier_id' => $acq['supplier']->id,
                    'created_by' => $admin->id,
                ]));
        }

        // Check out a handful of each accessory to random users so the
        // view page doesn't render empty. Uses the AccessoryCheckout
        // model directly (which is what the checkout controller writes
        // to) rather than trying to run controller actions from a seeder.
        $checkoutTargets = User::where('activated', 1)
            ->where('show_in_list', '!=', '0')
            ->inRandomOrder()
            ->limit(6)
            ->get();
        foreach (Accessory::all() as $accessory) {
            foreach ($checkoutTargets->random(min(rand(2, 4), $checkoutTargets->count())) as $user) {
                AccessoryCheckout::create([
                    'accessory_id' => $accessory->id,
                    'assigned_to' => $user->id,
                    'assigned_type' => User::class,
                    'created_by' => $admin->id,
                    'note' => 'Seeded demo checkout',
                ]);
            }
        }

        $src = public_path('/img/demo/accessories/');
        $dst = 'accessories/';

        // Wipe every item file in the public uploads dir.
        $disk = Storage::disk('public');
        foreach ($disk->files(rtrim($dst, '/')) as $del_file) {
            Log::debug('Deleting: ' . $del_file);
            try {
                $disk->delete($del_file);
            } catch (\Exception $e) {
                Log::debug($e);
            }
        }

        // Attached files on the private (default) disk.
        foreach (Storage::files('private_uploads/accessories') as $del_file) {
            Log::debug('Deleting: ' . $del_file);
            try {
                Storage::delete($del_file);
            } catch (\Exception $e) {
                Log::debug($e);
            }
        }

        $add_files = glob($src.'/*.*');
        foreach ($add_files as $add_file) {
            $file_to_copy = str_replace($src, '', $add_file);
            Log::debug('Copying: '.$file_to_copy);
            try {
                Storage::disk('public')->put($dst.$file_to_copy, file_get_contents($src.$file_to_copy));
            } catch (\Exception $e) {
                Log::debug($e);
            }
        }
    }
}
