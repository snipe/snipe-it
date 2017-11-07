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
        \App::singleton('models_upload_path', function(){
            return public_path('/uploads/models/');
        });

        \App::singleton('models_upload_url', function(){
            return url('/').'/uploads/models/';
        });

        // Categories
        \App::singleton('categories_upload_path', function(){
            return public_path('/uploads/categories/');
        });

        \App::singleton('categories_upload_url', function(){
            return url('/').'/uploads/categories/';
        });

        // Locations
        \App::singleton('locations_upload_path', function(){
            return public_path('/uploads/locations/');
        });

        \App::singleton('locations_upload_url', function(){
            return url('/').'/uploads/locations/';
        });

        // Users
        \App::singleton('users_upload_path', function(){
            return public_path('/uploads/users/');
        });

        \App::singleton('users_upload_url', function(){
            return url('/').'/uploads/users/';
        });

        // Manufacturers
        \App::singleton('manufacturers_upload_path', function(){
            return public_path('/uploads/manufacturers/');
        });

        \App::singleton('manufacturers_upload_url', function(){
            return url('/').'/uploads/manufacturers/';
        });

        // Suppliers
        \App::singleton('suppliers_upload_path', function(){
            return public_path('/uploads/suppliers/');
        });

        \App::singleton('suppliers_upload_url', function(){
            return url('/').'/uploads/suppliers/';
        });

        // Departments
        \App::singleton('departments_upload_path', function(){
            return public_path('/uploads/departments/');
        });

        \App::singleton('departments_upload_url', function(){
            return url('/').'/uploads/departments/';
        });

        // Company paths and URLs
        \App::singleton('companies_upload_path', function(){
            return public_path('/uploads/companies/');
        });

        \App::singleton('companies_upload_url', function(){
            return url('/').'/uploads/companies/';
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
