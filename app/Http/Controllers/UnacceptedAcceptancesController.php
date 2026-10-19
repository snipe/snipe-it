<?php

namespace App\Http\Controllers;

use App\Mail\CheckoutAccessoryMail;
use App\Mail\CheckoutAssetMail;
use App\Mail\CheckoutComponentMail;
use App\Mail\CheckoutConsumableMail;
use App\Mail\CheckoutLicenseMail;
use App\Models\Accessory;
use App\Models\Asset;
use App\Models\CheckoutAcceptance;
use App\Models\Company;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\License;
use App\Models\LicenseSeat;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;


class UnacceptedAcceptancesController extends Controller
{
    public function index(): View
    {
        $this->authorize('canCheckoutAtLeastOneItemType');

        $showDeleted = request('deleted') === 'deleted';

        return view('unaccepted-acceptances.index', compact('showDeleted'));
    }

    public function sendReminder(Request $request): RedirectResponse
    {
        $this->authorize('canCheckoutAtLeastOneItemType');

        $acceptance = $this->loadPendingAcceptance($request->input('acceptance_id'));

        if (! $acceptance) {
            Log::debug('No pending acceptances');

            return redirect()->route('unaccepted-acceptances.index')->with('error', trans('general.bad_data'));
        }

        if (! $this->currentUserCanAccessAcceptance($acceptance)) {
            return redirect()->route('unaccepted-acceptances.index')->with('error', trans('general.insufficient_permissions'));
        }

        $result = $this->dispatchReminder($acceptance);

        if ($result === 'sent') {
            return redirect()->route('unaccepted-acceptances.index')->with('success', trans('admin/reports/general.reminder_sent'));
        }

        return redirect()->route('unaccepted-acceptances.index')->with('error', trans('general.'.$result));
    }

    public function bulkSendReminders(Request $request): RedirectResponse
    {
        $this->authorize('canCheckoutAtLeastOneItemType');

        $ids = array_values(array_unique(array_filter(array_map('intval', (array) $request->input('ids', [])))));

        if ($ids === []) {
            return redirect()->route('unaccepted-acceptances.index')
                ->with('warning', trans('general.bulk_checkin_delete.nothing_selected', ['object_type' => trans('general.unaccepted_asset_report')]));
        }

        $sent = 0;
        // Keyed-by-reason-code tally so the flash message can tell the
        // admin WHY rows skipped (missing acceptance / FMCS / no email)
        // rather than a flat count that silently hides whichever class
        // of problem is in effect.
        $skippedByReason = [
            'not_found' => 0,
            'fmcs' => 0,
            'no_email' => 0,
            'bad_data' => 0,
        ];

        foreach ($ids as $id) {
            $acceptance = $this->loadPendingAcceptance($id);

            if (! $acceptance) {
                $skippedByReason['not_found']++;

                continue;
            }

            if (! $this->currentUserCanAccessAcceptance($acceptance)) {
                $skippedByReason['fmcs']++;

                continue;
            }

            $result = $this->dispatchReminder($acceptance);
            if ($result === 'sent') {
                $sent++;
            } else {
                $skippedByReason[$result] = ($skippedByReason[$result] ?? 0) + 1;
            }
        }

        $totalSkipped = array_sum($skippedByReason);

        return redirect()->route('unaccepted-acceptances.index')->with(
            $sent > 0 ? 'success' : 'warning',
            trans('admin/reports/general.bulk_reminders_sent', [
                'sent' => $sent,
                'skipped' => $totalSkipped,
                'breakdown' => $this->formatSkipBreakdown($skippedByReason),
            ]),
        );
    }

    /**
     * Compose the ", (N no email, N FMCS blocked, ...)" suffix for the
     * bulk-send flash. Reasons with zero skips are omitted so the
     * message stays short in the common case. Returns an empty string
     * when nothing skipped.
     *
     * @param  array<string, int>  $skippedByReason
     */
    private function formatSkipBreakdown(array $skippedByReason): string
    {
        $labels = [
            'not_found' => trans('admin/reports/general.skip_not_found'),
            'fmcs' => trans('admin/reports/general.skip_fmcs'),
            'no_email' => trans('admin/reports/general.skip_no_email'),
            'bad_data' => trans('admin/reports/general.skip_bad_data'),
        ];

        $parts = [];
        foreach ($skippedByReason as $reason => $count) {
            if ($count > 0 && isset($labels[$reason])) {
                $parts[] = $count.' '.$labels[$reason];
            }
        }

        return $parts === [] ? '' : ' ('.implode(', ', $parts).')';
    }

