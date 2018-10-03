<?php
namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;
use DB;
use Log;



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
            $view->with('snipeSettings', \App\Models\Setting::getSettings());
        });


        /**
         * Set some common variables so that they're globally available.
         * The paths should always be public (versus private uploads)
         */



        // Model paths and URLs

        \App::singleton('assets_upload_path', function(){
            return 'assets/';
        });


        \App::singleton('models_upload_path', function(){
            return 'assetmodels/';
        });

        \App::singleton('models_upload_url', function(){
            return 'assetmodels/';
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
            return 'users/';
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
