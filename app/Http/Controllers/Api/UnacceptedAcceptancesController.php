<?php

namespace App\Http\Controllers\Api;

use App\Console\Commands\SendAcceptanceReminder;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\AcceptancesTransformer;
use App\Models\Accessory;
use App\Models\Asset;
use App\Models\CheckoutAcceptance;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Notifications\UnacceptedAssetReminderNotification;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

/**
 * JSON endpoint powering /unaccepted-acceptances (via
 * UnacceptedAcceptancesController's Blade view).
 *
 * Scoping is DB-level, not post-hoc: whereHasMorph narrows to the
 * checkoutable types the caller can view AND lets each type's own
 * CompanyableScope / CompanyableChildScope apply its FMCS + location
 * filtering during the join. The paginated count and the page rows
 * reflect the same viewer-permissioned set, so no cross-company
 * totals leak via `total`.
 */
class UnacceptedAcceptancesController extends Controller
{
    public function index(Request $request): array
    {
        $this->authorize('canCheckoutAtLeastOneItemType');

        // Pre-filter the morph types to just those this caller can
        // view. Types they can't view are excluded from the query
        // entirely, preventing even a type-shape leak.
        $viewableTypes = array_filter(
            [Asset::class, LicenseSeat::class, Accessory::class, Component::class, Consumable::class],
            fn (string $type) => Gate::allows('view', $type === LicenseSeat::class ? License::class : $type),
        );

        if ($viewableTypes === []) {
            return (new AcceptancesTransformer)->transformAcceptances(collect(), 0);
        }

        $query = CheckoutAcceptance::pending()
            ->with([
                'checkoutable' => function (MorphTo $morphTo) {
                    $morphTo->withTrashed()->morphWith([
                        Asset::class => ['model.category', 'assignedTo', 'company'],
                        Accessory::class => ['category', 'checkouts', 'company'],
                        LicenseSeat::class => ['user', 'license.company', 'license.category'],
                        Component::class => ['assignedTo', 'category', 'company'],
                        Consumable::class => ['category', 'company'],
                    ]);
                },
                'assignedTo' => fn ($q) => $q->withTrashed(),
            ])
            ->whereHasMorph('checkoutable', $viewableTypes)
            ->orderByDesc('checkout_acceptances.created_at');

        if ($request->boolean('deleted')) {
            // "Show deleted" toggle. Flips the default pending-only
            // scope to deleted-only (not with-trashed) so the view
            // actually surfaces the stale rows for audit without
            // mixing them in with the live pending set.
            $query->onlyTrashed();
        }

        $acceptances = $query->get()
            ->filter(fn (CheckoutAcceptance $acceptance) => $acceptance->checkoutable !== null)
            ->values();

        // Pagination lives in PHP because bs-table-client-side wants
        // the whole page body in one fetch anyway (data-side-pagination
        // was "client" on the old /reports/unaccepted_assets view too).
        $total = $acceptances->count();
        $offset = max(0, (int) $request->input('offset', 0));
        $limit = min(max(1, (int) $request->input('limit', $total ?: 1)), 500);
        $page = $acceptances->slice($offset, $limit)->values();

        return (new AcceptancesTransformer)->transformAcceptances($page, $total);
    }

    /**
     * Send reminder emails to users with unaccepted items. No `ids`
     * supplied: delegates to snipeit:acceptance-reminder so the
     * send-all shape is identical to the console command
     */
    public function sendReminders(Request $request): JsonResponse
    {
        $this->authorize('canCheckoutAtLeastOneItemType');

        $ids = array_values(array_unique(array_filter(array_map('intval', (array) $request->input('ids', [])))));

        if ($ids === []) {
            $result = SendAcceptanceReminder::dispatchAll();

            return response()->json(
                Helper::formatStandardApiResponse(
                    'success',
                    [
                        'mode' => 'all',
                        'sent' => $result['sent'],
                        'skipped' => [
                            'failed' => $result['failed'],
                            'no_email' => count($result['no_email']),
                        ],
                    ],
                    trans_choice('admin/reports/general.reminder_sent_count', $result['sent'], ['count' => $result['sent']]),
                ),
            );
        }

        $acceptancesByAssignee = CheckoutAcceptance::pending()
            ->whereIn('id', $ids)
            ->with(['assignedTo' => fn ($q) => $q->withTrashed()])
            ->get()
            ->filter(fn (CheckoutAcceptance $a) => $a->assignedTo && $a->isAccessibleToCurrentUser())
            ->groupBy(fn (CheckoutAcceptance $a) => $a->assignedTo->id);

        $sent = 0;
        $skipped = [
            'no_email' => 0,
            'none_pending' => 0,
        ];
        // Any id in the request that didn't survive the pending +
        // FMCS filter above falls out as not_found. Tracked here so
        // the response can tell the caller how many of their ids
        // never reached the dispatch loop.
        $notFound = count($ids) - $acceptancesByAssignee->sum(fn ($g) => $g->count());

        foreach ($acceptancesByAssignee as $group) {
            /** @var CheckoutAcceptance $first */
            $first = $group->first();
            $assignee = $first->assignedTo;

            if (empty($assignee->email) || $assignee->activated == '0') {
                $skipped['no_email']++;

                continue;
            }

            $pending = $assignee->getAssignedItemsWithPendingAcceptance();
            if ($pending->isEmpty()) {
                $skipped['none_pending']++;

                continue;
            }

            $assignee->notify(new UnacceptedAssetReminderNotification($first, $pending->count()));
            $sent++;
        }

        return response()->json(
            Helper::formatStandardApiResponse(
                'success',
                [
                    'mode' => 'ids',
                    'sent' => $sent,
                    'skipped' => $skipped + ['not_found_or_fmcs' => max(0, $notFound)],
                ],
                trans_choice('admin/reports/general.reminder_sent_count', $sent, ['count' => $sent]),
            ),
        );
    }
}
