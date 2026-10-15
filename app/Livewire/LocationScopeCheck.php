<?php

namespace App\Livewire;

use App\Helpers\Helper;
use App\Models\Setting;
use Livewire\Component;

class LocationScopeCheck extends Component
{
    public $mismatched = [];

    public $setting;

    public $is_tested = false;

    /**
     * Route-level middleware on /admin/settings requires superuser, but
     * snapshot replay to POST /livewire/update bypasses that gate. Without
     * this check, a low-privilege user with a valid snapshot could invoke
     * check_locations() and read cross-tenant FMCS-mismatch data through
     * the render payload.
     */
    public function boot(): void
    {
        if (! auth()->user()?->isSuperUser()) {
            abort(403);
        }
    }

    public function check_locations()
    {
        $this->mismatched = Helper::test_locations_fmcs(false);
        $this->is_tested = true;
    }

    public function mount()
    {
        $this->setting = Setting::getSettings();
    }

    public function render()
    {
        return view('livewire.location-scope-check');
    }
}
