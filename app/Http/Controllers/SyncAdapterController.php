<?php

namespace App\Http\Controllers;

use App\Models\Actionlog;
use App\SyncAdapters\SyncErrorFormatter;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SyncAdapterController extends Controller
{

    public function getAdapters(Request $request): View|RedirectResponse
    {
        $adapterTypes = \App\SyncAdapters\SyncAdapter::typeLabels();
        $adapterCatalog = \App\SyncAdapters\SyncAdapter::typeCatalog();

        // The filter is for UX when per-company adapters exist. Gate on whether the
        // install has any companies at all. 'Shared' means "no company_id" (built-ins and adapters available to all).
        $companies = \App\Models\Company::orderBy('name')->pluck('name', 'id')->all();
        $hasCompanies = count($companies) > 0;
        $selectedCompany = $hasCompanies ? $request->query('company') : null;

        $instanceQuery = \App\Models\SyncAdapterInstance::query()->orderBy('label');
        if ($selectedCompany === 'shared') {
            $instanceQuery->whereNull('company_id');
        } elseif ($selectedCompany !== null && $selectedCompany !== '') {
            // Company-scoped view includes the shared built-ins too, since
            // those are available to every company. Otherwise picking a
            // specific company would hide Fleet, Kandji, and friends.
            $instanceQuery->where(function ($q) use ($selectedCompany) {
                $q->where('company_id', (int) $selectedCompany)
                    ->orWhereNull('company_id');
            });
        }

        // Sort: enabled (green dot) first, then partial (yellow),
        // then inactive (red). Within each bucket, preserve the
        // database ORDER BY label.
        $readinessRank = ['active' => 0, 'partial' => 1, 'inactive' => 2];
        $adapters = $instanceQuery->get()
            ->map(fn ($i) => \App\SyncAdapters\SyncAdapter::factory($i))
            ->filter()
            ->sortBy(fn ($a) => $readinessRank[$a->readinessStatus()] ?? 99)
            ->values()
            ->all();

        // Default selection: an explicit ?adapter=slug wins if present.
        // Otherwise prefer the first-enabled adapter.
        $requestedSlug = $request->query('adapter');
        if ($requestedSlug !== null) {
            $selectedSlug = $requestedSlug;
        } else {
            $default = collect($adapters)->first(fn ($a) => $a->isEnabled()) ?? ($adapters[0] ?? null);
            $selectedSlug = $default?->name();
        }
        $selected = collect($adapters)->first(fn ($a) => $a->name() === $selectedSlug);

        // Explicit ?adapter=slug pointing at a non-existent instance
        // (deleted, typo, stale bookmark). Redirect to the default
        // view with an error
        if ($requestedSlug !== null && $selected === null) {
            return redirect()->route('settings.adapters.index')
                ->with('error', trans('admin/settings/sync_adapters.not_found', ['slug' => $requestedSlug]));
        }

        // Per-adapter count of asset_external_sources rows keyed by
        // source slug. Powers the delete-confirmation message so
        // admins see how many synced assets they are about to
        // "orphan" (assets stay, external-source link stays, sync
        // just stops). One grouped query rather than N per-adapter
        // COUNTs so the settings page stays cheap for installs with
        // many configured adapters.
        $syncedCounts = \App\Models\AssetExternalSource::query()
            ->selectRaw('source, COUNT(*) as c')
            ->groupBy('source')
            ->pluck('c', 'source')
            ->all();

        return view('settings.adapters', compact(
            'adapters', 'adapterTypes', 'adapterCatalog', 'selected', 'companies', 'hasCompanies', 'selectedCompany', 'syncedCounts',
        ));
    }

    /**
     * Create a new adapter instance.
     */
    public function postCreateAdapterInstance(Request $request): RedirectResponse
    {
        if (config('app.lock_passwords')) {
            return redirect()->back()->with('error', trans('general.feature_disabled'));
        }

        $validated = $request->validate([
            'adapter_type' => 'required|string|in:'.implode(',', \App\SyncAdapters\SyncAdapter::typeNames()),
            'label' => 'required|string|max:191|unique:sync_adapter_instances,label',
            'company_id' => 'nullable|integer|exists:companies,id',
        ]);

        // Start inactive. Active + no URL/token means "Active" ticked
        // on the settings page while Sync Now stays disabled because
        // isEnabled() also requires at least minimal config.
        $instance = new \App\Models\SyncAdapterInstance;
        $instance->fill([
            'adapter_type' => $validated['adapter_type'],
            'label' => $validated['label'],
            'company_id' => $validated['company_id'] ?? null,
            'active' => false,
        ]);

        $instance->created_by = auth()->id();
        $instance->save();

        return redirect()->route('settings.adapters.index', ['adapter' => $instance->slug])
            ->with('success', trans('admin/settings/sync_adapters.instance_created'));
    }

    /**
     * Clone an existing adapter instance. Creates a new inactive
     * instance with the same adapter_type as the source and copies
     * every SyncAdapterConfig row across so the admin lands on a
     * near-identical setup, ready for a per-clone tweak (typically
     * a different company_id or a swapped URL / token). The clone
     * starts inactive so the admin reviews before enabling sync.
     */
    public function postCloneAdapterInstance(Request $request, \App\Models\SyncAdapterInstance $instance): RedirectResponse
    {
        if (config('app.lock_passwords')) {
            return redirect()->back()->with('error', trans('general.feature_disabled'));
        }

        $validated = $request->validate([
            'label' => 'required|string|max:191|unique:sync_adapter_instances,label',
            'company_id' => 'nullable|integer|exists:companies,id',
        ]);

        $clone = new \App\Models\SyncAdapterInstance;
        $clone->fill([
            'adapter_type' => $instance->adapter_type,
            'label' => $validated['label'],
            'company_id' => $validated['company_id'] ?? null,
            'active' => false,
        ]);
        $clone->created_by = auth()->id();
        $clone->save();

        // Copy the whole config blob to the new instance. Encrypted
        // secrets copy as-is since both rows use the same APP_KEY.
        // Runtime state (last_synced_at, etc.) lives on its own
        // instance columns, not in config, so nothing survives from
        // the source's operational history.
        $clone->config = $instance->config;
        $clone->save();

        return redirect()->route('settings.adapters.index', ['adapter' => $clone->slug])
            ->with('success', trans('admin/settings/sync_adapters.instance_cloned', ['label' => $instance->label]));
    }

    /**
     * Save handler for an instance's own config form. Instance-bound
     * route param resolves the target instance. the shipped adapter
     * class knows how to persist its own fields.
     */
    public function postAdapterConfig(Request $request, \App\Models\SyncAdapterInstance $instance): RedirectResponse
    {
        if (config('app.lock_passwords')) {
            return redirect()->back()->with('error', trans('general.feature_disabled'));
        }

        $adapter = $instance->adapter();
        if ($adapter === null) {
            abort(404);
        }

        // Adapter declares its own validation (ExternalUrl on the URL
        // field blocks loopback / RFC-1918 / metadata targets so the
        // sync path can't be abused as an SSRF or port-scan primitive).
        // Label uniqueness is enforced independently so a rename can't
        // collide with an existing instance's label. `sometimes` because
        // the field is optional at the wire level: not sending label
        // leaves the current label in place (below).
        $request->validate(
            $adapter->validationRules() + [
                'label' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:191',
                    \Illuminate\Validation\Rule::unique('sync_adapter_instances', 'label')->ignore($instance->id),
                ],
                'company_id' => ['nullable', 'integer', 'exists:companies,id'],
            ]
        );

        // "active" checkbox lives on the shared partial with a slug-
        // prefixed name so tab-panes don't collide on ids. Unchecked
        // comes through as absent from the request, so default to false.
        $instance->active = $request->boolean($instance->slug.'_active');
        $instance->label = $request->input('label', $instance->label);
        // Empty string in the company-select posts as '' rather than
        // absent, so normalise to null for the shared-across-companies
        // sentinel value.
        $companyId = $request->input('company_id');
        $instance->company_id = $companyId === '' ? null : $companyId;
        $instance->save();

        $adapter->saveConfig($request);

        return redirect()->route('settings.adapters.index', ['adapter' => $instance->slug])
            ->with('success', trans('admin/settings/message.update.success'));
    }

    /**
     * Manually trigger a sync from the "Sync Now" button.
     * Realistically, this will likely time out in a real production instance,
     * so this is used mostly for testing now and will likely be removed later
     */
    public function postAdapterSync(\App\Models\SyncAdapterInstance $instance): RedirectResponse
    {
        $adapter = $instance->adapter();
        if ($adapter === null) {
            abort(404);
        }

        if (! $adapter->isEnabled()) {
            return redirect()->route('settings.adapters.index', ['adapter' => $instance->slug])
                ->with('error', trans('admin/settings/sync_adapters.not_configured'));
        }

        // Drop PHP's execution-time cap. Web-server proxy timeouts still apply tho
        set_time_limit(0);

        $seen = 0;
        $skipped = 0;
        $errors = 0;
        $startedAt = microtime(true);

        Log::channel('sync-adapters')->info("{$instance->slug} sync starting (UI)");

        try {
            Actionlog::withActionSource('sync:'.$instance->slug, function () use ($adapter, $instance, &$seen, &$skipped, &$errors) {
                foreach ($adapter->pull() as $record) {
                    try {
                        $result = \App\SyncAdapters\SyncAdapter::syncFromRecord($record);
                        if ($result === null) {
                            $skipped++;
                        } else {
                            $seen++;
                        }
                    } catch (\Throwable $e) {
                        $errors++;
                        Log::channel('sync-adapters')->warning($instance->slug.' sync: failed to upsert host '.$record->sourceId.': '.$e->getMessage());
                    }
                }
            });
        } catch (\Throwable $e) {
            Log::channel('sync-adapters')->warning(
                $instance->slug.' sync aborted: '.SyncErrorFormatter::summary($e),
                SyncErrorFormatter::logContext($e),
            );

            $failMessage = trans('admin/settings/sync_adapters.sync_failed', [
                'summary' => SyncErrorFormatter::summary($e),
            ]);
            $instance->last_synced_at = now();
            $instance->last_sync_result = $failMessage;
            $instance->save();

            return redirect()->route('settings.adapters.index', ['adapter' => $instance->slug])
                ->with('error', $failMessage);
        }

        $result = trans('admin/settings/sync_adapters.sync_complete', [
            'count' => $seen,
            'skipped' => $skipped,
            'errors' => $errors,
        ]);
        $instance->last_synced_at = now();
        $instance->last_sync_result = $result;
        $instance->save();

        $elapsed = number_format(microtime(true) - $startedAt, 1);
        Log::channel('sync-adapters')->info("{$instance->slug} sync complete: {$seen} record(s) processed, {$skipped} skipped, {$errors} error(s), elapsed {$elapsed}s");

        //   at least one seen, no errors -> success (green)
        //   at least one seen, some errors -> warning (orange, admin should check log)
        //   nothing seen at all, at least one error -> error (red)
        //   nothing seen AND no errors -> warning: vendor returned no rows,
        //     which may be legitimate (empty inventory) but is also the
        //     canary for a misconfigured pull that silently returned empty.
        //     Warning flags it for the admin to notice without being a
        //     hard error, so a genuinely empty vendor doesn't scream red.
        $flashType = match (true) {
            $seen > 0 && $errors === 0 => 'success',
            $seen > 0 && $errors > 0 => 'warning',
            $seen === 0 && $errors > 0 => 'error',
            default => 'warning',
        };

        return redirect()->route('settings.adapters.index', ['adapter' => $instance->slug])
            ->with($flashType, $result);
    }

    /**
     * Push Snipe-IT-authoritative fields to the vendor for every asset
     * already linked to this adapter instance. Only meaningful for
     * adapters that implement PushableAdapter. Iterates the instance's
     * asset_external_sources rows so we only touch assets the vendor
     * actually knows about. A fresh Snipe-IT asset that's never been
     * synced from this instance gets no push (we'd have no vendor id
     * to write against). Errors on individual assets are logged and
     * counted, so a single bad asset doesn't abort the whole run.
     */
    public function postAdapterPush(\App\Models\SyncAdapterInstance $instance): RedirectResponse
    {
        $adapter = $instance->adapter();
        if ($adapter === null) {
            abort(404);
        }

        if (! $adapter instanceof \App\SyncAdapters\PushableAdapter) {
            return redirect()->route('settings.adapters.index', ['adapter' => $instance->slug])
                ->with('error', trans('admin/settings/sync_adapters.push_not_supported'));
        }

        if (! $adapter->isEnabled()) {
            return redirect()->route('settings.adapters.index', ['adapter' => $instance->slug])
                ->with('error', trans('admin/settings/sync_adapters.not_configured'));
        }

        // Nothing to push means the admin has no fields directed 'push'
        // AND no composed-notes template + target configured. Iterating
        // asset rows in that state would just silent-no-op through
        // every one and flash a misleading "Pushed N assets" success.
        // Fail fast with a message that names the actual gap.
        if (! $adapter->hasPushConfiguration()) {
            return redirect()->route('settings.adapters.index', ['adapter' => $instance->slug])
                ->with('error', trans('admin/settings/sync_adapters.push_nothing_configured'));
        }

        set_time_limit(0);

        $pushed = 0;
        $skipped = 0;
        $errors = 0;

        try {
            \App\Models\AssetExternalSource::query()
                ->where('source', $instance->slug)
                ->with('asset')
                ->chunkById(200, function ($rows) use ($adapter, &$pushed, &$skipped, &$errors) {
                    foreach ($rows as $row) {
                        $asset = $row->asset;
                        if ($asset === null) {
                            continue;
                        }

                        try {
                            if ($adapter->push($asset)) {
                                $pushed++;
                            } else {
                                $skipped++;
                            }
                        } catch (\Throwable $e) {
                            $errors++;
                            // Log the sanitized summary (short) plus,
                            // for HTTP client exceptions, the raw
                            // response body truncated to 2KB so vendor
                            // errors like "missing required field
                            // 'query'" or "gitops mode requires spec"
                            // surface in the log even when the vendor's
                            // JSON shape isn't one the summary
                            // extractor recognizes.
                            Log::channel('sync-adapters')->warning(sprintf(
                                '%s push: asset %d failed: %s',
                                $row->source,
                                $asset->id,
                                SyncErrorFormatter::summary($e),
                            ), SyncErrorFormatter::logContext($e));
                        }
                    }
                });
        } catch (\Throwable $e) {
            Log::channel('sync-adapters')->warning(
                sprintf('%s push aborted: %s', $instance->slug, SyncErrorFormatter::summary($e)),
                SyncErrorFormatter::logContext($e),
            );

            return redirect()->route('settings.adapters.index', ['adapter' => $instance->slug])
                ->with('error', trans('admin/settings/sync_adapters.push_failed', [
                    'summary' => SyncErrorFormatter::summary($e),
                ]));
        }

        //   at least one push, no failures -> success (green)
        //   at least one push, some failures -> warning (orange, admin should check log)
        //   no pushes, at least one failure -> error (red)
        //   no pushes AND no failures (every row skipped) -> error too, since the
        //     button did nothing meaningful and the admin should know
        //   nothing to iterate at all (no matching external_sources) -> warning
        // Message includes skipped count so admins see the full breakdown.
        $flashType = match (true) {
            $pushed > 0 && $errors === 0 => 'success',
            $pushed > 0 && $errors > 0 => 'warning',
            $errors > 0 => 'error',
            $skipped > 0 => 'error',
            default => 'warning',
        };

        return redirect()->route('settings.adapters.index', ['adapter' => $instance->slug])
            ->with($flashType, trans('admin/settings/sync_adapters.push_complete', [
                'count' => $pushed,
                'skipped' => $skipped,
                'errors' => $errors,
            ]));
    }

    /**
     * Pull the current list of sites from the vendor and return it as
     * JSON so the Site ID select on the adapter settings page can
     * populate inline, without the admin having to save and reload
     * first. Credentials come from the pending form (so a brand-new
     * adapter can list its sites before anything is persisted) and
     * fall back to the stored values when the request omits them.
     * Also writes the result to cached_sites so a page reload keeps
     * the list in place.
     */
    public function postAdapterRefreshSites(Request $request, \App\Models\SyncAdapterInstance $instance): JsonResponse
    {
        if (config('app.lock_passwords')) {
            return response()->json(['error' => trans('general.feature_disabled')], 403);
        }

        $adapter = $instance->adapter();
        if ($adapter === null) {
            abort(404);
        }

        if (! $adapter->supportsSiteScoping()) {
            abort(404);
        }

        try {
            $sites = $adapter->fetchSites([
                'url' => $request->input('url'),
                'api_key' => $request->input('api_key'),
            ]);
        } catch (\Throwable $e) {
            Log::channel('sync-adapters')->warning(
                sprintf('%s refresh-sites aborted: %s', $instance->slug, $e->getMessage()),
                ['exception' => $e],
            );

            return response()->json([
                'error' => trans('admin/settings/sync_adapters.refresh_sites_failed', [
                    'summary' => SyncErrorFormatter::summary($e),
                ]),
            ], 422);
        }

        \App\Models\SyncAdapterConfig::put($instance->id, 'cached_sites', json_encode($sites));

        return response()->json([
            'sites' => $sites,
            'message' => trans('admin/settings/sync_adapters.refresh_sites_ok', [
                'count' => count($sites),
                'label' => $adapter->vendorSiteLabel(),
            ]),
        ]);
    }

    /**
     * Refresh the cached list of vendor groups for an adapter
     * instance. Calls the adapter's fetchGroups() and persists the
     * result to the instance's config blob so the settings page can render
     * the mapping table without hitting the vendor on every page load.
     *
     * Only meaningful for adapters that opt into supportsGroupScoping().
     * (Some vendors gate groups by subscripton tier like Fleet.)
     * Failures land in the sync-adapters log channel and flash a
     * sanitized error to the admin (same as sync errors).
     */
    public function postAdapterRefreshGroups(\App\Models\SyncAdapterInstance $instance): RedirectResponse
    {
        if (config('app.lock_passwords')) {
            return redirect()->back()->with('error', trans('general.feature_disabled'));
        }

        $adapter = $instance->adapter();
        if ($adapter === null) {
            abort(404);
        }

        if (! $adapter->supportsGroupScoping()) {
            abort(404);
        }

        if (! $adapter->isEnabled()) {
            return redirect()->route('settings.adapters.index', ['adapter' => $instance->slug])
                ->with('error', trans('admin/settings/sync_adapters.not_configured'));
        }

        try {
            $groups = $adapter->fetchGroups();
        } catch (\Throwable $e) {
            Log::channel('sync-adapters')->warning(
                sprintf('%s refresh-groups aborted: %s', $instance->slug, $e->getMessage()),
                ['exception' => $e],
            );

            return redirect()->route('settings.adapters.index', ['adapter' => $instance->slug])
                ->with('error', trans('admin/settings/sync_adapters.refresh_groups_failed', [
                    'summary' => SyncErrorFormatter::summary($e),
                ]));
        }

        \App\Models\SyncAdapterConfig::put($instance->id, 'cached_groups', json_encode($groups));

        return redirect()->route('settings.adapters.index', ['adapter' => $instance->slug])
            ->with('success', trans('admin/settings/sync_adapters.refresh_groups_ok', [
                'count' => count($groups),
                'label' => $adapter->vendorGroupLabel(),
            ]));
    }

    /**
     * Refresh the cached list of vendor-defined custom fields for an
     * adapter that opts into supportsVendorCustomFields(). Parallel
     * to postAdapterRefreshGroups. Hits the vendor's custom-fields
     * listing endpoint, stores the normalized list under
     * the instance's config.vendor_custom_fields key, and redirects back
     * to the adapter settings page with a count.
     */
    public function postAdapterRefreshCustomFields(\App\Models\SyncAdapterInstance $instance): RedirectResponse
    {
        if (config('app.lock_passwords')) {
            return redirect()->back()->with('error', trans('general.feature_disabled'));
        }

        $adapter = $instance->adapter();
        if ($adapter === null) {
            abort(404);
        }

        if (! $adapter->supportsVendorCustomFields()) {
            abort(404);
        }

        if (! $adapter->isEnabled()) {
            return redirect()->route('settings.adapters.index', ['adapter' => $instance->slug])
                ->with('error', trans('admin/settings/sync_adapters.not_configured'));
        }

        try {
            $fields = $adapter->fetchVendorCustomFields();
        } catch (\Throwable $e) {
            Log::channel('sync-adapters')->warning(
                sprintf('%s refresh-custom-fields aborted: %s', $instance->slug, $e->getMessage()),
                ['exception' => $e],
            );

            return redirect()->route('settings.adapters.index', ['adapter' => $instance->slug])
                ->with('error', trans('admin/settings/sync_adapters.refresh_custom_fields_failed', [
                    'summary' => SyncErrorFormatter::summary($e),
                ]));
        }

        \App\Models\SyncAdapterConfig::put($instance->id, 'vendor_custom_fields', json_encode($fields));

        return redirect()->route('settings.adapters.index', ['adapter' => $instance->slug])
            ->with('success', trans('admin/settings/sync_adapters.refresh_custom_fields_ok', [
                'count' => count($fields),
            ]));
    }

    /**
     * Delete an adapter instance. Config rows go away with it. Existing
     * asset_external_sources rows for this instance's slug are left in
     * place (orphaned) so previously-synced assets keep their history.
     */
    public function deleteAdapterInstance(\App\Models\SyncAdapterInstance $instance): RedirectResponse
    {
        if (config('app.lock_passwords')) {
            return redirect()->back()->with('error', trans('general.feature_disabled'));
        }

        // Config lives on the instance row as a JSON column, so the
        // instance delete takes it with it. No separate purge needed.
        $instance->delete();

        return redirect()->route('settings.adapters.index')
            ->with('success', trans('admin/settings/sync_adapters.instance_deleted'));
    }
}
