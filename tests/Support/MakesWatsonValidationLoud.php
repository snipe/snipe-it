<?php

namespace Tests\Support;

use Illuminate\Support\Facades\Event;

/**
 * Watson's ValidatingTrait silently returns false from save() when
 * validation fails, and Laravel's Factory::create() does not check that
 * return. A factory whose save quietly failed hands back a model with no
 * primary key, and the test crashes hundreds of lines later with a
 * mysterious "missing route parameter" or "unknown attribute" error.
 *
 * Opt in on a specific test class when factory ordering under strict
 * FMCS (or any similarly restrictive setting) is likely to bite, so the
 * failure surfaces at the exact save() with the failing field named.
 *
 * Not applied globally: enabling this suite-wide would break tests that
 * intentionally rely on silent-false save (e.g. asset_tag collision
 * regression tests) and tests that route Watson exceptions through the
 * app's normal error-response path (importers, some FMCS scoping paths).
 */
trait MakesWatsonValidationLoud
{
    protected function setUpMakesWatsonValidationLoud(): void
    {
        Event::listen('eloquent.validated: *', function () {
            [, $payload] = func_get_args();
            [$model, $status] = $payload;

            if ($status === 'failed' && method_exists($model, 'throwValidationException')) {
                $model->throwValidationException();
            }
        });
    }
}
