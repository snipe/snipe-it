<?php

namespace App\Providers;

use App\Models\Accessory;
use Carbon\Carbon;
use App\Models\Asset;
use App\Models\Location;
use App\Models\Component;
use App\Models\Category;
use App\Models\Consumable;
use App\Models\License;
use App\Models\User;
use App\Policies\AccessoryPolicy;
use App\Policies\AssetPolicy;
use App\Policies\ComponentPolicy;
use App\Policies\ConsumablePolicy;
use App\Policies\LicensePolicy;
use App\Policies\LocationPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Asset::class => AssetPolicy::class,
        Accessory::class => AccessoryPolicy::class,
        Component::class => ComponentPolicy::class,
        Consumable::class => ConsumablePolicy::class,
        License::class => LicensePolicy::class,
        User::class => UserPolicy::class,
        Location::class => LocationPolicy::class,
        Category::class => CategoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {

        $this->commands([
            \Laravel\Passport\Console\InstallCommand::class,
            \Laravel\Passport\Console\ClientCommand::class,
            \Laravel\Passport\Console\KeysCommand::class,
        ]);
        

        $this->registerPolicies();
        Passport::routes();
        Passport::tokensExpireIn(Carbon::now()->addYears(20));
        Passport::refreshTokensExpireIn(Carbon::now()->addYears(20));


        // --------------------------------
        // BEFORE ANYTHING ELSE
        // --------------------------------
        // If this condition is true, ANYTHING else below will be assumed
        // to be true. This can cause weird blade behavior.
        Gate::before(function ($user) {
            if ($user->isSuperUser()) {
                return true;
            }
        });

        // --------------------------------
        // GENERAL GATES
        // These control general sections of the admin
        // --------------------------------
        Gate::define('admin', function ($user) {
            if ($user->hasAccess('admin')) {
                return true;
            }
        });


        # -----------------------------------------
        # Reports
        # -----------------------------------------
        Gate::define('reports.view', function ($user) {
            if ($user->hasAccess('reports.view')) {
                return true;
            }
        });

        # -----------------------------------------
        # Self
        # -----------------------------------------
        Gate::define('self.two_factor', function ($user) {
            if (($user->hasAccess('self.two_factor')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });
    }
}
