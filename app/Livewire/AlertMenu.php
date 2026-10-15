<?php

namespace App\Livewire;

use App\Helpers\Helper;
use App\Http\Transformers\LowStockTransformer;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;
use Livewire\Attributes\Lazy;
use Livewire\Component;

/**
 * Top-nav alert bell. Wraps the old blade/alert-menu.blade.php partial so
 * the low-inventory + deprecation queries no longer block first-paint.
 *
 * `#[Lazy]` makes the component render a lightweight placeholder on the
 * initial page load, then Livewire fires a second XHR to hydrate the
 * real body, so the helper queries below never sit on the critical
 * render path.
 *
 * The setting-gate lives on the tag in layouts/default.blade.php:
 * `@if ($snipeSettings->show_alerts_in_menu == '1') <livewire:alert-menu />`
 * so nothing about this component runs when the operator turned the
 * bell off.
 */
#[Lazy]
class AlertMenu extends Component
{
    public function placeholder(): string
    {
        // Reserve the same visual footprint as the loaded bell so the
        // top-nav doesn't shift when the real component swaps in. The
        // hidden label reserves badge width so hydration with alerts
        // does not push the surrounding nav items sideways. Kept in
        // sync with the same-shape hidden-label in the loaded view
        // (livewire/alert-menu.blade.php) so the "no alerts" state also
        // preserves the reserved width.
        $srOnly = trans('general.alerts');

        return <<<HTML
            <li class="dropdown tasks-menu" aria-busy="true">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="far fa-flag" aria-hidden="true"></i>
                    <span class="sr-only">{$srOnly}</span>
                    <span class="label label-danger" aria-hidden="true" style="visibility: hidden">0</span>
                </a>
            </li>
        HTML;
    }

    public function render(): View
    {
        // Filter the shared low-inventory result to the categories this
        // caller can view. Reuses the per-row filter the LowStock API
        // uses so the bell and the dashboard widget never disagree on
        // what a given user can see. Admins who can view no source
        // type at all get an empty bell rather than the component
        // throwing - this is a nav widget that mounts on every page.
        $alert_items = LowStockTransformer::viewableByCaller(
            Helper::checkLowInventory(),
            auth()->user(),
        );

        // Deprecation notices leak operator config (currently a
        // webhook-provider heads-up for admins to action), so gate on
        // the admin policy. Normal users don't see the notice even
        // when the admin's webhook config matches.
        $deprecations = Gate::allows('admin') ? Helper::deprecationCheck() : [];

        return view('livewire.alert-menu', [
            'alert_items' => $alert_items,
            'deprecations' => $deprecations,
            'alert_count' => count($alert_items) + count($deprecations),
        ]);
    }
}
