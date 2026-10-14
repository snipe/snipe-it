<?php

namespace Tests\Feature\Requests\Ui;

use App\Models\Asset;
use App\Models\CheckoutRequest;
use App\Models\Company;
use App\Models\User;
use Tests\TestCase;

/**
 * Coverage for the /hardware/requested bulk-cancel action. The
 * endpoint accepts ids[] from the queue-page checkbox selection and
 * cancels each open row the caller can see. Idempotent for rows
 * that are already canceled, missing requestables, or FMCS-scoped
 * out from under the caller.
 */
class BulkCancelRequestTest extends TestCase
{
    public function test_requires_view_assets_permission(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('requests.bulk-cancel'), ['ids' => [1]])
            ->assertForbidden();
    }

    public function test_empty_selection_flashes_an_error(): void
    {
        $this->actingAs(User::factory()->checkoutAssets()->create())
            ->post(route('requests.bulk-cancel'), ['ids' => []])
            ->assertRedirectToRoute('requests.index')
            ->assertSessionHas('error');
    }

    public function test_cancels_every_selected_open_request(): void
    {
        $admin = User::factory()->checkoutAssets()->create();
        $requests = CheckoutRequest::factory()->count(3)->create();

        $this->actingAs($admin)
            ->post(route('requests.bulk-cancel'), [
                'ids' => $requests->pluck('id')->all(),
            ])
            ->assertRedirectToRoute('requests.index')
            ->assertSessionHas('success');

        foreach ($requests as $request) {
            $this->assertNotNull($request->fresh()->canceled_at, "Request {$request->id} should have been canceled.");
        }
    }

    public function test_already_canceled_rows_are_silently_skipped(): void
    {
        // The action fires from a checkbox selection where any subset
        // can go stale between "load table" and "click Go". Rows that
        // are already canceled don't count toward the summary but
        // don't trigger an error either.
        $admin = User::factory()->checkoutAssets()->create();
        $canceled = CheckoutRequest::factory()->create(['canceled_at' => now()->subMinute()]);

        $this->actingAs($admin)
            ->post(route('requests.bulk-cancel'), [
                'ids' => [$canceled->id],
            ])
            ->assertRedirectToRoute('requests.index')
            ->assertSessionHas('warning');
    }

    public function test_fmcs_prevents_admin_from_canceling_requests_for_other_companies(): void
    {
        // Non-superuser admin in company A must not be able to bulk-
        // cancel a request against a company B asset even if they
        // craft the id into the payload directly. Superuser bypass
        // is exercised in test_superuser_can_cancel_across_companies.
        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $adminInA = $companyA->users()->save(User::factory()->checkoutAssets()->make());
        $assetInB = Asset::factory()->for($companyB)->requestable()->create();
        $requestInB = CheckoutRequest::factory()->create([
            'requestable_id' => $assetInB->id,
            'requestable_type' => Asset::class,
        ]);

        $this->actingAs($adminInA)
            ->post(route('requests.bulk-cancel'), [
                'ids' => [$requestInB->id],
            ])
            ->assertRedirectToRoute('requests.index');

        $this->assertNull(
            $requestInB->fresh()->canceled_at,
            'Cross-company request must not be canceled by an admin who cannot see it.'
        );
    }

    public function test_fmcs_prevents_bulk_cancel_of_assetmodel_parent_requests_filed_by_other_tenants(): void
    {
        // Regression for CAND-15 (Wojciech Ciemski). AssetModel has no
        // company_id, so Company::isCurrentUserHasAccess on the
        // requestable short-circuits to true for every actor. A
        // non-superuser in Company A could bulk-cancel a Company B
        // user's pending AssetModel-parent request. Fix adds a second
        // isCurrentUserHasAccess check on the requesting user, which
        // routes through User's CompanyableScope.
        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $adminInA = $companyA->users()->save(User::factory()->checkoutAssets()->make());
        $requesterInB = $companyB->users()->save(User::factory()->make());

        $sharedModel = \App\Models\AssetModel::factory()->create();

        $foreignRequest = CheckoutRequest::factory()->create([
            'user_id' => $requesterInB->id,
            'requestable_id' => $sharedModel->id,
            'requestable_type' => \App\Models\AssetModel::class,
        ]);

        $this->actingAs($adminInA)
            ->post(route('requests.bulk-cancel'), [
                'ids' => [$foreignRequest->id],
            ])
            ->assertRedirectToRoute('requests.index');

        $this->assertNull(
            $foreignRequest->fresh()->canceled_at,
            'Cross-tenant AssetModel-parent request must not be canceled by Company A admin.'
        );
    }

    public function test_superuser_can_cancel_across_companies(): void
    {
        $this->settings->enableMultipleFullCompanySupport();

        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $superuser = User::factory()->superuser()->create();
        $assetInA = Asset::factory()->for($companyA)->requestable()->create();
        $assetInB = Asset::factory()->for($companyB)->requestable()->create();

        $requestA = CheckoutRequest::factory()->create([
            'requestable_id' => $assetInA->id,
            'requestable_type' => Asset::class,
        ]);
        $requestB = CheckoutRequest::factory()->create([
            'requestable_id' => $assetInB->id,
            'requestable_type' => Asset::class,
        ]);

        $this->actingAs($superuser)
            ->post(route('requests.bulk-cancel'), [
                'ids' => [$requestA->id, $requestB->id],
            ])
            ->assertRedirectToRoute('requests.index')
            ->assertSessionHas('success');

        $this->assertNotNull($requestA->fresh()->canceled_at);
        $this->assertNotNull($requestB->fresh()->canceled_at);
    }
}
