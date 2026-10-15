<?php

namespace Database\Seeders;

use App\Models\Actionlog;
use App\Models\Consumable;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ConsumableSeeder extends Seeder
{
    public function run()
    {
        // See AssetModelSeeder for the stale-action_log rationale.
        Actionlog::where('item_type', Consumable::class)->delete();
        Consumable::truncate();
        DB::table('consumables_users')->truncate();

        // Wipe every item file in the public uploads dir.
        $disk = Storage::disk('public');
        foreach ($disk->files('consumables') as $del_file) {
            Log::debug('Deleting: ' . $del_file);
            try {
                $disk->delete($del_file);
            } catch (\Exception $e) {
                Log::debug($e);
            }
        }

        // Attached files on the private (default) disk.
        foreach (Storage::files('private_uploads/consumables') as $del_file) {
            Log::debug('Deleting: ' . $del_file);
            try {
                Storage::delete($del_file);
            } catch (\Exception $e) {
                Log::debug($e);
            }
        }

        if (! Supplier::count()) {
            $this->call(SupplierSeeder::class);
        }
        $supplierIds = Supplier::pluck('id');

        $admin = User::where('permissions->superuser', '1')->first() ?? User::factory()->firstAdmin()->create();

        // See AccessorySeeder for the withInitialAcquisition rationale —
        // fills demo Order + OrderItem rows with realistic supplier /
        // cost / date so the index page and info-panel don't render
        // empty "Last Unit Cost" / "Last Purchase Date" columns.
        $randomAcquisition = function () use ($supplierIds) {
            $supplier = Supplier::find($supplierIds->random());
            $cost = fake()->randomFloat(2, 1, 50);
            $date = Carbon::instance(fake()->dateTimeBetween('-1 years', 'now'))->toDateString();

            return compact('supplier', 'cost', 'date');
        };

        foreach (['cardstock', 'paper', 'ink'] as $state) {
            $acq = $randomAcquisition();
            Consumable::factory()
                ->{$state}()
                ->withInitialAcquisition($acq['supplier'], $acq['cost'], $acq['date'])
                ->create([
                    'default_supplier_id' => $acq['supplier']->id,
                    'created_by' => $admin->id,
                ]);
        }

        // Extra low-stock consumables so the dashboard's low-stock
        // widget and the top-nav alert bell have realistic rows to
        // display in a fresh demo. Qty stays >= the max seeded
        // checkouts_count below (4) so the alert bell's `remaining =
        // qty - checkouts_count` calc doesn't go negative on any of
        // these rows. min_amt sits above qty so they still register
        // as low-stock (remaining < min_amt) even after checkouts.
        foreach ([
            ['name' => 'Envelopes (#10)', 'qty' => 5, 'min_amt' => 10],
            ['name' => 'AA Batteries', 'qty' => 4, 'min_amt' => 15],
            ['name' => 'Ethernet Patch Cables (Cat 6, 3ft)', 'qty' => 5, 'min_amt' => 12],
        ] as $lowStock) {
            $acq = $randomAcquisition();
            Consumable::factory()
                ->withInitialAcquisition($acq['supplier'], $acq['cost'], $acq['date'])
                ->create(array_merge($lowStock, [
                    'default_supplier_id' => $acq['supplier']->id,
                    'created_by' => $admin->id,
                ]));
        }

        // Check out a couple of each consumable to random users so the
        // view page doesn't render as an empty checkout list.
        $checkoutTargets = User::where('activated', 1)
            ->where('show_in_list', '!=', '0')
            ->inRandomOrder()
            ->limit(6)
            ->get();
        foreach (Consumable::all() as $consumable) {
            foreach ($checkoutTargets->random(min(rand(2, 4), $checkoutTargets->count())) as $user) {
                $consumable->users()->attach($user->id, [
                    'created_by' => $admin->id,
                ]);
            }
        }
    }
}
