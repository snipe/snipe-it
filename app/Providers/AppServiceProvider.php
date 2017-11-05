<?php
namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;
use DB;
use Log;
use Illuminate\Support\Facades\Schema;
use App\Observers\AssetObserver;
use App\Observers\LicenseObserver;
use App\Observers\AccessoryObserver;
use App\Observers\ConsumableObserver;
use App\Observers\ComponentObserver;
use App\Models\Asset;
use App\Models\License;
use App\Models\Accessory;
use App\Models\Consumable;
use App\Models\Component;


/**
 * This service provider handles a few custom validation rules.
 *
 * PHP version 5.5.9
 * @version    v3.0
 */

class AppServiceProvider extends ServiceProvider
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
        Schema::defaultStringLength(191);
        Asset::observe(AssetObserver::class);
        Accessory::observe(AccessoryObserver::class);
        Component::observe(ComponentObserver::class);
        Consumable::observe(ConsumableObserver::class);
        License::observe(LicenseObserver::class);
        
        // Email array validator
        Validator::extend('email_array', function ($attribute, $value, $parameters, $validator) {
            $value = str_replace(' ', '', $value);
            $array = explode(',', $value);

            foreach ($array as $email) { //loop over values
                $email_to_validate['alert_email'][]=$email;
            }

            $rules = array('alert_email.*'=>'email');
            $messages = array(
                 'alert_email.*'=>trans('validation.email_array')
            );

            $validator = Validator::make($email_to_validate, $rules, $messages);

            return $validator->passes();

        });

        // Unique only if undeleted
        // This works around the use case where multiple deleted items have the same unique attribute.
        // (I think this is a bug in Laravel's validator?)
        Validator::extend('unique_undeleted', function ($attribute, $value, $parameters, $validator) {

            if (count($parameters)) {
                $count = DB::table($parameters[0])->select('id')->where($attribute, '=', $value)->whereNull('deleted_at')->where('id', '!=', $parameters[1])->count();
                return $count < 1;
            }

        });


        // Yo dawg. I heard you like validators.
        // This validates the custom validator regex in custom fields.
        // We're just checking that the regex won't throw an exception, not
        // that it's actually correct for what the user intended.

        Validator::extend('valid_regex', function ($attribute, $value, $parameters, $validator) {

            // Make sure it's not just an ANY format
            if ($value!='') {

               //  Check that the string starts with regex:
                if (strpos($value, 'regex:') === FALSE) {
                    return false;
                }

                $test_string = 'My hovercraft is full of eels';

                // We have to stip out the regex: part here to check with preg_match
                $test_pattern = str_replace('regex:','', $value);

                try {
                    preg_match($test_pattern, $test_string, $matches);
                    return true;
                } catch (\Exception $e) {
                    return false;
                }

            }
            return true;

        });



        // Share common setting variables with all views.
        view()->composer('*', function ($view) {
            $view->with('snipeSettings', \App\Models\Setting::getSettings());
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
        $monolog = Log::getMonolog();
        $log_level = config('app.log_level');

        if (($this->app->environment('production'))  && (config('services.rollbar.access_token'))){
            $this->app->register(\Jenssegers\Rollbar\RollbarServiceProvider::class);
        }

        foreach ($monolog->getHandlers() as $handler) {
            $handler->setLevel($log_level);
        }
    }
}
