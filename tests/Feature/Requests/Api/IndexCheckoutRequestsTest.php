<?php

namespace Tests\Feature\Requests\Api;

use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\CheckoutRequest;
use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

/**
 * Coverage for GET /api/v1/requests, the admin-scoped list of open
 * checkout requests. Ships as the read half of #15541 so integrators
 * can build their own approval / fulfilment UIs. Approve/deny/fulfill
 * actions are intentionally not part of this endpoint.
 */
class IndexCheckoutRequestsTest extends TestCase
{
    public function test_requires_checkout_permission_on_at_least_one_type(): void
    {
        // The queue is polymorphic - a caller with checkout perm on
        // any of the five checkoutable types is a legitimate
        // consumer for that slice of the queue (admins who can
        // fulfill accessory requests but not asset requests still
        // get to see the accessory portion). A caller with no
        // checkout perm on any type (e.g. an ordinary requester)
        // can't see the queue at all.
        $user = User::factory()->create();

        $this->actingAsForApi($user)
            ->getJson(route('api.requests.index'))
            ->assertForbidden();
    }

    public function test_non_asset_checkout_permission_gets_past_the_endpoint_gate(): void
    {
        // A caller who can checkout accessories but not assets must
        // not be blocked at the endpoint gate. Pre-fix the gate was
        // Asset-only, so an accessories-only admin got 403 even
        // though the queue contains accessory rows they can fulfill.
        $accessoryAdmin = User::factory()->checkoutAccessories()->create();

        $this->actingAsForApi($accessoryAdmin)
            ->getJson(route('api.requests.index'))
            ->assertOk();
    }

    public function test_rows_are_filtered_by_per_type_checkout_permission(): void
    {
        // Complements the endpoint gate. A caller with only
        // checkoutAccessories sees accessory rows in the queue;
        // asset rows for the same user are filtered out because
        // they can't fulfill them.
        $accessoryAdmin = User::factory()->checkoutAccessories()->create();
        $requester = User::factory()->create();
        $accessory = \App\Models\Accessory::factory()->create();
        $asset = Asset::factory()->create();

        $accessoryRequest = CheckoutRequest::factory()->create([
            'user_id' => $requester->id,
            'requestable_id' => $accessory->id,
            'requestable_type' => \App\Models\Accessory::class,
        ]);
        $assetRequest = CheckoutRequest::factory()->create([
            'user_id' => $requester->id,
            'requestable_id' => $asset->id,
            'requestable_type' => Asset::class,
        ]);

        $ids = collect(
            $this->actingAsForApi($accessoryAdmin)
                ->getJson(route('api.requests.index'))
                ->assertOk()
                ->json('rows')
        )->pluck('id')->all();

        $this->assertContains($accessoryRequest->id, $ids);
        $this->assertNotContains($assetRequest->id, $ids);
    }

    public function test_assetmodel_rows_ride_on_asset_checkout_permission(): void
    {
        // AssetModel requests fulfill via an asset checkout, so the
        // permission gate for those rows uses checkoutAssets. A
        // caller with checkoutAssets should see both Asset and
        // AssetModel rows; a caller without any Asset permission
        // (but with, say, checkoutAccessories) should see neither.
        $assetAdmin = User::factory()->checkoutAssets()->create();
        $accessoryOnlyAdmin = User::factory()->checkoutAccessories()->create();
        $requester = User::factory()->create();
        $model = AssetModel::factory()->create();
        $modelRequest = CheckoutRequest::factory()->create([
            'user_id' => $requester->id,
            'requestable_id' => $model->id,
            'requestable_type' => AssetModel::class,
        ]);

        $adminIds = collect(
            $this->actingAsForApi($assetAdmin)
                ->getJson(route('api.requests.index'))
                ->assertOk()
                ->json('rows')
        )->pluck('id')->all();
        $this->assertContains($modelRequest->id, $adminIds);

        $accessoryIds = collect(
            $this->actingAsForApi($accessoryOnlyAdmin)
                ->getJson(route('api.requests.index'))
                ->assertOk()
                ->json('rows')
        )->pluck('id')->all();
        $this->assertNotContains($modelRequest->id, $accessoryIds);
    }

