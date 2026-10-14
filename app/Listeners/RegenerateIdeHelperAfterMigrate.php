<?php

namespace App\Listeners;

use Illuminate\Database\Events\MigrationsEnded;
use Illuminate\Support\Facades\Artisan;

/**
 * Regenerate the ide-helper model stub after each `php artisan migrate`
 * run so Larastan and the IDE see newly-added / renamed columns the
 * same day the migration lands. Production upgrades run
 * `migrate` without the dev dependency, so the class_exists guard
 * short-circuits before the artisan call that would otherwise throw
 * CommandNotFoundException and abort the upgrade.
 */
class RegenerateIdeHelperAfterMigrate
{
    public function handle(MigrationsEnded $event): void
    {
        if (! class_exists(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class)) {
            return;
        }

        try {
            Artisan::call('ide-helper:models', [
                '--write-mixin' => true,
                '--no-interaction' => true,
            ]);
        } catch (\Throwable) {
            // Dev tooling only. Never fail a migrate because the stub
            // couldn't be regenerated. Run manually to see errors.
        }
    }
}
