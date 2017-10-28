<?php

namespace App\Providers;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Category;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\CustomField;
use App\Models\Department;
use App\Models\License;
use App\Models\Location;
use App\Models\Statuslabel;
use App\Models\Supplier;
use App\Models\User;
use App\Policies\AccessoryPolicy;
use App\Policies\AssetModelPolicy;
use App\Policies\AssetPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\ComponentPolicy;
use App\Policies\ConsumablePolicy;
use App\Policies\CustomFieldPolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\LicensePolicy;
use App\Policies\LocationPolicy;
use App\Policies\StatuslabelPolicy;
use App\Policies\SupplierPolicy;
use App\Policies\UserPolicy;
use Carbon\Carbon;
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
        Accessory::class => AccessoryPolicy::class,
        Asset::class => AssetPolicy::class,
        AssetModel::class => AssetModelPolicy::class,
        Category::class => CategoryPolicy::class,
        Component::class => ComponentPolicy::class,
        Consumable::class => ConsumablePolicy::class,
        CustomField::class => CustomFieldPolicy::class,
        Department::class => DepartmentPolicy::class,
        License::class => LicensePolicy::class,
        Location::class => LocationPolicy::class,
        Statuslabel::class => StatuslabelPolicy::class,
        Supplier::class => SupplierPolicy::class,
        User::class => UserPolicy::class,
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

        Gate::define('backend.interact', function ($user) {
            return $user->can('view', \App\Models\Statuslabel::class)
                || $user->can('view', \App\Models\AssetModel::class)
                || $user->can('view', \App\Models\Category::class)
                || $user->can('view', \App\Models\Manufacturer::class)
                || $user->can('view', \App\Models\Supplier::class)
                || $user->can('view', \App\Models\Department::class)
                || $user->can('view', \App\Models\Location::class)
                || $user->can('view', \App\Models\Company::class)
                || $user->can('view', \App\Models\Depreciation::class);
        });
    }
}
