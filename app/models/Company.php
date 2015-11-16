<?php

use Setting;

use Lang;
use Sentry;

final class Company extends Elegant
{
    protected $table = 'companies';

    // Declare the rules for the form validation
    protected $rules = ['name' => 'required|alpha_space|min:2|max:255|unique:companies,name,{id}'];

    private static function isFullMultipleCompanySupportEnabled()
    {
        $settings = Setting::getSettings();
        return $settings->full_multiple_companies_support == 1;
    }

    public static function getSelectList()
    {
        $select_company = Lang::get('admin/companies/general.select_company');
        return ['0' => $select_company] + DB::table('companies')->orderBy('name', 'ASC')->lists('name', 'id');
    }

    public static function getIdFromInput($unescaped_input)
    {
        $escaped_input = e($unescaped_input);

        if ($escaped_input == '0') { return NULL;           }
        else                       { return $escaped_input; }
    }

    public static function getIdForCurrentUser($unescaped_input)
    {
        if (!static::isFullMultipleCompanySupportEnabled()) { return static::getIdFromInput($unescaped_input); }
        else
        {
            $current_user = Sentry::getUser();

            if ($current_user->company_id != NULL) { return $current_user->company_id;                }
            else                                   { return static::getIdFromInput($unescaped_input); }
        }
    }

    public static function isCurrentUserHasAccess($companyable)
    {
        if (!static::isFullMultipleCompanySupportEnabled()) { return TRUE; }
        else
        {
            $current_user_company_id = Sentry::getUser()->company_id;
            $companyable_company_id = $companyable->company_id;

            return ($current_user_company_id == NULL || $current_user_company_id == $companyable_company_id);
        }
    }

    public static function isCurrentUserAuthorized()
    {
        if (!static::isFullMultipleCompanySupportEnabled()) { return TRUE; }
        else
        {
            $current_user = Sentry::getUser();
            return ($current_user->company_id == NULL);
        }
    }

    public static function scopeCompanayables($query, $column = 'company_id')
    {
        if (!static::isFullMultipleCompanySupportEnabled()) { return $query; }
        else
        {
            $company_id = Sentry::getUser()->company_id;

            if ($company_id == NULL) { return $query;                                   }
            else                     { return $query->where($column, '=', $company_id); }
        }
    }

    public static function scopeCompanayableChildren($companyable_name, $query)
    {
        if (!static::isFullMultipleCompanySupportEnabled()) { return $query; }
        else
        {
            return $query->whereHas($companyable_name, function ($query)
            {
                static::scopeCompanayables($query);
            });
        }
    }

    public static function scopeActionLogs($query)
    {
        if (!static::isFullMultipleCompanySupportEnabled()) { return $query; }
        else
        {
            $f = function ( $q )
            {
                static::scopeCompanayables( $q );
            };

            return $query
                ->whereHas( 'accessorylog', $f )
                ->orWhereHas( 'assetlog', $f )
                ->orWhereHas( 'licenselog', $f )
                ->orWhereHas( 'consumablelog', $f );
        }
    }
}