    public function test_returns_all_open_requests_for_a_privileged_user(): void
    {
        $admin = User::factory()->checkoutAssets()->create();
        $requesterA = User::factory()->create();
        $requesterB = User::factory()->create();

        $requestA = CheckoutRequest::factory()->create(['user_id' => $requesterA->id]);
        $requestB = CheckoutRequest::factory()->create(['user_id' => $requesterB->id]);

        $response = $this->actingAsForApi($admin)
            ->getJson(route('api.requests.index'))
            ->assertOk()
            ->assertJsonStructure(['total', 'rows']);

        $ids = collect($response->json('rows'))->pluck('id')->all();
        $this->assertContains($requestA->id, $ids);
        $this->assertContains($requestB->id, $ids);
    }

    public function test_does_not_return_canceled_requests(): void
    {
        // The canceled_at column is the current "closed" signal. Once
        // the v2 state machine ships this test's expectation should
        // expand to also exclude denied / expired / fulfilled rows,
        // but for today only canceled rows are filtered.
        $admin = User::factory()->checkoutAssets()->create();

        $open = CheckoutRequest::factory()->create();
        $canceled = CheckoutRequest::factory()->create(['canceled_at' => now()]);

        $ids = collect(
            $this->actingAsForApi($admin)
                ->getJson(route('api.requests.index'))
                ->assertOk()
                ->json('rows')
        )->pluck('id')->all();

        $this->assertContains($open->id, $ids);
        $this->assertNotContains($canceled->id, $ids);
    }

    public function test_response_row_includes_requester_and_requestable(): void
    {
        // Payload contract check: enough per-row context to render a
        // "who is requesting what" UI without a follow-up round trip.
        // The admin /hardware/requested page hydrates itself from these
        // fields, so the shape doubles as internal-UI plumbing.
        $admin = User::factory()->checkoutAssets()->create();
        $requester = User::factory()->create([
            'first_name' => 'Alex',
            'last_name' => 'Requester',
            'username' => 'alexreq',
            'email' => 'alex@example.org',
        ]);
        $asset = Asset::factory()->requestable()->create();

        $request = CheckoutRequest::factory()->create([
            'user_id' => $requester->id,
            'requestable_id' => $asset->id,
            'requestable_type' => Asset::class,
        ]);

        $rows = $this->actingAsForApi($admin)
            ->getJson(route('api.requests.index'))
            ->assertOk()
            ->json('rows');

        $row = collect($rows)->firstWhere('id', $request->id);

        $this->assertNotNull($row);
        $this->assertSame($requester->id, $row['user']['id']);
        $this->assertSame('alexreq', $row['user']['username']);
        $this->assertSame(route('users.show', $requester->id), $row['user']['url']);
        $this->assertFalse($row['user']['deleted']);
        $this->assertSame($asset->id, $row['requestable']['id']);
        $this->assertSame('Asset', $row['requestable']['type']);
        $this->assertSame(route('hardware.show', $asset->id), $row['requestable']['url']);
    }

    public function test_pending_requesters_column_lists_other_open_requesters_for_the_same_item(): void
    {
        // The admin queue's "Also Requested By" column reads this
        // field via ordersSummaryFormatter. Excluding the current
        // row's requester keeps the column meaning "who ELSE is
        // waiting on this item", so a solo request renders empty.
        $admin = User::factory()->checkoutAssets()->create();

        $asset = Asset::factory()->requestable()->create();
        $alone = User::factory()->create(['first_name' => 'Alone', 'last_name' => 'Requester']);
        $alsoA = User::factory()->create(['first_name' => 'Alsoa', 'last_name' => 'Requester']);
        $alsoB = User::factory()->create(['first_name' => 'Alsob', 'last_name' => 'Requester']);

        $soloAsset = Asset::factory()->requestable()->create();
        $soloRequest = CheckoutRequest::factory()->create([
            'user_id' => $alone->id,
            'requestable_id' => $soloAsset->id,
            'requestable_type' => Asset::class,
        ]);

        $primary = CheckoutRequest::factory()->create([
            'user_id' => $alone->id,
            'requestable_id' => $asset->id,
            'requestable_type' => Asset::class,
        ]);
        CheckoutRequest::factory()->create([
            'user_id' => $alsoA->id,
            'requestable_id' => $asset->id,
            'requestable_type' => Asset::class,
        ]);
        CheckoutRequest::factory()->create([
            'user_id' => $alsoB->id,
            'requestable_id' => $asset->id,
            'requestable_type' => Asset::class,
        ]);

        $rows = collect(
            $this->actingAsForApi($admin)
                ->getJson(route('api.requests.index'))
                ->assertOk()
                ->json('rows')
        )->keyBy('id');

        // Solo request: only requester on that item -> empty list.
        $this->assertSame([], $rows[$soloRequest->id]['pending_requesters']);

        // Contested asset: two other users besides the row's own
        // requester should be surfaced, and the row's own requester
        // must NOT appear (the sibling "Requested By" column already
        // shows them).
        $others = $rows[$primary->id]['pending_requesters'];
        $this->assertCount(2, $others);
        $this->assertNotContains($alone->display_name, $others);
        $this->assertContains($alsoA->display_name, $others);
        $this->assertContains($alsoB->display_name, $others);
    }

