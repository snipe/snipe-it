<?php

namespace App\Http\Controllers\Licenses;

use App\Actions\Acceptances\CreateCheckoutAcceptanceAction;
use App\Events\CheckoutableCheckedOut;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\LicenseCheckoutRequest;
use App\Models\Asset;
use App\Models\CheckoutAcceptance;
use App\Models\CheckoutRequest;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LicenseCheckoutController extends Controller
{
    /**
     * Provides the form view for checking out a license to a user.
     * Here we pass the license seat ID instead of the license ID,
     * because licenses themselves are never checked out to anyone,
     * only the seats associated with them.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.0]
     *
     * @param  $id
     * @return View |RedirectResponse
     *
     * @throws AuthorizationException
     */
    public function create(Request $request, License $license)
    {
        $this->authorize('checkout', $license);

        if ($license->category) {

            // Make sure there is at least one available to checkout
            if ($license->availCount()->count() < 1) {
                return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.checkout.not_enough_seats'));
            }

            // Make sure the license is expired or terminated
            if ($license->isInactive()) {
                return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.checkout.license_is_inactive'));
            }

            // We don't currently allow checking out licenses to locations, so we'll reset that to user if needed
            if (session()->get('checkout_to_type') == 'location') {
                session()->put(['checkout_to_type' => 'user']);
            }

            // Optional ?request_id hint. Present when the admin
            // reached this screen from a /requests row. Drives the
            // side-panel context box (who asked + waiting list).
            // CheckoutRequest::contextForCheckout handles the URL-
            // twiddle guards; a miss returns nulls / empty so the
            // panel renders nothing.
            $context = CheckoutRequest::contextForCheckout(
                $request->integer('request_id') ?: null,
                License::class,
                $license->id,
            );

            return view('licenses/checkout', compact('license'))
                ->with('checkoutRequest', $context['checkoutRequest'])
                ->with('otherPendingRequests', $context['otherPendingRequests']);
        }

        // Invalid category
        return redirect()->route('licenses.edit', ['license' => $license->id])
            ->with('error', trans('general.invalid_item_category_single', ['type' => trans('general.license')]));

    }

    /**
     * Validates and stores the license checkout action.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @since [v1.0]
     *
     * @return RedirectResponse
     *
     * @throws AuthorizationException
     */
    public function store(LicenseCheckoutRequest $request, $licenseId, $seatId = null)
    {
        if (! $license = License::find($licenseId)) {
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.not_found'));
        }

        $this->authorize('checkout', $license);

        // Make sure there is at least one available to checkout
        if ($license->availCount()->count() < 1) {
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.checkout.not_enough_seats'));
        }

        // Make sure the license is expired or terminated
        if ($license->isInactive()) {
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.checkout.license_is_inactive'));
        }

        if (Setting::getSettings()->full_multiple_companies_support == '1') {
            if ($request->filled('assigned_asset')) {
                $fmcsTarget = Asset::find($request->input('assigned_asset'));
                if ($fmcsTarget && ! $license->canCheckoutTo($fmcsTarget)) {
                    return redirect()->route('licenses.index')->with('error', trans('general.error_checkout_company_mismatch', [
                        'item' => trans('general.license').' "'.$license->name.'"',
                        'item_company' => $license->company?->name ?? trans('general.unassigned'),
                        'target' => trans('general.asset').' "'.$fmcsTarget->display_name.'"',
                    ]));
                }
            } elseif ($request->filled('assigned_user')) {
                $fmcsTarget = User::find($request->input('assigned_user'));
                if ($fmcsTarget && ! $license->canCheckoutTo($fmcsTarget)) {
                    return redirect()->route('licenses.index')->with('error', trans('general.error_checkout_company_mismatch', [
                        'item' => trans('general.license').' "'.$license->name.'"',
                        'item_company' => $license->company?->name ?? trans('general.unassigned'),
                        'target' => trans('general.user').' "'.$fmcsTarget->username.'"',
                    ]));
                }
            }
        }

        $licenseSeat = null;
        $checkoutTarget = null;

        DB::transaction(function () use ($request, $license, $seatId, &$licenseSeat, &$checkoutTarget): void {
            $licenseSeat = $this->findLicenseSeatToCheckout($license, $seatId, lock: true);
            $licenseSeat->created_by = auth()->id();
            $licenseSeat->notes = $request->input('notes');

            if ($request->filled('assigned_asset')) {
                $checkoutTarget = $this->checkoutToAsset($licenseSeat);
            } elseif ($request->filled('assigned_user')) {
                $checkoutTarget = $this->checkoutToUser($licenseSeat);
            }
        });

        if ($request->filled('assigned_asset')) {
            session()->put([
                'redirect_option' => $request->input('redirect_option'),
                'checkout_to_type' => 'asset',
                'sign_in_place' => $request->boolean('sign_in_place'),
            ]);
        } elseif ($request->filled('assigned_user')) {
            session()->put([
                'redirect_option' => $request->input('redirect_option'),
                'checkout_to_type' => 'user',
                'sign_in_place' => $request->boolean('sign_in_place'),
            ]);
        }

        if ($checkoutTarget) {

            // When sign_in_place is requested and the target is a user, redirect to the
            // acceptance/signature page so the user can sign in person.
            if ($request->boolean('sign_in_place') && $checkoutTarget instanceof User) {
                $acceptance = CheckoutAcceptance::where('checkoutable_type', LicenseSeat::class)
                    ->where('checkoutable_id', $licenseSeat->id)
                    ->where('assigned_to_id', $checkoutTarget->id)
                    ->pending()
                    ->latest()
                    ->first();

                // If requireAcceptance() is false the listener won't have created one; create it now.
                if (! $acceptance) {
                    $acceptance = CreateCheckoutAcceptanceAction::run($licenseSeat, $checkoutTarget);
                }

                session([
                    'sign_in_place_acceptance_id' => $acceptance->id,
                    'sign_in_place_item_id' => $license->id,
                    'sign_in_place_resource_type' => 'Licenses',
                ]);

                return redirect()->route('account.accept.item', $acceptance->id)
                    ->with('success', trans('admin/licenses/message.checkout.success'));
            }

            return Helper::getRedirectOption($request, $license->id, 'Licenses')
                ->with('success', trans('admin/licenses/message.checkout.success'));
        }

        return redirect()->route('licenses.index')->with('error', trans('Something went wrong handling this checkout.'));
    }

    protected function findLicenseSeatToCheckout($license, $seatId, bool $lock = false)
    {
        $licenseSeat = $seatId
            ? LicenseSeat::where('id', $seatId)->when($lock, fn ($q) => $q->lockForUpdate())->first()
            : $license->freeSeat(lock: $lock);

        if (! $licenseSeat) {
            if ($seatId) {
                throw new HttpResponseException(redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.checkout.unavailable')));
            }

            throw new HttpResponseException(redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.checkout.not_enough_seats')));
        }

        if (! $licenseSeat->license->is($license)) {
            throw new HttpResponseException(redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.checkout.mismatch')));
        }

        // GHSA-r25g-f428-466r: reject retired-unreassignable seats.
        if ($licenseSeat->unreassignable_seat) {
            throw new HttpResponseException(redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.checkout.unavailable')));
        }

        // GHSA-r25g-f428-466r: reject occupied seats.
        if ($licenseSeat->assigned_to !== null || $licenseSeat->asset_id !== null) {
            throw new HttpResponseException(redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.checkout.unavailable')));
        }

        return $licenseSeat;
    }

    protected function checkoutToAsset($licenseSeat)
    {
        if (is_null($target = Asset::find(request('assigned_asset')))) {
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.asset_does_not_exist'));
        }
        $licenseSeat->asset_id = request('assigned_asset');

        // Override asset's assigned user if available
        if ($target->checkedOutToUser()) {
            $licenseSeat->assigned_to = $target->assigned_to;
        }
        if ($licenseSeat->save()) {
            event(new CheckoutableCheckedOut($licenseSeat, $target, auth()->user(), request('notes'), [], 1, request()->boolean('sign_in_place')));

            return $target;
        }

        return false;
    }

    protected function checkoutToUser($licenseSeat)
    {
        // Fetch the target and set the license user
        if (is_null($target = User::find(request('assigned_user')))) {
            return redirect()->route('licenses.index')->with('error', trans('admin/licenses/message.user_does_not_exist'));
        }
        $licenseSeat->assigned_to = request('assigned_user');

        if ($licenseSeat->save()) {
            event(new CheckoutableCheckedOut($licenseSeat, $target, auth()->user(), request('notes'), [], 1, request()->boolean('sign_in_place')));

            return $target;
        }

        return false;
    }

    /**
     * Bulk checkin all license seats
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     *
     * @see LicenseCheckinController::create() method that provides the form view
     * @since [v6.1.1]
     *
     * @return RedirectResponse
     *
     * @throws AuthorizationException
     */
    public function bulkCheckout($licenseId)
    {

        Log::debug('Checking out '.$licenseId.' via bulk');
        $license = License::findOrFail($licenseId);
        $this->authorize('checkout', $license);

        if ($license->isInactive()) {
            return redirect()->back()->with('error', trans('admin/licenses/message.checkout.license_is_inactive'));
        }

        // If the license is valid, check that there is an available seat
        if ($license->availCount()->count() < 1) {
            return redirect()->back()->with('error', trans('admin/licenses/general.bulk.checkout_all.error_no_seats'));
        }

        $avail_count = $license->getAvailSeatsCountAttribute();

        $usersQuery = User::whereNull('deleted_at')->where('autoassign_licenses', '=', 1)->with('licenses');
        if (Setting::getSettings()->full_multiple_companies_support && $license->company_id) {
            // Filter to users pivoted to the license's company. The scalar
            // users.company_id column is deprecated; membership lives in the
            // company_user pivot only.
            $usersQuery->whereIn('users.id', function ($sub) use ($license) {
                $sub->select('user_id')
                    ->from('company_user')
                    ->where('company_id', $license->company_id);
            });
        }
        $users = $usersQuery->get();
        Log::debug($avail_count.' will be assigned');

        if ($users->count() > $avail_count) {
            Log::debug('You do not have enough free seats to complete this task, so we will check out as many as we can. ');
        }

        $assigned_count = 0;

        foreach ($users as $user) {

            // Check to make sure this user doesn't already have this license checked out to them
            if ($user->licenses->where('id', '=', $licenseId)->count()) {
                Log::debug($user->username.' already has this license checked out to them. Skipping... ');

                continue;
            }

            // Concurrency guard, same shape as Api\LicensesController::checkout.
            // freeSeat() without $lock=true returns the first-available
            // LicenseSeat unlocked; two racing bulkCheckout runs on the same
            // license could each grab the same seat, both call save(), and
            // both assigned_to writes land (second wins). The visible
            // assignment is fine but logCheckout below runs twice and the
            // decrement of $avail_count double-counts. Wrap each iteration
            // in a transaction with freeSeat(lock: true) so the seat is
            // pinned to this iteration until the save + log commit.
            $seatClaimed = DB::transaction(function () use ($license, $user, &$avail_count, &$assigned_count) {
                $licenseSeat = $license->freeSeat(lock: true);
                if (! $licenseSeat) {
                    return false;
                }
                $licenseSeat->assigned_to = $user->id;
                if (! $licenseSeat->save()) {
                    return false;
                }
                $avail_count--;
                $assigned_count++;
                $licenseSeat->logCheckout(trans('admin/licenses/general.bulk.checkout_all.log_msg'), $user);
                Log::debug('License '.$license->name.' seat '.$licenseSeat->id.' checked out to '.$user->username);

                return true;
            });

            if (! $seatClaimed) {
                Log::debug('No free seat available for '.$user->username.'. Skipping...');

                continue;
            }

            if ($avail_count == 0) {
                return redirect()->back()->with('warning', trans('admin/licenses/general.bulk.checkout_all.warn_not_enough_seats', ['count' => $assigned_count]));
            }
        }

        if ($assigned_count == 0) {
            return redirect()->back()->with('warning', trans('admin/licenses/general.bulk.checkout_all.warn_no_avail_users', ['count' => $assigned_count]));
        }

        return redirect()->back()->with('success', trans_choice('admin/licenses/general.bulk.checkout_all.success', 2, ['count' => $assigned_count]));

    }

    /**
     * Bulk-fulfill screen for a license's pending-request queue.
     * Mirrors AccessoryCheckoutController::bulkFulfillCreate - see
     * there for the design rationale. Qty on a license request is
     * the number of seats the requester asked for; the per-row
     * fulfillment claims that many free seats via freeSeat(lock:true)
     * in a loop.
     */
    public function bulkFulfillCreate(License $license)
    {
        $this->authorize('checkout', $license);

        if ($license->availCount()->count() < 1) {
            return redirect()->route('licenses.show', $license)
                ->with('error', trans('admin/licenses/message.checkout.not_enough_seats'));
        }

        if ($license->isInactive()) {
            return redirect()->route('licenses.show', $license)
                ->with('error', trans('admin/licenses/message.checkout.license_is_inactive'));
        }

        $pendingRequests = CheckoutRequest::pending()
            ->where('requestable_type', License::class)
            ->where('requestable_id', $license->id)
            ->with('user')
            ->orderBy('created_at')
            ->orderBy('id')
            ->get()
            ->filter(fn (CheckoutRequest $r) => $r->user !== null)
            ->values();

        if ($pendingRequests->isEmpty()) {
            return redirect()->route('licenses.show', $license)
                ->with('info', trans('admin/hardware/message.requests.no_active'));
        }

        return view('checkouts/fulfill-multiple', [
            'item' => $license,
            'pendingRequests' => $pendingRequests,
            'formRoute' => route('licenses.fulfill-requests.store', $license),
            'remaining' => (int) $license->availCount()->count(),
            // License requests are one-seat-per-requester by
            // convention (nobody realistically asks for 3 Photoshop
            // seats for themselves), so hide the qty input on each
            // row. The recipient-row component still emits a hidden
            // qty=1 field so the controller's per-row shape stays
            // uniform across every type.
            'hideQty' => true,
        ]);
    }

    /**
     * Iterate the ticked rows. For each, claim `qty` free seats
     * via freeSeat(lock: true) in its own transaction (partial-
     * success semantics matching the existing license bulk-
     * checkout-to-all-users pattern above). Fires CheckoutableCheckedOut
     * per seat so the state-machine listener closes the request.
     */
    public function bulkFulfillStore(Request $request, License $license): RedirectResponse
    {
        $this->authorize('checkout', $license);

        // Checkboxes post as enabled_requests[<request_id>]="1",
        // keyed by request id (unchecked boxes don't post at all).
        $enabledIds = collect(array_keys((array) $request->input('enabled_requests', [])))
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->unique()
            ->values();

        if ($enabledIds->isEmpty()) {
            return redirect()->route('licenses.fulfill-requests.create', $license)
                ->with('error', trans('admin/hardware/message.requests.no_selection'));
        }

        $userInputs = (array) $request->input('user_id', []);
        $noteInputs = (array) $request->input('notes', []);

        $requests = CheckoutRequest::pending()
            ->where('requestable_type', License::class)
            ->where('requestable_id', $license->id)
            ->whereIn('id', $enabledIds)
            ->with('user')
            ->get()
            ->keyBy('id');

        $adminUser = auth()->user();
        $fulfilledSeats = 0;
        $fulfilledRows = 0;
        $errors = [];

        foreach ($enabledIds as $requestId) {
            /** @var CheckoutRequest|null $checkoutRequest */
            $checkoutRequest = $requests->get($requestId);
            if (! $checkoutRequest) {
                $errors[] = trans('admin/hardware/message.requests.row_stale', ['id' => $requestId]);

                continue;
            }

            $targetUserId = (int) ($userInputs[$requestId] ?? $checkoutRequest->user_id);
            // License requests are one-seat-per-requester by
            // convention (see bulkFulfillCreate for the rationale).
            // Server-side pin to 1 regardless of what the form
            // sends so a hand-crafted POST can't over-allocate.
            $qty = 1;
            $note = $noteInputs[$requestId] ?? $checkoutRequest->notes;

            $targetUser = User::find($targetUserId);
            if (! $targetUser) {
                $errors[] = trans('admin/hardware/message.requests.row_user_missing', ['id' => $requestId]);

                continue;
            }

            if (! $license->canCheckoutTo($targetUser)) {
                $errors[] = trans('admin/hardware/message.requests.row_company_mismatch', [
                    'id' => $requestId,
                    'user' => $targetUser->display_name,
                ]);

                continue;
            }

            $claimed = 0;

            for ($i = 0; $i < $qty; $i++) {
                $seatClaimed = DB::transaction(function () use ($license, $targetUser, $note): ?LicenseSeat {
                    $seat = $license->freeSeat(lock: true);
                    if (! $seat) {
                        return null;
                    }
                    $seat->assigned_to = $targetUser->id;
                    $seat->created_by = auth()->id();
                    $seat->notes = $note;
                    if (! $seat->save()) {
                        return null;
                    }

                    return $seat;
                });

                if (! $seatClaimed) {
                    break;
                }

                try {
                    event(new CheckoutableCheckedOut(
                        $seatClaimed,
                        $targetUser,
                        $adminUser,
                        $note,
                        [],
                        1,
                        false,
                    ));
                } catch (\Throwable $e) {
                    Log::warning('Bulk-fulfill event dispatch failed for request '.$requestId.' seat '.$seatClaimed->id.': '.$e->getMessage());
                }

                $claimed++;
                $fulfilledSeats++;
            }

            if ($claimed === 0) {
                $errors[] = trans('admin/hardware/message.requests.row_over_allocated', ['id' => $requestId]);

                continue;
            }

            $fulfilledRows++;
        }

        $summary = trans('admin/hardware/message.requests.bulk_summary', [
            'fulfilled' => $fulfilledRows,
            'total' => $enabledIds->count(),
        ]);

        return redirect()->route('requests.index')
            ->with($fulfilledRows > 0 ? 'success' : 'warning', $summary)
            ->with('multi_error_messages', $errors);
    }
}
