<?php

namespace App\Models\Traits;

use App\Models\Company;
use App\Models\CompanyableScope;
use App\Models\Location;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

trait CompanyableTrait
{
    /**
     * This trait is used to scope models to the current company. To use this scope on companyable models,
     * we use the "use Companyable;" statement at the top of the mode.
     *
     * @see    Company::scopeCompanyables()
     *
     * @return void
     */
    public static function bootCompanyableTrait()
    {
        static::addGlobalScope(new CompanyableScope);
    }

    /**
     * The company ID this model presents for FMCS checkout validation.
     * Location overrides this to walk the parent chain.
     */
    public function effectiveFmcsCompanyId(): ?int
    {
        return $this->company_id ? (int) $this->company_id : null;
    }

    /**
     * Whether this item may be checked out to the given target under FMCS rules.
     *
     * Returns true when:
     *  - FMCS is disabled, OR
     *  - this item has no company (uncompanied items are unrestricted), OR
     *  - target is a User whose company pivot includes this item's company
     *    (or its parent — see User::canReceiveFromCompany), OR
     *  - target is a Location and scope_locations_fmcs is disabled, OR
     *  - target has no effective company and null_company_is_floater is enabled, OR
     *  - target's effective company_id exactly matches this item's company_id, OR
     *  - target is a Location and its effective company is in the same one-level
     *    company hierarchy as this item's company (parent ↔ child either way).
     */
    public function canCheckoutTo(Model $target): bool
    {
        $settings = Setting::getSettings();

        if (! $settings->full_multiple_companies_support) {
            return true;
        }

        if (! $this->company_id) {
            // For a User target, delegate to canReceiveFromCompany(null),
            // which reads company_user directly via DB::table and avoids
            // the FMCS global scope on the companies-table subquery. A
            // naive $target->companies()->count() re-applies the actor's
            // CompanyableScope to the companies table, and for an
            // empty-pivot actor Company::scopeCompanyablesDirectly reduces
            // that subquery to whereNull('companies.id'), which never
            // matches (companies.id is a NOT NULL primary key). Every
            // target then looks like it has no company, flipping the
            // strict-mode deny to allow. See User::canReceiveFromCompany
            // for the comment and GHSA-6hxf-hqrc-wfrp for the
            // specific bypass this closes.
            if ($target instanceof User) {
                return $target->canReceiveFromCompany(null);
            }

            if (is_null($target->company_id)) {
                return true;
            }

            return (bool) $settings->null_company_is_floater;
        }

        if ($target instanceof User) {
            return $target->canReceiveFromCompany((int) $this->company_id);
        }

        if ($target instanceof Location && ! $settings->scope_locations_fmcs) {
            return true;
        }

        $targetCompanyId = method_exists($target, 'effectiveFmcsCompanyId')
            ? $target->effectiveFmcsCompanyId()
            : ($target->company_id ? (int) $target->company_id : null);

        if (is_null($targetCompanyId)) {
            return (bool) $settings->null_company_is_floater;
        }

        $itemCompanyId = (int) $this->company_id;

        if ($targetCompanyId === $itemCompanyId) {
            return true;
        }

        // Hierarchy expansion mirrors User::canReceiveFromCompany — a Location
        // whose effective company is a parent or direct child of the item's
        // company is an allowed destination. Without this, a parent-company
        // user can SEE child-company assets and locations but can't actually
        // check the assets out to those locations.
        if ($target instanceof Location) {
            return in_array($targetCompanyId, Company::reachableCompanyIds($itemCompanyId), true);
        }

        return false;
    }
}