    public function test_pending_requesters_excludes_canceled_rows(): void
    {
        // Canceled requests must not show up in the "also requested
        // by" list - the column is for OPEN requests only.
        $admin = User::factory()->checkoutAssets()->create();
        $asset = Asset::factory()->requestable()->create();

        $primaryRequester = User::factory()->create(['first_name' => 'Primary', 'last_name' => 'Requester']);
        $canceledRequester = User::factory()->create(['first_name' => 'Cancelled', 'last_name' => 'User']);

        $primary = CheckoutRequest::factory()->create([
            'user_id' => $primaryRequester->id,
            'requestable_id' => $asset->id,
            'requestable_type' => Asset::class,
        ]);
        CheckoutRequest::factory()->create([
            'user_id' => $canceledRequester->id,
            'requestable_id' => $asset->id,
            'requestable_type' => Asset::class,
            'canceled_at' => now(),
        ]);

        $rows = collect(
            $this->actingAsForApi($admin)
                ->getJson(route('api.requests.index'))
                ->assertOk()
                ->json('rows')
        )->keyBy('id');

        $this->assertSame([], $rows[$primary->id]['pending_requesters']);
    }

    public function test_row_exposes_reservation_window_qty_and_notes_when_set(): void
    {
        // Fields feed the /requests page columns (quantity, remaining,
        // start_date, end_date, notes). All nullable, so a bare
        // "just get me one whenever" request stays clean.
        // Admin needs checkoutConsumables because the fixture
        // request targets a Consumable and the per-row checkout-
        // permission filter in the endpoint drops rows for types
        // the caller can't fulfill.
        $admin = User::factory()->checkoutConsumables()->create();
        $consumable = \App\Models\Consumable::factory()->create(['qty' => 20, 'requestable' => true]);
        $request = CheckoutRequest::factory()->create([
            'requestable_id' => $consumable->id,
            'requestable_type' => \App\Models\Consumable::class,
            'quantity' => 4,
            'start_date' => '2026-09-01',
            'end_date' => '2026-09-05',
            'notes' => 'Q3 offsite kit',
        ]);

        $row = collect(
            $this->actingAsForApi($admin)
                ->getJson(route('api.requests.index'))
                ->assertOk()
                ->json('rows')
        )->firstWhere('id', $request->id);

        $this->assertNotNull($row);
        $this->assertSame(4, $row['quantity']);
        $this->assertSame(20, $row['requestable']['remaining']);
        $this->assertNotNull($row['start_date']);
        $this->assertNotNull($row['end_date']);
        $this->assertSame('Q3 offsite kit', $row['notes']);
    }

    public function test_row_leaves_reservation_fields_null_when_unset(): void
    {
        $admin = User::factory()->checkoutAssets()->create();
        $request = CheckoutRequest::factory()->create();

        $row = collect(
            $this->actingAsForApi($admin)
                ->getJson(route('api.requests.index'))
                ->assertOk()
                ->json('rows')
        )->firstWhere('id', $request->id);

        $this->assertNotNull($row);
        $this->assertNull($row['start_date']);
        $this->assertNull($row['end_date']);
        $this->assertNull($row['notes']);
    }

