<?php

namespace App\Models\Traits;

use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;

trait Companyable
{
    /**
     * This trait is used to scope models to the current company. To use this scope on companyable models,
     * we use the "use Companyable;" statement at the top of the mode.
     *
     * @return void
     *
     */
    public static function bootCompanyable()
    {
        static::addGlobalScope('companyable', function (Builder $builder) {
            $model = $builder->getModel();
            // If not logged in and hitting this, assume we are on the command line and don't scope?'
            if (!Setting::getSettings()?->full_multiple_companies_support || (Auth::hasUser() && auth()->user()->isSuperUser()) || (!Auth::hasUser())) {
                return $builder;
            } else {
                // Get the company ID of the logged-in user, or set it to null if there is no company associated with the user
                if (Auth::hasUser()) {
                    $company_id = auth()->user()->company_id;
                } else {
                    $company_id = null;
                }

                // If the column exists in the table, use it to scope the query
                if (Schema::hasColumn($model->getTable(), 'company_id')) {
                    return $builder->where($model->getTable().".company_id", '=', $company_id);
                }
            }
        });
    }
}