<?php

namespace Tests\Unit\Models;

use App\Exceptions\MissingLogTarget;
use App\Models\Asset;
use App\Models\User;
use Tests\TestCase;

/**
 * The Loggable trait provides the logCheckout() / logCheckin() helpers used by
 * every checkout-capable model. logCheckout() throws MissingLogTarget when the
 * caller can't hand it a valid target so callers wrapping their work in a
 * DB::transaction can catch it specifically, roll back cleanly, and return a
 * proper 4xx response body instead of leaking an unhandled 500.
 */
class LoggableTest extends TestCase
{
    public function test_log_checkout_throws_missing_log_target_when_target_is_missing()
    {
        $this->actingAs(User::factory()->create());
        $asset = Asset::factory()->create();

        $this->expectException(MissingLogTarget::class);

        $asset->logCheckout('some note', null);
    }

    public function test_log_checkout_throws_missing_log_target_when_target_has_no_id()
    {
        $this->actingAs(User::factory()->create());
        $asset = Asset::factory()->create();

        // Fresh, unsaved model: a real object but its id is null, so the
        // shape check should refuse to log against it.
        $badTarget = new User;

        $this->expectException(MissingLogTarget::class);

        $asset->logCheckout('some note', $badTarget);
    }
}