    public function test_asset_requestable_exposes_assigned_flag_and_action_hints(): void
    {
        // The Blade page renders "Checkout" vs "Checkin" based on
        // whether the asset is currently checked out. The transformer
        // surfaces that as requestable.assigned + available_actions,
        // so the JS formatter can pick a button without another lookup.
        $admin = User::factory()->checkoutAssets()->create();

        $availableAsset = Asset::factory()->requestable()->create(['assigned_to' => null]);
        $availableRequest = CheckoutRequest::factory()->create([
            'requestable_id' => $availableAsset->id,
            'requestable_type' => Asset::class,
        ]);

        $assignedAsset = Asset::factory()->assignedToUser()->create();
        $assignedRequest = CheckoutRequest::factory()->create([
            'requestable_id' => $assignedAsset->id,
            'requestable_type' => Asset::class,
        ]);

        $rows = collect(
            $this->actingAsForApi($admin)
                ->getJson(route('api.requests.index'))
                ->assertOk()
                ->json('rows')
        )->keyBy('id');

        $this->assertFalse($rows[$availableRequest->id]['requestable']['assigned']);
        $this->assertTrue($rows[$availableRequest->id]['available_actions']['checkout']);
        $this->assertFalse($rows[$availableRequest->id]['available_actions']['checkin']);

        $this->assertTrue($rows[$assignedRequest->id]['requestable']['assigned']);
        $this->assertFalse($rows[$assignedRequest->id]['available_actions']['checkout']);
        $this->assertTrue($rows[$assignedRequest->id]['available_actions']['checkin']);
    }

    public function test_user_id_filter_limits_results_to_that_requesters_rows(): void
    {
        $admin = User::factory()->checkoutAssets()->create();
        $requesterA = User::factory()->create();
        $requesterB = User::factory()->create();

        $mine = CheckoutRequest::factory()->create(['user_id' => $requesterA->id]);
        $theirs = CheckoutRequest::factory()->create(['user_id' => $requesterB->id]);

        $ids = collect(
            $this->actingAsForApi($admin)
                ->getJson(route('api.requests.index', ['user_id' => $requesterA->id]))
                ->assertOk()
                ->json('rows')
        )->pluck('id')->all();

        $this->assertContains($mine->id, $ids);
        $this->assertNotContains($theirs->id, $ids);
    }

    public function test_fmcs_hides_requests_for_items_the_admin_cannot_see(): void
    {
        // Non-superuser admin in company A must not see requests
        // targeting company B's assets. Superuser bypass is covered
        // separately below.
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $adminInA = $companyA->users()->save(User::factory()->checkoutAssets()->make());
        $requesterInA = $companyA->users()->save(User::factory()->make());
        $requesterInB = $companyB->users()->save(User::factory()->make());

        $assetInA = Asset::factory()->for($companyA)->requestable()->create();
        $assetInB = Asset::factory()->for($companyB)->requestable()->create();

        $requestForA = CheckoutRequest::factory()->create([
            'user_id' => $requesterInA->id,
            'requestable_id' => $assetInA->id,
            'requestable_type' => Asset::class,
        ]);
        $requestForB = CheckoutRequest::factory()->create([
            'user_id' => $requesterInB->id,
            'requestable_id' => $assetInB->id,
            'requestable_type' => Asset::class,
        ]);

        $this->settings->enableMultipleFullCompanySupport();

        $ids = collect(
            $this->actingAsForApi($adminInA)
                ->getJson(route('api.requests.index'))
                ->assertOk()
                ->json('rows')
        )->pluck('id')->all();

        $this->assertContains($requestForA->id, $ids);
        $this->assertNotContains($requestForB->id, $ids);
    }

    public function test_fmcs_hides_assetmodel_parent_requests_filed_by_other_tenants(): void
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $adminInA = $companyA->users()->save(User::factory()->checkoutAssets()->make());
        $requesterInB = $companyB->users()->save(User::factory()->make());

        $sharedModel = AssetModel::factory()->create();

        $foreignRequest = CheckoutRequest::factory()->create([
            'user_id' => $requesterInB->id,
            'requestable_id' => $sharedModel->id,
            'requestable_type' => AssetModel::class,
            'notes' => 'CAND15-CROSS-TENANT-NOTE',
        ]);

        $this->settings->enableMultipleFullCompanySupport();

        $response = $this->actingAsForApi($adminInA)
            ->getJson(route('api.requests.index'))
            ->assertOk();

        $ids = collect($response->json('rows'))->pluck('id')->all();
        $this->assertNotContains($foreignRequest->id, $ids, 'Company A admin must not see Company B user\'s AssetModel request.');

