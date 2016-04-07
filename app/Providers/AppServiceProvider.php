<?php
namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;

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

        // Email array validator
        Validator::extend('email_array', function($attribute, $value, $parameters, $validator) {
            $value = str_replace(' ','',$value);
            $array = explode(',', $value);

            foreach($array as $email) //loop over values
            {
                $email_to_validate['alert_email'][]=$email;
            }

            $rules = array('alert_email.*'=>'email');
            $messages = array(
                 'alert_email.*'=>trans('validation.email_array')
            );

            $validator = Validator::make($email_to_validate,$rules,$messages);

            if ($validator->passes()) {
                return true;
            } else {
                return false;
            }

        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
