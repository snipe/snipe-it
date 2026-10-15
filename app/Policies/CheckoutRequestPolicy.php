<?php

namespace App\Policies;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\CheckoutRequest;
use App\Models\Company;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

/**
 * Policy for CheckoutRequest rows. The one non-obvious surface today
 * is calendar events: CalendarEventsController's filterAuthorizedRows
 * gates every event through `$viewer->can('view', $source)` before it
 * ships to the browser, so without an explicit view() method here
 * CheckoutRequest calendar events silently drop off the calendar
 * (Laravel's default policy resolution returns false for unregistered
 * (model, ability) pairs).
 *
 * Superusers and admins are handled globally in AuthServiceProvider::boot().
 */
final class CheckoutRequestPolicy
{
    use HandlesAuthorization;

    /**
     * A user may see a CheckoutRequest row if they are the requester
     * themselves OR they hold checkout permission on the underlying
     * requestable's type AND can reach the requestable under FMCS.
     * Matches the per-row filter Api\CheckoutRequest::index applies
     * to the /requests admin queue, so calendar events, notification
     * targets, and the admin queue all answer the same question the
     * same way.
     *
     * AssetModel requests fulfill via Asset checkout, so the type gate
     * for a model request rides on the Asset checkout permission
     * (matches the same mapping in the /requests API filter).
     */
    public function view(User $user, ?CheckoutRequest $request = null): bool
    {
        // Class-level probe (CalendarEventsController::authorizeAnySource
        // walks the source model list and asks `can('view', Model::class)`
        // before hitting any actual row). Answer "yes" so the calendar
        // endpoint doesn't 403 a viewer whose only calendar-relevant
        // permission is checkout on some requestable type; per-row
        // filterAuthorizedRows re-asks with the concrete instance and
        // applies the FMCS + checkout gate below.
        if ($request === null) {
            return Gate::allows('canCheckoutAtLeastOneItemType');
        }

        if ($request->user_id === $user->id) {
            return true;
        }

        $requestable = $request->requestable;
        if ($requestable === null) {
            return false;
        }

        if (! Company::isCurrentUserHasAccess($requestable)) {
            return false;
        }

        $permissionType = $request->requestable_type === AssetModel::class
            ? Asset::class
            : $request->requestable_type;

        return Gate::allows('checkout', $permissionType);
    }
}
