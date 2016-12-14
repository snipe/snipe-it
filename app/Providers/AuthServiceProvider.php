<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //'App\Model' => 'App\Policies\ModelPolicy',
        // We should switch to the below
        // App\Post::class => PostPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        //$this->registerPolicies();

        // --------------------------------
        // BEFORE ANYTHING ELSE
        // --------------------------------
        // If this condition is true, ANYTHING else below will be asssumed
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
        # Assets
        # -----------------------------------------
        Gate::define('assets.view', function ($user) {
            if (($user->hasAccess('assets.view')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('assets.view.requestable', function ($user) {
            if (($user->hasAccess('assets.view.requestable')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('assets.create', function ($user) {
            if (($user->hasAccess('assets.create')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('assets.checkout', function ($user) {
            if (($user->hasAccess('assets.checkout')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('assets.checkin', function ($user) {
            if (($user->hasAccess('assets.checkin')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('assets.edit', function ($user) {
            if (($user->hasAccess('assets.edit')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        // Checks for some level of management
        Gate::define('assets.manage', function ($user) {
            if (($user->hasAccess('assets.checkin')) || ($user->hasAccess('assets.edit')) || ($user->hasAccess('assets.delete')) || ($user->hasAccess('assets.checkout')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });


        # -----------------------------------------
        # Accessories
        # -----------------------------------------
        Gate::define('accessories.view', function ($user) {
            if (($user->hasAccess('accessories.view')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('accessories.create', function ($user) {
            if (($user->hasAccess('accessories.create')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('accessories.edit', function ($user) {
            if (($user->hasAccess('accessories.edit')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('accessories.delete', function ($user) {
            if (($user->hasAccess('accessories.delete')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('accessories.checkout', function ($user) {
            if (($user->hasAccess('accessories.checkout')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('accessories.checkin', function ($user) {
            if (($user->hasAccess('accessories.checkin')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        // Checks for some level of management
        Gate::define('accessories.manage', function ($user) {
            if (($user->hasAccess('accessories.checkin')) || ($user->hasAccess('accessories.edit')) || ($user->hasAccess('accessories.checkout')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        # -----------------------------------------
        # Consumables
        # -----------------------------------------
        Gate::define('consumables.view', function ($user) {
            if (($user->hasAccess('consumables.view')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('consumables.create', function ($user) {
            if (($user->hasAccess('consumables.create')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('consumables.edit', function ($user) {
            if (($user->hasAccess('consumables.edit')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('consumables.delete', function ($user) {
            if (($user->hasAccess('consumables.delete')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('consumables.checkout', function ($user) {
            if (($user->hasAccess('consumables.checkout')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('consumables.checkin', function ($user) {
            if (($user->hasAccess('consumables.checkin')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        // Checks for some level of management
        Gate::define('consumables.manage', function ($user) {
            if (($user->hasAccess('consumables.checkin')) || ($user->hasAccess('consumables.edit')) || ($user->hasAccess('consumables.delete')) || ($user->hasAccess('consumables.checkout')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });



        # -----------------------------------------
        # Users
        # -----------------------------------------

        Gate::define('users.view', function ($user) {
            if (($user->hasAccess('users.view')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('users.create', function ($user) {
            if (($user->hasAccess('users.create')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('users.edit', function ($user) {
            if (($user->hasAccess('users.edit')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('users.delete', function ($user) {
            if (($user->hasAccess('users.delete')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });


        # -----------------------------------------
        # Components
        # -----------------------------------------
        Gate::define('components.view', function ($user) {
            if (($user->hasAccess('components.view')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('components.create', function ($user) {
            if (($user->hasAccess('components.create')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('components.edit', function ($user) {
            if (($user->hasAccess('components.edit')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('components.delete', function ($user) {
            if (($user->hasAccess('components.delete')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('components.checkout', function ($user) {
            if (($user->hasAccess('components.checkout')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        // Checks for some level of management
        Gate::define('components.manage', function ($user) {
            if (($user->hasAccess('components.edit')) || ($user->hasAccess('components.delete')) || ($user->hasAccess('components.checkout')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });


        # -----------------------------------------
        # Licenses
        # -----------------------------------------
        Gate::define('licenses.view', function ($user) {
            if (($user->hasAccess('licenses.view')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('licenses.create', function ($user) {
            if (($user->hasAccess('licenses.create')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('licenses.edit', function ($user) {
            if (($user->hasAccess('licenses.edit')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('licenses.delete', function ($user) {
            if (($user->hasAccess('licenses.delete')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('licenses.checkout', function ($user) {
            if (($user->hasAccess('licenses.checkout')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('licenses.checkin', function ($user) {
            if (($user->hasAccess('licenses.checkin')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        Gate::define('licenses.keys', function ($user) {
            if (($user->hasAccess('licenses.keys')) || ($user->hasAccess('admin'))) {
                return true;
            }
        });

        // Checks for some level of management
        Gate::define('licenses.manage', function ($user) {
            if (($user->hasAccess('licenses.checkin')) || ($user->hasAccess('licenses.edit')) || ($user->hasAccess('licenses.delete')) || ($user->hasAccess('licenses.checkout')) || ($user->hasAccess('admin'))) {
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
