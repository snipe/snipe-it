<?php
namespace App\Providers;

use Validator;
use Illuminate\Support\ServiceProvider;
use DB;


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

        // Unique only if undeleted
        // This works around the use case where multiple deleted items have the same unique attribute.
        // (I think this is a bug in Laravel's validator?)
        Validator::extend('unique_undeleted', function($attribute, $value, $parameters, $validator) {

            $count = DB::table($parameters[0])->select('id')->where($attribute,'=',$value)->whereNull('deleted_at')->where('id','!=',$parameters[1])->count();

            if ($count < 1) {
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
