<?php

namespace Tests\Feature\Licenses;

use App\Models\Actionlog;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\User;
use Tests\TestCase;

class LicenseSerialLeakTest extends TestCase
{
    private const SENTINEL = 'ARPC-SECRET-PRODUCT-KEY-DO-NOT-LEAK';

    private function seedCheckoutHistory(License $license): void
    {
        // Every license factory-create writes a "create" actionlog with the
        // license row as $log->item, so the history endpoint has content
        // immediately. Add an explicit checkout event so more than one row
        // exercises the transformer, and so log_meta scrubbing has a diff to
        // scrub on some rows.
        $log = new Actionlog;
        $log->item_type = License::class;
        $log->item_id = $license->id;
        $log->action_type = 'checkout';
        $log->target_type = User::class;
        $log->target_id = User::factory()->create()->id;
        $log->log_meta = json_encode([
            'serial' => ['old' => 'PREVIOUS-'.self::SENTINEL, 'new' => self::SENTINEL],
        ]);
        $log->save();
    }

    public function test_history_endpoint_masks_serial_for_users_without_view_keys(): void
    {
        $license = License::factory()->create(['serial' => self::SENTINEL]);
        $this->seedCheckoutHistory($license);

        $viewOnly = User::factory()->viewLicenses()->create();

        $response = $this->actingAsForApi($viewOnly)
            ->getJson(route('api.licenses.history', $license))
            ->assertOk();

        $body = $response->getContent();
        $this->assertStringNotContainsString(self::SENTINEL, $body);
        $this->assertStringContainsString(License::PRODUCT_KEY_MASK, $body);
    }

    public function test_history_endpoint_emits_real_serial_for_users_with_view_keys(): void
    {
        $license = License::factory()->create(['serial' => self::SENTINEL]);
        $this->seedCheckoutHistory($license);

        $keyHolder = User::factory()->viewLicenses()->viewKeysLicenses()->create();

        $response = $this->actingAsForApi($keyHolder)
            ->getJson(route('api.licenses.history', $license))
            ->assertOk();

        $this->assertStringContainsString(self::SENTINEL, $response->getContent());
    }

    public function test_history_endpoint_masks_serial_in_log_meta_diff_for_view_only(): void
    {
        $license = License::factory()->create(['serial' => self::SENTINEL]);
        $this->seedCheckoutHistory($license);

        $viewOnly = User::factory()->viewLicenses()->create();

        $response = $this->actingAsForApi($viewOnly)
            ->getJson(route('api.licenses.history', $license))
            ->assertOk();

        $body = $response->getContent();
        // Both old and new serial values in log_meta must be masked.
        $this->assertStringNotContainsString('PREVIOUS-'.self::SENTINEL, $body);
        $this->assertStringNotContainsString(self::SENTINEL, $body);
    }

    public function test_activity_report_api_masks_serial_for_users_without_view_keys(): void
    {
        $license = License::factory()->create(['serial' => self::SENTINEL]);
        LicenseSeat::factory()->for($license)->create();
        $this->seedCheckoutHistory($license);

        $viewOnly = User::factory()->canViewReports()->viewLicenses()->create();

        $response = $this->actingAsForApi($viewOnly)
            ->getJson(route('api.activity.index'))
            ->assertOk();

        $body = $response->getContent();
        $this->assertStringNotContainsString(self::SENTINEL, $body);
    }

    public function test_activity_report_csv_masks_serial_for_users_without_view_keys(): void
    {
        $license = License::factory()->create(['serial' => self::SENTINEL]);
        $this->seedCheckoutHistory($license);

        $viewOnly = User::factory()->canViewReports()->viewLicenses()->create();

        $this->actingAs($viewOnly)
            ->post(route('reports.activity.post'))
            ->assertOk()
            ->assertDontSeeTextInStreamedResponse(self::SENTINEL);
    }

    public function test_legacy_license_report_csv_masks_serial_for_users_without_view_keys(): void
    {
        $license = License::factory()->create([
            'name' => 'Definitely a real license',
            'serial' => self::SENTINEL,
        ]);

        $viewOnly = User::factory()->canViewReports()->viewLicenses()->create();

        $this->actingAs($viewOnly)
            ->get(route('reports/export/licenses'))
            ->assertOk()
            ->assertDontSeeTextInStreamedResponse(self::SENTINEL);
    }

    public function test_legacy_license_report_csv_emits_real_serial_for_users_with_view_keys(): void
    {
        $license = License::factory()->create([
            'name' => 'Definitely a real license',
            'serial' => self::SENTINEL,
        ]);

        $keyHolder = User::factory()->canViewReports()->viewLicenses()->viewKeysLicenses()->create();

        $this->actingAs($keyHolder)
            ->get(route('reports/export/licenses'))
            ->assertOk()
            ->assertSeeTextInStreamedResponse(self::SENTINEL);
    }
}
