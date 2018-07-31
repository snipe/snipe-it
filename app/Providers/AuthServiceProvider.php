<?php

namespace App\Providers;

use App\Models;
use App\Policies\AccessoryPolicy;
use App\Policies\AssetModelPolicy;
use App\Policies\AssetPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\ComponentPolicy;
use App\Policies\ConsumablePolicy;
use App\Policies\CustomFieldPolicy;
use App\Policies\CustomFieldsetPolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\DepreciationPolicy;
use App\Policies\LicensePolicy;
use App\Policies\LocationPolicy;
use App\Policies\StatuslabelPolicy;
use App\Policies\SupplierPolicy;
use App\Policies\UserPolicy;
use App\Policies\ManufacturerPolicy;
use App\Policies\CompanyPolicy;
use Carbon\Carbon;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * See SnipePermissionsPolicy for additional information.
     *
     * @var array
     */
    protected $policies = [
        Models\Accessory::class => AccessoryPolicy::class,
        Models\Asset::class => AssetPolicy::class,
        Models\AssetModel::class => AssetModelPolicy::class,
        Models\Category::class => CategoryPolicy::class,
        Models\Component::class => ComponentPolicy::class,
        Models\Consumable::class => ConsumablePolicy::class,
        Models\CustomField::class => CustomFieldPolicy::class,
        Models\CustomFieldset::class => CustomFieldsetPolicy::class,
        Models\Department::class => DepartmentPolicy::class,
        Models\Depreciation::class => DepreciationPolicy::class,
        Models\LicenseModel::class => LicensePolicy::class,
        Models\Location::class => LocationPolicy::class,
        Models\Statuslabel::class => StatuslabelPolicy::class,
        Models\Supplier::class => SupplierPolicy::class,
        Models\User::class => UserPolicy::class,
        Models\Manufacturer::class => ManufacturerPolicy::class,
        Models\Company::class => CompanyPolicy::class,
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

        Gate::define('self.api', function($user) {
            return $user->hasAccess('self.api');
        });

        Gate::define('self.edit_location', function($user) {
            return $user->hasAccess('self.edit_location');
        });

        Gate::define('backend.interact', function ($user) {
            return $user->can('view', Models\Statuslabel::class)
                || $user->can('view', Models\AssetModel::class)
                || $user->can('view', Models\Category::class)
                || $user->can('view', Models\Manufacturer::class)
                || $user->can('view', Models\Supplier::class)
                || $user->can('view', Models\Department::class)
                || $user->can('view', Models\Location::class)
                || $user->can('view', Models\Company::class)
                || $user->can('view', Models\Manufacturer::class)
                || $user->can('view', Models\CustomField::class)
                || $user->can('view', Models\CustomFieldset::class)
                || $user->can('view', Models\Depreciation::class);
        });
    }
}
