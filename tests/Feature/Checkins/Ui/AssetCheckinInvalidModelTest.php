<?php

namespace Tests\Feature\Checkins\Ui;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Regression for the "GET /hardware/{id}/checkin bounces to
 * hardware.edit with a generic 'check the form for errors' but
 * nothing visibly highlighted" report. AssetCheckinController::create
 * runs $asset->isInvalid() before rendering the checkin form. If a
 * model-level validation rule fails on a field the user can't (or
 * doesn't) see, they used to get only the generic top-of-page alert
 * with no indication of which field failed.
 *
 * The fix flashes the specific validation messages via the shared
 * multi_error_messages session key so notifications.blade.php
 * surfaces them as a bullet list separate from the generic alert.
 * Inline .has-error styling on visible fields still fires from
 * withErrors($errors); those aren't duplicated in the multi_error
 * alert because they're already covered inline. The multi_error
 * alert is essential for the off-form / off-screen case.
 */
class AssetCheckinInvalidModelTest extends TestCase
{
    public function test_checkin_get_flashes_specific_errors_when_asset_fails_model_validation(): void
    {
        $asset = Asset::factory()->assignedToUser()->create();

        // Bypass model events + validation to write an invalid value
        // directly. purchase_cost has a `gte:0` rule (Asset::$rules),
        // so a negative value trips isInvalid() at checkin time.
        // Using DB::update rather than $asset->forceSave() keeps us
        // out of the observer stack entirely.
        DB::table('assets')->where('id', $asset->id)->update(['purchase_cost' => -1]);

        $response = $this->actingAs(User::factory()->superuser()->create())
            ->get(route('hardware.checkin.create', $asset));

        $response->assertStatus(302);
        $response->assertRedirect(route('hardware.edit', $asset));

        // The generic errors bag is still populated so inline
        // .has-error styling fires on any visible fields.
        $response->assertSessionHasErrors('purchase_cost');

        // AND the specific message is flashed so notifications.blade.php
        // renders it in the top alert, catching the off-form case.
        $response->assertSessionHas('multi_error_messages', function ($messages) {
            return is_array($messages)
                && count($messages) > 0
                && collect($messages)->contains(fn ($msg) => str_contains(strtolower($msg), 'purchase cost'));
        });
    }

    public function test_multi_error_messages_alert_hides_show_more_when_three_or_fewer(): void
    {
        // Companion regression: notifications.blade.php used to render
        // an empty <details><summary>Show all</summary> block for any
        // multi_error_messages payload, even when there were 3 or
        // fewer items and nothing to disclose.
        session()->flash('multi_error_messages', ['one', 'two', 'three']);

        $response = $this->actingAs(User::factory()->superuser()->create())
            ->get(route('hardware.index'));

        $content = $response->getContent();
        $this->assertStringContainsString('<li>one</li>', $content);
        $this->assertStringContainsString('<li>three</li>', $content);
        $this->assertStringNotContainsString('<summary>', $content, 'Show-more disclosure must not render for 3 or fewer messages.');
    }

    public function test_multi_error_messages_alert_shows_show_more_when_more_than_three(): void
    {
        session()->flash('multi_error_messages', ['one', 'two', 'three', 'four']);

        $response = $this->actingAs(User::factory()->superuser()->create())
            ->get(route('hardware.index'));

        $content = $response->getContent();
        $this->assertStringContainsString('<summary>', $content);
        $this->assertStringContainsString('<li>four</li>', $content);
    }
}