    public function destroy(int $acceptanceId): RedirectResponse
    {
        $this->authorize('canCheckoutAtLeastOneItemType');

        $acceptance = CheckoutAcceptance::pending()
            ->with(['checkoutable' => function (MorphTo $morphTo) {
                $morphTo->morphWith([LicenseSeat::class => ['license']]);
            }])
            ->find($acceptanceId);

        if (! $acceptance) {
            return redirect()->route('unaccepted-acceptances.index')->with('error', trans('general.bad_data'));
        }

        if (! $this->currentUserCanAccessAcceptance($acceptance)) {
            return redirect()->route('unaccepted-acceptances.index')->with('error', trans('general.insufficient_permissions'));
        }

        if ($acceptance->delete()) {
            return redirect()->route('unaccepted-acceptances.index')->with('success', trans('admin/reports/general.acceptance_deleted'));
        }

        return redirect()->route('unaccepted-acceptances.index')->with('error', trans('general.deletion_failed'));
    }

    private function loadPendingAcceptance(mixed $id): ?CheckoutAcceptance
    {
        if (! is_numeric($id)) {
            return null;
        }

        return CheckoutAcceptance::query()
            ->with([
                'checkoutable' => function (MorphTo $query) {
                    $query->withTrashed()->morphWith([
                        Asset::class => ['model.category', 'assignedTo', 'company', 'checkouts'],
                        Accessory::class => ['category', 'company', 'checkouts'],
                        LicenseSeat::class => ['user', 'license', 'checkouts'],
                        Component::class => ['assignedTo', 'company', 'checkouts'],
                        Consumable::class => ['company', 'checkouts'],
                    ]);
                },
                'assignedTo' => fn ($q) => $q->withTrashed(),
            ])
            ->pending()
            ->find((int) $id);
    }

    /**
     * Send the reminder email for a given pending acceptance. Returns
     * 'sent' on success or a general.* lang-key suffix on failure.
     * Keys match the row-level flow this method replaces: bad_data,
     * no_email.
     */
    private function dispatchReminder(CheckoutAcceptance $acceptance): string
    {
        $item = $acceptance->checkoutable;
        $assignee = $acceptance->assignedTo ?? $item->assignedTo ?? null;
        $email = $assignee?->email;
        $locale = $assignee?->locale;

        if (is_null($acceptance->created_at)) {
            return 'bad_data';
        }

        // Pull the action_log row that recorded the checkout so the
        // reminder email can attribute "sent by" to the admin who
        // handed the item out. A 1-second window instead of exact-
        // equality on created_at accommodates sub-second drift between
        // the acceptance row and its action_log sibling (seen on busy
        // installs where the two writes land in different ticks). If
        // no log row matches at all we proceed with a null adminuser
        // rather than fail the whole send.
        $acceptanceCreated = $acceptance->created_at;
        $window = [
            $acceptanceCreated->copy()->subSecond(),
            $acceptanceCreated->copy()->addSecond(),
        ];
        $logItem = $item instanceof LicenseSeat
            ? $item->license?->checkouts()->with('adminuser')->whereBetween('created_at', $window)->orderByDesc('created_at')->first()
            : $item->checkouts()->with('adminuser')->whereBetween('created_at', $window)->orderByDesc('created_at')->first();

        if (is_null($email) || $email === '') {
            return 'no_email';
        }

        Mail::to($email)->send($this->getCheckoutMailType($acceptance, $logItem)->locale($locale));

        return 'sent';
    }

    private function getCheckoutMailType(CheckoutAcceptance $acceptance, $logItem): Mailable
    {
        $lookup = [
            Accessory::class => CheckoutAccessoryMail::class,
            Asset::class => CheckoutAssetMail::class,
            LicenseSeat::class => CheckoutLicenseMail::class,
            Consumable::class => CheckoutConsumableMail::class,
            Component::class => CheckoutComponentMail::class,
        ];
        $mailable = $lookup[get_class($acceptance->checkoutable)];

        return new $mailable(
            $acceptance->checkoutable,
            $acceptance->checkedOutTo ?? $acceptance->assignedTo,
            $logItem?->adminuser,
            $acceptance,
            $acceptance->note,
            firstTimeSending: false,
        );
    }

    /**
     * Per-row FMCS scope check. CheckoutAcceptance has no company_id of
     * its own and does not use CompanyableTrait, so it falls outside
     * CompanyableScope. Without this check, a company-A caller could
     * remind or delete a company-B acceptance.
     */
    private function currentUserCanAccessAcceptance(CheckoutAcceptance $acceptance): bool
    {
        if (! Company::isFullMultipleCompanySupportEnabled()) {
            return true;
        }

        if (auth()->user()->isSuperUser()) {
            return true;
        }

        $checkoutableType = $acceptance->checkoutable_type;
        $checkoutable = $checkoutableType::withoutGlobalScopes()->find($acceptance->checkoutable_id);

        if ($checkoutable instanceof LicenseSeat) {
            $checkoutable = License::withoutGlobalScopes()->find($checkoutable->license_id);
        }

        return Company::isCurrentUserHasAccess($checkoutable);
    }
}
