<?php

namespace Database\Seeders;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\CheckoutRequest;
use App\Models\Location;
use App\Models\Supplier;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\Concerns\ReportsMemory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AssetSeeder extends Seeder
{
    use ReportsMemory;

    private $admin;

    private $locationIds;

    private $supplierIds;

    public function run()
    {
        // See AssetModelSeeder for the stale-action_log rationale.
        Actionlog::where('item_type', Asset::class)->delete();
        Asset::truncate();

        $this->ensureLocationsSeeded();
        $this->ensureSuppliersSeeded();

        $this->adminuser = User::where('permissions->superuser', '1')->first() ?? User::factory()->firstAdmin()->create();
        $this->locationIds = Location::pluck('id');
        $this->supplierIds = Supplier::pluck('id');

        $this->reportMemory('AssetSeeder start');

        // Chunk the big laptopMbp batch so we don't hold 2000 Asset models
        // (plus 2000 Actionlog observer side-effects) in memory at once, which
        // was pushing the demo servers into swap during full re-seeds.
        memory_reset_peak_usage();
        for ($i = 0; $i < 10; $i++) {
            Asset::factory()->count(200)->laptopMbp()->state(new Sequence($this->getState()))->create();
            gc_collect_cycles();
        }
        $this->reportMemory('AssetSeeder after laptopMbp chunked batch (2000 total)');

        memory_reset_peak_usage();
        Asset::factory()->count(50)->laptopMbpPending()->state(new Sequence($this->getState()))->create();
        Asset::factory()->count(50)->laptopMbpArchived()->state(new Sequence($this->getState()))->create();
        Asset::factory()->count(50)->laptopAir()->state(new Sequence($this->getState()))->create();
        Asset::factory()->count(50)->laptopSurface()->state(new Sequence($this->getState()))->create();
        Asset::factory()->count(5)->laptopXps()->state(new Sequence($this->getState()))->create();
        Asset::factory()->count(5)->laptopSpectre()->state(new Sequence($this->getState()))->create();
        Asset::factory()->count(50)->laptopZenbook()->state(new Sequence($this->getState()))->create();
        Asset::factory()->count(30)->laptopYoga()->state(new Sequence($this->getState()))->create();
        Asset::factory()->count(30)->desktopMacpro()->state(new Sequence($this->getState()))->create();
        Asset::factory()->count(30)->desktopLenovoI5()->state(new Sequence($this->getState()))->create();
        Asset::factory()->count(30)->desktopOptiplex()->state(new Sequence($this->getState()))->create();
        Asset::factory()->count(50)->confPolycom()->state(new Sequence($this->getState()))->create();
        Asset::factory()->count(20)->confPolycomcx()->state(new Sequence($this->getState()))->create();
        Asset::factory()->count(30)->tabletIpad()->state(new Sequence($this->getState()))->create();
        Asset::factory()->count(10)->tabletTab3()->state(new Sequence($this->getState()))->create();
        Asset::factory()->count(27)->phoneIphone11()->state(new Sequence($this->getState()))->create();
        Asset::factory()->count(40)->phoneIphone12()->state(new Sequence($this->getState()))->create();
        Asset::factory()->count(20)->ultrafine()->state(new Sequence($this->getState()))->create();
        Asset::factory()->count(20)->ultrasharp()->state(new Sequence($this->getState()))->create();

        // Wipe every item file in the public uploads dir.
        $disk = Storage::disk('public');
        foreach ($disk->files('assets') as $del_file) {
            Log::debug('Deleting: ' . $del_file);
            try {
                $disk->delete($del_file);
            } catch (\Exception $e) {
                Log::debug($e);
            }
        }

        // Attached files on the private (default) disk.
        foreach (Storage::files('private_uploads/assets') as $del_file) {
            Log::debug('Deleting: ' . $del_file);
            try {
                Storage::delete($del_file);
            } catch (\Exception $e) {
                Log::debug($e);
            }
        }

        DB::table('checkout_requests')->truncate();

        // Seed a handful of demo-friendly "needs attention" rows so the
        // dashboard widget has realistic content on a fresh install:
        //
        //   - Overdue checkins: pick a few assigned assets and backdate
        //     their expected_checkin so overdueCheckins is populated on
        //     the dashboard.
        //   - Pending checkout requests: seed against requestable
        //     assets so pendingRequestsCount is populated too.
        //
        // Kept small (5 of each) so the widget looks lived-in but not
        // overwhelming on the demo.
        $assignedAssetIds = Asset::whereNotNull('assigned_to')
            ->inRandomOrder()
            ->limit(5)
            ->pluck('id');
        foreach ($assignedAssetIds as $id) {
            Asset::whereKey($id)->update([
                'expected_checkin' => Carbon::now()->subDays(rand(3, 30)),
            ]);
        }

        $requestableAssets = Asset::where('requestable', 1)
            ->inRandomOrder()
            ->limit(5)
            ->get();
        $requesterIds = User::where('activated', 1)
            ->where('show_in_list', '!=', '0')
            ->inRandomOrder()
            ->limit(5)
            ->pluck('id');
        if ($requesterIds->isNotEmpty()) {
            foreach ($requestableAssets as $asset) {
                CheckoutRequest::create([
                    'requestable_id' => $asset->id,
                    'requestable_type' => Asset::class,
                    'user_id' => $requesterIds->random(),
                    'quantity' => 1,
                ]);
            }
        }

        $this->reportMemory('AssetSeeder end (all factory batches complete)');
    }

    private function ensureLocationsSeeded()
    {
        if (! Location::count()) {
            $this->call(LocationSeeder::class);
        }
    }

    private function ensureSuppliersSeeded()
    {
        if (! Supplier::count()) {
            $this->call(SupplierSeeder::class);
        }
    }

    private function getState()
    {
        return function () {
            // Seeded assets are unassigned at creation, so location_id matches
            // rtd_location_id. Setting both here removes the need to run
            // snipeit:sync-asset-locations after seeding (that command exists
            // as a manual maintenance tool for production drift, not as a seed
            // dependency).
            $locationId = $this->locationIds->random();

            return [
                'rtd_location_id' => $locationId,
                'location_id' => $locationId,
                'supplier_id' => $this->supplierIds->random(),
                'created_by' => $this->adminuser->id,
            ];
        };
    }
}
