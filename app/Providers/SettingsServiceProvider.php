<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Setting;

/**
 * This service provider handles sharing the snipeSettings variable, and sets
 * some common upload path and image urls.
 *
 * PHP version 5.5.9
 * @version    v3.0
 */

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Custom email array validation
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @return void
     */
    public function boot()
    {


        // Share common setting variables with all views.
        view()->composer('*', function ($view) {
            $view->with('snipeSettings', Setting::getSettings());
        });


        /**
         * Set some common variables so that they're globally available.
         * The paths should always be public (versus private uploads)
         */



        // Model paths and URLs

        \App::singleton('assets_upload_path', function(){
            return 'assets/';
        });

        \App::singleton('accessories_upload_path', function() {
            return 'accessories/';
        });

        \App::singleton('models_upload_path', function(){
            return 'models/';
        });

        \App::singleton('models_upload_url', function(){
            return 'models/';
        });

        // Categories
        \App::singleton('categories_upload_path', function(){
            return 'categories/';
        });

        \App::singleton('categories_upload_url', function(){
            return 'categories/';
        });

        // Locations
        \App::singleton('locations_upload_path', function(){
            return 'locations/';
        });

        \App::singleton('locations_upload_url', function(){
            return 'storage/public_uploads/locations/';
        });

        // Users
        \App::singleton('users_upload_path', function(){
            return 'avatars/';
        });

        \App::singleton('users_upload_url', function(){
            return 'public_uploads/users/';
        });

        // Manufacturers
        \App::singleton('manufacturers_upload_path', function(){
            return 'manufacturers/';
        });

        \App::singleton('manufacturers_upload_url', function(){
            return 'public_uploads/manufacturers/';
        });

        // Suppliers
        \App::singleton('suppliers_upload_path', function(){
            return 'suppliers/';
        });

        \App::singleton('suppliers_upload_url', function(){
            return 'storage/public_uploads/suppliers/';
        });

        // Departments
        \App::singleton('departments_upload_path', function(){
            return 'departments/';
        });

        \App::singleton('departments_upload_url', function(){
            return 'departments/';
        });

        // Company paths and URLs
        \App::singleton('companies_upload_path', function(){
            return 'companies/';
        });

        \App::singleton('companies_upload_url', function(){
            return 'storage/public_uploads/companies/';
        });

        // Accessories paths and URLs
        \App::singleton('accessories_upload_path', function(){
            return public_path('/uploads/accessories/');
        });

        \App::singleton('accessories_upload_url', function(){
            return url('/').'/uploads/accessories/';
        });

        // Consumables paths and URLs
        \App::singleton('consumables_upload_path', function(){
            return public_path('/uploads/consumables/');
        });

        \App::singleton('consumables_upload_url', function(){
            return url('/').'/uploads/consumables/';
        });


        // Components paths and URLs
        \App::singleton('components_upload_path', function(){
            return public_path('/uploads/components/');
        });

        \App::singleton('components_upload_url', function(){
            return url('/').'/uploads/components/';
        });

        // Accessories paths and URLs
        \App::singleton('accessories_upload_path', function(){
            return public_path('/uploads/accessories/');
        });

        \App::singleton('accessories_upload_url', function(){
            return url('/').'/uploads/accessories/';
        });

        // Consumables paths and URLs
        \App::singleton('consumables_upload_path', function(){
            return public_path('/uploads/consumables/');
        });

        \App::singleton('consumables_upload_url', function(){
            return url('/').'/uploads/consumables/';
        });


        // Components paths and URLs
        \App::singleton('components_upload_path', function(){
            return public_path('/uploads/components/');
        });

        \App::singleton('components_upload_url', function(){
            return url('/').'/uploads/components/';
        });



        // Set the monetary locale to the configured locale to make helper::parseFloat work.
        setlocale(LC_MONETARY, config('app.locale'));
        setlocale(LC_NUMERIC, config('app.locale'));

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