        // Confirm the attacker-visible note never leaks into the
        // response body either, independent of the id check.
        $this->assertStringNotContainsString('CAND15-CROSS-TENANT-NOTE', $response->getContent());
    }

    public function test_fmcs_floater_mode_surfaces_null_company_items_to_scoped_admins(): void
    {
        // Floater mode intentionally makes company_id=null items
        // visible across every company under FMCS. The old
        // /hardware/requested page relied on Company::isCurrentUserHasAccess
        // (which respects floater); this test pins that the API-based
        // migration still honors it.
        [$companyA] = Company::factory()->count(2)->create();

        $adminInA = $companyA->users()->save(User::factory()->checkoutAssets()->make());
        $floaterAsset = Asset::factory()->create(['company_id' => null]);
        $floaterRequest = CheckoutRequest::factory()->create([
            'requestable_id' => $floaterAsset->id,
            'requestable_type' => Asset::class,
        ]);

        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->enableFloaterMode();

        $ids = collect(
            $this->actingAsForApi($adminInA)
                ->getJson(route('api.requests.index'))
                ->assertOk()
                ->json('rows')
        )->pluck('id')->all();

        $this->assertContains($floaterRequest->id, $ids);
    }

    public function test_fmcs_superuser_sees_every_companys_requests(): void
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $superuser = User::factory()->superuser()->create();
        $requesterInA = $companyA->users()->save(User::factory()->make());
        $requesterInB = $companyB->users()->save(User::factory()->make());

        $requestForA = CheckoutRequest::factory()->create(['user_id' => $requesterInA->id]);
        $requestForB = CheckoutRequest::factory()->create(['user_id' => $requesterInB->id]);

        $this->settings->enableMultipleFullCompanySupport();

        $ids = collect(
            $this->actingAsForApi($superuser)
                ->getJson(route('api.requests.index'))
                ->assertOk()
                ->json('rows')
        )->pluck('id')->all();

        $this->assertContains($requestForA->id, $ids);
        $this->assertContains($requestForB->id, $ids);
    }

    public function test_search_matches_across_requester_and_requestable_and_notes(): void
    {
        // bs-table on /requests forwards its search-box value as
        // ?search=. The endpoint filters in-PHP across the fields
        // the presenter marks searchable so the search box isn't
        // silently a no-op. Two request rows share a requestable;
        // the search should isolate them by requester username,
        // requestable name, and free-text notes independently.
        $admin = User::factory()->checkoutAssets()->create();
        $alice = User::factory()->create(['username' => 'alice-search-fixture']);
        $bob = User::factory()->create(['username' => 'bob-search-fixture']);
        $asset = Asset::factory()->create(['name' => 'SearchFixtureLaptop']);

        $requestFromAlice = CheckoutRequest::factory()->create([
            'user_id' => $alice->id,
            'requestable_id' => $asset->id,
            'requestable_type' => Asset::class,
            'notes' => 'quarterly-offsite',
        ]);
        $requestFromBob = CheckoutRequest::factory()->create([
            'user_id' => $bob->id,
            'requestable_id' => $asset->id,
            'requestable_type' => Asset::class,
            'notes' => 'client-demo',
        ]);

        // By requester username: only Alice's row surfaces.
        $ids = collect(
            $this->actingAsForApi($admin)
                ->getJson(route('api.requests.index', ['search' => 'alice-search-fixture']))
                ->assertOk()
                ->json('rows')
        )->pluck('id')->all();
        $this->assertContains($requestFromAlice->id, $ids);
        $this->assertNotContains($requestFromBob->id, $ids);

        // By notes: only Bob's row surfaces.
        $ids = collect(
            $this->actingAsForApi($admin)
                ->getJson(route('api.requests.index', ['search' => 'client-demo']))
                ->assertOk()
                ->json('rows')
        )->pluck('id')->all();
        $this->assertContains($requestFromBob->id, $ids);
        $this->assertNotContains($requestFromAlice->id, $ids);

        // By requestable name: both rows surface (they target the
        // same asset).
        $ids = collect(
            $this->actingAsForApi($admin)
                ->getJson(route('api.requests.index', ['search' => 'SearchFixtureLaptop']))
                ->assertOk()
                ->json('rows')
        )->pluck('id')->all();
        $this->assertContains($requestFromAlice->id, $ids);
        $this->assertContains($requestFromBob->id, $ids);
    }
}
