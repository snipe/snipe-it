<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Location;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class BulkLocationsController extends Controller
{
    public function edit(Request $request): View|RedirectResponse
    {
        $this->authorize('update', Location::class);

        $ids = $request->input('ids');

        if (! is_array($ids) || count($ids) === 0) {
            return redirect()->route('locations.index')
                ->with('error', trans('general.bulk.delete.nothing_selected', ['object_type' => trans_choice('general.location_plural', 2)]));
        }

        if ($request->input('bulk_actions') === 'edit') {
            return $this->renderEditForm($ids);
        }

        return $this->renderDeleteForm($ids);
    }

    /**
     *    Cross-tenant guards:
     *
     *  - Locations are loaded through the CompanyableScope, so a scoped
     *   editor never sees rows outside their tenant even if the request
     *   POSTs the ids directly.
     * - `authorize('update', $location)` runs per-row as defense in depth
     *   against a policy override that later adds instance-level gating.
     * - `parent_id`, `company_id`, and `manager_id` targets are validated
     *   against the acting user's own visibility before being written,
     *   so a scoped editor can't reparent a visible location under a
     *   parent, company, or manager they can't see.
     */
    public function update(Request $request): RedirectResponse
    {
        $this->authorize('update', Location::class);

        $ids = $request->input('ids');

        if (! is_array($ids) || count($ids) === 0) {
            return redirect()->route('locations.index')
                ->with('error', trans('general.bulk.delete.nothing_selected', ['object_type' => trans_choice('general.location_plural', 2)]));
        }

        $update_array = $this->buildUpdateArray($request);

        if (count($update_array) === 0) {
            return redirect()->route('locations.index')
                ->with('warning', trans('admin/locations/message.bulkedit.error'));
        }

        $newParentId = $update_array['parent_id'] ?? null;
        $settings = Setting::getSettings();
        $fmcsOn = (bool) $settings->full_multiple_companies_support;
        $scopeLocationsFmcs = (bool) $settings->scope_locations_fmcs;
        $companyChangeRequested = array_key_exists('company_id', $update_array);
        $successCount = 0;
        $companyScopeMismatchCount = 0;
        $parentCompanyMismatchCount = 0;

        foreach (Location::whereIn('id', $ids)->get() as $location) {
            if (! Gate::allows('update', $location)) {
                continue;
            }

            $rowUpdates = $update_array;

            // The row can't be its own parent. Watson's non_circular
            // validator would reject a save that formed a longer cycle
            // through descendants. Catching the trivial self case up
            // front lets those rows still apply their other fields.
            if ($newParentId !== null && $newParentId === $location->id) {
                unset($rowUpdates['parent_id']);
            }

            // Under FMCS + location scoping, reassigning a location's
            // company_id changes what other tenants can see at that
            // location. If the location still has assets, accessories,
            // consumables, components, users, or a manager tied to a
            // different company, the reassignment would create a
            // visibility mismatch. Skip company_id on that row (other
            // fields still apply) and count the skip so the flash
            // can tell the operator how many rows didn't move.
            if ($scopeLocationsFmcs && $companyChangeRequested && array_key_exists('company_id', $rowUpdates)) {
                $mismatched = Helper::test_locations_fmcs(false, $location->id, $rowUpdates['company_id']);
                if ($mismatched !== []) {
                    unset($rowUpdates['company_id']);
                    $companyScopeMismatchCount++;
                }
            }

            // Parent/child company invariant under FMCS. Mirrors the
            // rejection at LocationsController::update for
            // single edits. If the effective (post-update) parent
            // belongs to a different company than the effective
            // (post-update) company_id, the pair would violate the
            // invariant. Skip parent_id if the operator explicitly
            // submitted one, or skip company_id if only that was
            // changed and the existing parent no longer matches.
            if ($fmcsOn) {
                $effectiveCompanyId = array_key_exists('company_id', $rowUpdates)
                    ? $rowUpdates['company_id']
                    : $location->company_id;
                $effectiveParentId = array_key_exists('parent_id', $rowUpdates)
                    ? $rowUpdates['parent_id']
                    : $location->parent_id;

                if ($effectiveParentId !== null) {
                    // withoutGlobalScopes: Location::CompanyableScope would
                    // filter a cross-tenant parent out for a scoped
                    // non-superuser, so find() would return null and the
                    // null check below would short-circuit the reject
                    // branch, letting a cross-company parent link save
                    // through. See ValidationServiceProvider::fmcs_location
                    // for the sibling fix.
                    $parent = Location::withoutGlobalScopes()->find($effectiveParentId);
                    if ($parent && $parent->company_id != $effectiveCompanyId) {
                        if (array_key_exists('parent_id', $rowUpdates)) {
                            unset($rowUpdates['parent_id']);
                        } elseif (array_key_exists('company_id', $rowUpdates)) {
                            unset($rowUpdates['company_id']);
                        }
                        $parentCompanyMismatchCount++;
                    }
                }
            }

            if (count($rowUpdates) === 0) {
                continue;
            }

            if ($location->fill($rowUpdates)->save()) {
                $successCount++;
            }
        }

        if ($successCount === 0) {
            $warning = trans('admin/locations/message.bulkedit.error');

            if ($companyScopeMismatchCount > 0) {
                $warning = trans_choice(
                    'admin/locations/message.bulkedit.company_scope_mismatch_all',
                    $companyScopeMismatchCount,
                    ['count' => $companyScopeMismatchCount],
                );
            } elseif ($parentCompanyMismatchCount > 0) {
                $warning = trans_choice(
                    'admin/locations/message.bulkedit.parent_company_mismatch_all',
                    $parentCompanyMismatchCount,
                    ['count' => $parentCompanyMismatchCount],
                );
            }

            return redirect()->route('locations.index')->with('warning', $warning);
        }

        $response = redirect()->route('locations.index')
            ->with('success', trans_choice('admin/locations/message.bulkedit.success', $successCount, [
                'count' => $successCount,
            ]));

        $warnings = [];
        if ($companyScopeMismatchCount > 0) {
            $warnings[] = trans_choice(
                'admin/locations/message.bulkedit.company_scope_mismatch_partial',
                $companyScopeMismatchCount,
                ['count' => $companyScopeMismatchCount],
            );
        }
        if ($parentCompanyMismatchCount > 0) {
            $warnings[] = trans_choice(
                'admin/locations/message.bulkedit.parent_company_mismatch_partial',
                $parentCompanyMismatchCount,
                ['count' => $parentCompanyMismatchCount],
            );
        }
        if ($warnings !== []) {
            $response = $response->with('warning', implode(' ', $warnings));
        }

        return $response;
    }

    /**
     * Apply the bulk delete to every selected location that is
     * deletable.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $this->authorize('delete', Location::class);

        $ids = $request->input('ids');

        if (! is_array($ids) || count($ids) === 0) {
            return redirect()->route('locations.index')
                ->with('error', trans('general.bulk.nothing_selected', ['object_type' => trans('general.locations')]));
        }

        $locations = Location::whereIn('id', $ids)
            ->withCount('assignedAssets as assigned_assets_count')
            ->withCount('assets as assets_count')
            ->withCount('assignedAccessories as assigned_accessories_count')
            ->withCount('accessories as accessories_count')
            ->withCount('rtd_assets as rtd_assets_count')
            ->withCount('children as children_count')
            ->withCount('users as users_count')
            ->withCount('consumables as consumables_count')
            ->withCount('components as components_count')->get();

        $success_count = 0;
        $error_count = 0;

        foreach ($locations as $location) {
            if ($location->isDeletable()) {
                $location->delete();
                $success_count++;
            } else {
                $error_count++;
            }
        }

        Log::debug('Success count: '.$success_count);
        Log::debug('Error count: '.$error_count);

        if ($success_count === count($ids)) {
            return redirect()->route('locations.index')
                ->with('success', trans_choice('general.bulk.delete.success', $success_count, [
                    'object_type' => trans_choice('general.location_plural', $success_count),
                    'count' => $success_count,
                ]));
        }

        if ($error_count > 0) {
            return redirect()->route('locations.index')
                ->with('warning', trans('general.bulk.delete.partial', [
                    'success' => $success_count,
                    'error' => $error_count,
                    'object_type' => trans('general.locations'),
                ]));
        }

        return redirect()->route('locations.index')
            ->with('error', trans('general.bulk.nothing_selected', ['object_type' => trans('general.locations')]));
    }

    /**
     * Assemble the field-level updates from the request. Every field is
     * optional and blank submissions are skipped so an operator can
     * change one field across a batch without touching the others.
     *
     * Cross-tenant guards on referential fields: parent_id and
     * manager_id lookups run through the tenant-scoped models so
     * out-of-scope references silently drop off. company_id is gated
     * through Company::getIdsForCurrentUser which returns an empty
     * slice for scoped editors who don't belong to the requested
     * company. FMCS-off installs skip company_id entirely.
     */
    protected function buildUpdateArray(Request $request): array
    {
        $update_array = [];

        if ($request->filled('parent_id')) {
            $parent_id = (int) $request->input('parent_id');
            if (Location::find($parent_id)) {
                $update_array['parent_id'] = $parent_id;
            }
        }

        // Bulk company reassignment is superuser-only when FMCS is on.
        // The single-location edit path allows a company-scoped user to
        // reassign a location between their own memberships, but bulk
        // has amplified blast radius (accidental drop-down click hits
        // every selected row), and moving locations between tenants
        // affects visibility for every user in the source and target
        // companies. Ship the more defensive default here. Scoped
        // admins can still use the single-edit path row-by-row.
        if (Setting::getSettings()->full_multiple_companies_support == '1'
            && auth()->user()->isSuperUser()
            && $request->filled('company_id')
        ) {
            $update_array['company_id'] = (int) $request->input('company_id');
        }

        if ($request->filled('manager_id')) {
            $manager_id = (int) $request->input('manager_id');
            if (User::find($manager_id)) {
                $update_array['manager_id'] = $manager_id;
            }
        }

        if ($request->filled('currency')) {
            $update_array['currency'] = $request->input('currency');
        }

        if ($request->filled('state')) {
            $update_array['state'] = $request->input('state');
        }

        if ($request->filled('country')) {
            $update_array['country'] = $request->input('country');
        }

        if ($request->filled('notes')) {
            $update_array['notes'] = $request->input('notes');
        }

        // Per-field "clear to null" checkboxes, matching the users
        // bulk-edit pattern. A checked null_<field> box overrides
        // whatever value came in on the field itself, so an operator
        // who accidentally picks a value AND checks the null box still
        // ends up clearing the column. company_id null is only offered
        // when FMCS is on, and only actually applied if the acting user
        // is allowed to leave a location without a company (superuser or
        // floater mode). Watson's fmcs_company validator will otherwise
        // silently reject the save for a scoped non-superuser.
        if ($request->input('null_parent_id') === '1') {
            $update_array['parent_id'] = null;
        }

        if (Setting::getSettings()->full_multiple_companies_support == '1'
            && auth()->user()->isSuperUser()
            && $request->input('null_company_id') === '1'
        ) {
            $update_array['company_id'] = null;
        }

        if ($request->input('null_manager_id') === '1') {
            $update_array['manager_id'] = null;
        }

        if ($request->input('null_currency') === '1') {
            $update_array['currency'] = null;
        }

        if ($request->input('null_state') === '1') {
            $update_array['state'] = null;
        }

        if ($request->input('null_country') === '1') {
            $update_array['country'] = null;
        }

        if ($request->input('null_notes') === '1') {
            $update_array['notes'] = null;
        }

        return $update_array;
    }

    /**
     * Render the bulk-edit confirmation view.
     */
    protected function renderEditForm(array $ids): View|RedirectResponse
    {
        $locations = Location::whereIn('id', $ids)->get();

        if ($locations->isEmpty()) {
            return redirect()->route('locations.index')
                ->with('error', trans('general.bulk.delete.nothing_selected', ['object_type' => trans_choice('general.location_plural', 2)]));
        }

        return view('locations/bulk-edit', compact('locations'));
    }

    /**
     * Render the bulk-delete confirmation view. Preserves the eager
     * withCount() shape the pre-existing view expects so the "row is
     * still in use" hints keep working.
     */
    protected function renderDeleteForm(array $ids): View|RedirectResponse
    {
        $locations = Location::whereIn('id', $ids)
            ->withCount('assignedAssets as assigned_assets_count')
            ->withCount('assets as assets_count')
            ->withCount('assignedAccessories as assigned_accessories_count')
            ->withCount('accessories as accessories_count')
            ->withCount('rtd_assets as rtd_assets_count')
            ->withCount('children as children_count')
            ->withCount('consumables as consumables_count')
            ->withCount('components as components_count')
            ->withCount('users as users_count')->get();

        $valid_count = 0;
        foreach ($locations as $location) {
            if ($location->isDeletable()) {
                $valid_count++;
            }
        }

        if ($valid_count === 0) {
            return redirect()->route('locations.index')
                ->with('error', trans('general.bulk.delete.nothing_deletable', ['object_type' => trans_choice('general.location_plural', 2)]));
        }

        return view('locations/bulk-delete', compact('locations'))
            ->with('valid_count', $valid_count)
            ->with('selected_count', $locations->count());
    }
}
