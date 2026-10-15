<?php

namespace App\Console\Commands;

use App\Events\CheckoutableCheckedIn;
use App\Models\Accessory;
use App\Models\AccessoryCheckout;
use App\Models\Asset;
use App\Models\CheckoutAcceptance;
use App\Models\Component;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class CheckinAndDeleteItems extends Command
{
    protected $signature = 'snipeit:checkin-delete-all
        {--company-id= : Only process items belonging to this company ID}
        {--admin-id= : ID of the user credited for the checkins (defaults to first superadmin)}
        {--no-notifications : Suppress email and webhook notifications}
        {--type=all : Comma-separated types to process: assets, licenses, accessories, components, or all}
        {--note= : Note recorded on each checkin action log entry}
        {--dry-run : Preview what would be processed without making any changes}
        {--force : Skip the confirmation prompt}';

    protected $description = 'Check in all assigned items and soft-delete them, optionally scoped to a company';

    public function handle(): int
    {
        $companyId = $this->option('company-id');
        $noNotifications = $this->option('no-notifications');
        $dryRun = $this->option('dry-run');
        $typeOption = $this->option('type') ?? 'all';
        $note = $this->option('note') ?: 'Checked in and deleted via CLI';

        $allTypes = ['assets', 'licenses', 'accessories', 'components'];
        $typesToProcess = $typeOption === 'all'
            ? $allTypes
            : array_intersect(array_map('trim', explode(',', $typeOption)), $allTypes);

        if (empty($typesToProcess)) {
            $this->error('Invalid --type value. Use: assets, licenses, accessories, components, or all.');

            return 1;
        }

        $admin = null;
        if (! $dryRun && ! $noNotifications) {
            if ($this->option('admin-id')) {
                $admin = User::find($this->option('admin-id'));
                if (! $admin) {
                    $this->error('No user found with admin-id '.$this->option('admin-id').'.');

                    return 1;
                }
            } else {
                $admin = User::onlySuperAdmins()->first();
            }

            if (! $admin) {
                $this->warn('No admin user found — notifications will be suppressed.');
                $noNotifications = true;
            }
        }

        $scopeMsg = $companyId ? "company ID {$companyId}" : 'all companies';
        $typesMsg = implode(', ', $typesToProcess);

        if ($dryRun) {
            $this->warn('DRY RUN — no changes will be made.');
        } elseif (! $this->option('force')) {
            if (! $this->confirm("This will check in and soft-delete all [{$typesMsg}] for [{$scopeMsg}]. Continue?")) {
                $this->info('Aborted.');

                return 0;
            }
        }

        if (in_array('assets', $typesToProcess)) {
            $this->processAssets($companyId, $noNotifications, $note, $admin, $dryRun);
        }

        if (in_array('licenses', $typesToProcess)) {
            $this->processLicenses($companyId, $noNotifications, $note, $admin, $dryRun);
        }

        if (in_array('accessories', $typesToProcess)) {
            $this->processAccessories($companyId, $noNotifications, $note, $admin, $dryRun);
        }

        if (in_array('components', $typesToProcess)) {
            $this->processComponents($companyId, $noNotifications, $note, $admin, $dryRun);
        }

        if ($dryRun) {
            $this->warn('Dry run complete — no changes were made.');
        }

        return 0;
    }

    private function processAssets(?string $companyId, bool $noNotifications, string $note, ?User $admin, bool $dryRun): void
    {
        $query = Asset::query();
        if ($companyId) {
            $query->where('company_id', $companyId);
        }

        $assets = $query->get();
        $checkedIn = 0;
        $deleted = 0;

        foreach ($assets as $asset) {
            if ($asset->assignedTo) {
                if ($dryRun) {
                    $this->line('  Would check in asset: '.$asset->asset_tag.' (assigned to '.$asset->assignedTo->name.')');
                } else {
                    $target = $asset->assignedTo;
                    $checkin_at = now()->format('Y-m-d H:i:s');
                    $originalValues = $asset->getRawOriginal();

                    if ($noNotifications) {
                        DB::table('assets')->where('id', $asset->id)
                            ->update(['assigned_to' => null, 'assigned_type' => null]);
                        $asset->logCheckin($target, $note, $checkin_at, $originalValues);
                    } else {
                        // Fire event before clearing so the log captures the original state
                        event(new CheckoutableCheckedIn($asset, $target, $admin, $note, $checkin_at, $originalValues));
                        DB::table('assets')->where('id', $asset->id)
                            ->update(['assigned_to' => null, 'assigned_type' => null]);
                    }

                    $asset->licenseseats()->update(['assigned_to' => null]);

                    CheckoutAcceptance::pending()
                        ->whereHasMorph('checkoutable', [Asset::class], fn (Builder $q) => $q->where('id', $asset->id))
                        ->delete();
                }

                $checkedIn++;
            }

            if ($dryRun) {
                $this->line('  Would delete asset: '.$asset->asset_tag);
            } else {
                $asset->delete();
            }

            $deleted++;
        }

        $action = $dryRun ? 'would be' : 'were';
        $this->info("Assets: {$checkedIn} {$action} checked in, {$deleted} {$action} deleted.");
    }

    private function processLicenses(?string $companyId, bool $noNotifications, string $note, ?User $admin, bool $dryRun): void
    {
        $query = License::query();
        if ($companyId) {
            $query->where('company_id', $companyId);
        }

        $licenses = $query->get();
        $seatsCheckedIn = 0;
        $deleted = 0;

        foreach ($licenses as $license) {
            $seats = LicenseSeat::where('license_id', $license->id)
                ->where(fn ($q) => $q->whereNotNull('assigned_to')->orWhereNotNull('asset_id'))
                ->get();

            foreach ($seats as $seat) {
                $target = $seat->assigned_to ? $seat->user : $seat->asset;

                if ($dryRun) {
                    $this->line('  Would check in license seat for: '.$license->name.' (assigned to '.($target?->name ?? $target?->asset_tag ?? 'unknown').')');
                } else {
                    $seat->assigned_to = null;
                    $seat->asset_id = null;
                    $seat->save();

                    if ($target) {
                        if ($noNotifications) {
                            $seat->logCheckin($target, $note);
                        } else {
                            event(new CheckoutableCheckedIn($seat, $target, $admin, $note));
                        }
                    }
                }

                $seatsCheckedIn++;
            }

            if ($dryRun) {
                $this->line('  Would delete license: '.$license->name);
            } else {
                $license->licenseseats()->delete();
                $license->delete();
            }

            $deleted++;
        }

        $action = $dryRun ? 'would be' : 'were';
        $this->info("Licenses: {$seatsCheckedIn} seats {$action} checked in, {$deleted} licenses {$action} deleted.");
    }

    private function processAccessories(?string $companyId, bool $noNotifications, string $note, ?User $admin, bool $dryRun): void
    {
        $query = Accessory::query();
        if ($companyId) {
            $query->where('company_id', $companyId);
        }

        $accessories = $query->get();
        $checkedIn = 0;
        $deleted = 0;

        foreach ($accessories as $accessory) {
            $checkouts = AccessoryCheckout::where('accessory_id', $accessory->id)->get();

            foreach ($checkouts as $checkout) {
                $target = $checkout->assignedTo;

                if ($dryRun) {
                    $this->line('  Would check in accessory: '.$accessory->name.' (assigned to '.($target?->name ?? $target?->asset_tag ?? 'unknown').')');
                } else {
                    $checkin_at = now()->format('Y-m-d H:i:s');
                    $checkout->delete();

                    if ($target) {
                        if ($noNotifications) {
                            $accessory->logCheckin($target, $note, $checkin_at);
                        } else {
                            event(new CheckoutableCheckedIn($accessory, $target, $admin, $note, $checkin_at));
                        }
                    }
                }

                $checkedIn++;
            }

            if ($dryRun) {
                $this->line('  Would delete accessory: '.$accessory->name);
            } else {
                $accessory->delete();
            }

            $deleted++;
        }

        $action = $dryRun ? 'would be' : 'were';
        $this->info("Accessories: {$checkedIn} {$action} checked in, {$deleted} {$action} deleted.");
    }

    private function processComponents(?string $companyId, bool $noNotifications, string $note, ?User $admin, bool $dryRun): void
    {
        $query = Component::query();
        if ($companyId) {
            $query->where('company_id', $companyId);
        }

        $components = $query->get();
        $checkedIn = 0;
        $deleted = 0;

        foreach ($components as $component) {
            $assignments = DB::table('components_assets')
                ->where('component_id', $component->id)
                ->get();

            foreach ($assignments as $assignment) {
                $asset = Asset::find($assignment->asset_id);

                if ($dryRun) {
                    $this->line('  Would check in component: '.$component->name.' (assigned to '.($asset?->asset_tag ?? 'unknown').')');
                } else {
                    $checkin_at = now()->format('Y-m-d H:i:s');
                    DB::table('components_assets')->where('id', $assignment->id)->delete();

                    if ($asset) {
                        if ($noNotifications) {
                            $component->logCheckin($asset, $note, $checkin_at);
                        } else {
                            event(new CheckoutableCheckedIn($component, $asset, $admin, $note, $checkin_at));
                        }
                    }
                }

                $checkedIn++;
            }

            if ($dryRun) {
                $this->line('  Would delete component: '.$component->name);
            } else {
                $component->delete();
            }

            $deleted++;
        }

        $action = $dryRun ? 'would be' : 'were';
        $this->info("Components: {$checkedIn} {$action} checked in, {$deleted} {$action} deleted.");
    }
}
