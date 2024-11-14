<?php

namespace App\Models\Traits;

use App\Models\Company;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
        //static::addGlobalScope(new CompanyableScope);
        static::addGlobalScope('companyable', function (Builder $builder) {
            $model = $builder->getModel();
            // If not logged in and hitting this, assume we are on the command line and don't scope?'
            if (!Company::isFullMultipleCompanySupportEnabled() || (Auth::hasUser() && auth()->user()->isSuperUser()) || (!Auth::hasUser())) {
                return $builder;
            } else {
                //return static::scopeCompanyablesDirectly($builder, 'company_id');
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

/*********************************************************************
 * public static function scopeCompanyables($query, $column = 'company_id', $table_name = null)
 * {
 *      // If not logged in and hitting this, assume we are on the command line and don't scope?'
 *      if (! static::isFullMultipleCompanySupportEnabled() || (Auth::hasUser() && auth()->user()->isSuperUser()) || (! Auth::hasUser())) {
 *          return $query;
 *      } else {
 *          return static::scopeCompanyablesDirectly($query, $column, $table_name);
 *      }
 * }
 ********************************************************************/

/**********************************************************************
 *
 * private static function scopeCompanyablesDirectly($query, $column = 'company_id', $table_name = null)
 * {
 *
 *      // Get the company ID of the logged-in user, or set it to null if there is no company associated with the user
 *      if (Auth::hasUser()) {
 *          $company_id = auth()->user()->company_id;
 *      } else {
 *          $company_id = null;
 *      }
 *
 *
 *      // If the column exists in the table, use it to scope the query
 *      if ((($query) && ($query->getModel()) && (Schema::hasColumn($query->getModel()->getTable(), $column)))) {
 *
 *          // Dynamically get the table name if it's not passed in, based on the model we're querying against
 *          $table = ($table_name) ? $table_name."." : $query->getModel()->getTable().".";
 *
 *          return $query->where($table.$column, '=', $company_id);
 *      }
 *
 * }
 ********************************************************************/