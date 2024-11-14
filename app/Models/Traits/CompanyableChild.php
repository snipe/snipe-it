<?php

namespace App\Models\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Models\Company;
use Illuminate\Database\Eloquent\Builder;

trait CompanyableChild
{
    /**
     * Boot the companyable trait for a model.
     *
     * @return void
     */
    public static function bootCompanyableChild()
    {
        static::addGlobalScope('companyable_child', function (Builder $builder) {
            $model = $builder->getModel();

            //return Company::scopeCompanyableChildren($model->getCompanyableParents(), $builder);
            $companyable_names = $model->getCompanyableParents();
            if (count($companyable_names) == 0) {
                throw new \Exception('No Companyable Children to scope');
            } elseif (!Company::isFullMultipleCompanySupportEnabled() || (Auth::hasUser() && auth()->user()->isSuperUser())) {
                return $builder;
            } else {
                if (Auth::hasUser()) {
                    $company_id = auth()->user()->company_id;
                } else {
                    $company_id = null;
                }

                $q = $builder->where(function ($q) use ($companyable_names, $company_id) {
                    // helper function to look for company_id *if* you have one
                    $company_if_needed = function ($subquery) use ($company_id) {
                        $table = $subquery->getModel()->getTable();
                        if (Schema::hasColumn($table, 'company_id')) {
                            $subquery->where($table.'.company_id', $company_id);
                        }
                    };

                    //first, handle the *first* of the companyable_names...
                    $q2 = $q->whereHas($companyable_names[0], $company_if_needed);

                    //then, go through the list of the remaining, appending them on to the query with 'orWhereHas()'
                    for ($i = 1; $i < count($companyable_names); $i++) {
                        $q2 = $q2->orWhereHas($companyable_names[$i], $company_if_needed);
                    }
                });

                return $q;
            }

        });
    }
}

/**************************
 *private static function scopeCompanyablesDirectly($query, $column = 'company_id', $table_name = null)
 * {
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
 *      // Dynamically get the table name if it's not passed in, based on the model we're querying against
 *      $table = ($table_name) ? $table_name."." : $query->getModel()->getTable().".";
 *
 *      return $query->where($table.$column, '=', $company_id);
 * }
 */

/*************************************************************************************************
 *
 * public static function scopeCompanyableChildren(array $companyable_names, $query)
 * {
 *
 *      if (count($companyable_names) == 0) {
 *          throw new Exception('No Companyable Children to scope');
 *      } elseif (! static::isFullMultipleCompanySupportEnabled() || (Auth::hasUser() && auth()->user()->isSuperUser())) {
 *          return $query;
 *      } else {
 *          $f = function ($q) {
 *              Log::debug('scopeCompanyablesDirectly firing ');
 *              static::scopeCompanyablesDirectly($q);
 *          };
 *
 *          $q = $query->where(function ($q) use ($companyable_names, $f) {
 *              $q2 = $q->whereHas($companyable_names[0], $f);
 *
 *              for ($i = 1; $i < count($companyable_names); $i++) {
 *                  $q2 = $q2->orWhereHas($companyable_names[$i], $f);
 *              }
 *          });
 *
 *          return $q;
 *      }
 * }
 *
 *
 */
