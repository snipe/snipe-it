<?php

namespace App\Livewire;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\CheckoutAcceptance;
use App\Models\CheckoutRequest;
// Aliased as SnipeComponent to sidestep the Livewire\Component
// collision below. Project convention: reach for SnipeComponent when
// a Livewire class needs the Snipe-IT Component model, never plain
// `Component` in that context.
use App\Models\Component as SnipeComponent;
use App\Models\Consumable;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\Maintenance;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Component;

/**
 * Dashboard "Needs Attention" widget - eight action-required counts
 * (audits overdue, checkins overdue, overdue maintenances, pending
 * acceptances, open checkout requests, licenses expiring, assets
 * past EOL, employees offboarding).
 *
 * Extracted from an inline block in DashboardController::index() +
 * dashboard.blade.php so the eight count queries no longer sit on the
 * critical render path. `#[Lazy]` makes the component render a
 * placeholder on initial dashboard paint; Livewire fires a follow-up
 * XHR to hydrate the real counts, matching the same pattern the
 * top-nav AlertMenu already uses to keep its five subqueries off the
 * first paint.
 *
 * boot() authorization: matches the DashboardController::index gate
 * (hasAccess('admin')). Without this, a non-admin user with a
 * captured snapshot could POST /livewire/update to hydrate the widget
 * and read the counts even though the parent view would 302 them
 * away - route-level middleware doesn't guard snapshot replays
 */
#[Lazy]
class NeedsAttention extends Component
{
    // Public properties so tests can `assertSet('overdueAudits', N)`
    // instead of parsing rendered HTML. Populated by mount() and read
    // by render() through the view. Also lets Livewire's dehydrate /
    // hydrate cycle re-use the computed counts across a component
    // refresh rather than re-running the eight queries on every
    // Livewire XHR (e.g. if the widget ever grows an action, which it likely will).
    public int $overdueAudits = 0;

    public int $overdueCheckins = 0;

    public int $overdueMaintenances = 0;

    public int $pendingAcceptancesCount = 0;

    public int $pendingRequestsCount = 0;

    public int $licensesExpiringSoon = 0;

    public int $assetsPastEol = 0;

    public int $usersOffboardingSoon = 0;

    public function boot(): void
    {
        // Matches the DashboardController::index gate. Without this a
        // non-viewer could POST /livewire/update against a captured
        // snapshot and hydrate the widget even though the parent view
        // would 302 them away, since route-level middleware doesn't
        // guard snapshot replays. See feedback_livewire_component_authorization.
        abort_unless(auth()->check() && Gate::allows('canViewUsersAndCheckoutables'), 403);
    }

    public function mount(): void
    {
        $todayStart = now()->startOfDay();
        $inThirtyDays = now()->addDays(30)->endOfDay();

        // Every count is gated by the caller's per-type view
        // permission. A non-admin who reaches this widget through the
        // widened dashboard gate but only holds `accessories.view`
        // sees zero for the Asset / License / User counts rather than
        // a leaked global count. Range comparisons (not whereDate) so
        // the indexes on these date columns can actually be used, see
        // the 2026_08_14_170000 migration that adds them for every
        // column referenced below.
        if (Gate::allows('view', Asset::class)) {
            $this->overdueAudits = Asset::where('next_audit_date', '<', $todayStart)->count();
            $this->overdueCheckins = Asset::where('expected_checkin', '<', $todayStart)
                ->whereNotNull('assigned_to')
                ->count();
            $this->assetsPastEol = Asset::where('asset_eol_date', '<', $todayStart)->count();
        }

        if (Gate::allows('view', Maintenance::class)) {
            $this->overdueMaintenances = Maintenance::where('expected_completion_date', '<', $todayStart)
                ->whereNull('completed_at')
                ->count();
        }

        if (Gate::allows('view', License::class)) {
            $this->licensesExpiringSoon = License::whereBetween('expiration_date', [$todayStart, $inThirtyDays])->count();
        }

        if (Gate::allows('view', User::class)) {
            $this->usersOffboardingSoon = User::whereBetween('end_date', [$todayStart, $inThirtyDays])->count();
        }

        // Pending checkout acceptances. whereHasMorph applies each
        // checkoutable type's own CompanyableTrait global scope so
        // FMCS scoping stays consistent. Restrict the morph list to
        // types the caller can actually view so a non-admin's count
        // reflects what they'd see if they clicked through, matching
        // the /reports/unaccepted_assets scoping.
        $acceptanceTypes = array_filter(
            [Asset::class, LicenseSeat::class, Accessory::class, SnipeComponent::class, Consumable::class],
            fn (string $type) => Gate::allows('view', $type === LicenseSeat::class ? License::class : $type),
        );
        if ($acceptanceTypes !== []) {
            $this->pendingAcceptancesCount = CheckoutAcceptance::pending()
                ->whereHasMorph('checkoutable', $acceptanceTypes)
                ->count();
        }

        // CheckoutRequest is not itself Companyable, so the widget's
        // count would otherwise leak cross-company requests to
        // FMCS-scoped admins. whereHasMorph applies each requestable
        // type's own CompanyableTrait global scope (Asset is scoped,
        // AssetModel is intentionally not per its shared-catalog
        // design) so the count matches what the /requests admin queue
        // actually renders for the current viewer. Restricted to the
        // caller's viewable types for the same reason as the
        // acceptance count above. pending() reads from the state
        // machine (source of truth) instead of the pre-refactor
        // canceled_at + fulfilled_at columns.
        $requestTypes = array_filter(
            [Asset::class, AssetModel::class, Accessory::class, Consumable::class, SnipeComponent::class, License::class],
            fn (string $type) => Gate::allows('view', $type),
        );
        if ($requestTypes !== []) {
            $this->pendingRequestsCount = CheckoutRequest::pending()
                ->whereHasMorph('requestedItem', $requestTypes)
                ->count();
        }
    }

    public function placeholder(): string
    {
        // Reserve the widget's visual footprint on initial paint so
        // the dashboard row doesn't visibly shift when the hydrated
        // list swaps in. Same height/box chrome as the rendered view.
        $collapse = trans('general.collapse');
        $title = trans('general.dashboard_attention');

        return <<<HTML
            <div class="box box-default" aria-busy="true">
                <div class="box-header with-border">
                    <h2 class="box-title">{$title}</h2>
                </div>
                <div class="box-body">
                    <ul class="list-group list-group-unbordered" style="margin-bottom: 0;">
                        <li class="list-group-item"><span class="sr-only">{$collapse}</span>&nbsp;</li>
                        <li class="list-group-item">&nbsp;</li>
                        <li class="list-group-item">&nbsp;</li>
                        <li class="list-group-item">&nbsp;</li>
                        <li class="list-group-item">&nbsp;</li>
                    </ul>
                </div>
            </div>
        HTML;
    }

    public function render(): View
    {
        return view('livewire.needs-attention');
    }
}
