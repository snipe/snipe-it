<?php

final class Company extends Elegant
{
    protected $table = 'companies';

    // Declare the rules for the form validation
    protected $rules = ['name' => 'required|alpha_space|min:2|max:255|unique:companies,name,{id}'];

    private static function isFullMultipleCompanySupportEnabled()
    {
        $settings = Setting::getSettings();

        // NOTE: this can happen when seeding the database
        if (is_null($settings)) { return FALSE;                                           }
        else                    { return $settings->full_multiple_companies_support == 1; }
    }

    private static function scopeCompanyablesDirectly($query, $column = 'company_id')
    {
        if (Sentry::getUser()) {
          $company_id = Sentry::getUser()->company_id;
        } else {
          $company_id = NULL;
        }

        if ($company_id == NULL) { return $query;                                   }
        else                     { return $query->where($column, '=', $company_id); }
    }

    public static function getSelectList()
    {
        $select_company = Lang::get('general.select_company');
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
        if      (is_null($companyable))                          { return FALSE; }
        else if (!static::isFullMultipleCompanySupportEnabled()) { return TRUE;  }
        else
        {
            $current_user_company_id = Sentry::getUser()->company_id;
            $companyable_company_id = $companyable->company_id;

            return ($current_user_company_id == NULL || $current_user_company_id == $companyable_company_id);
        }
    }

    public static function isCurrentUserAuthorized()
    {
        return (!static::isFullMultipleCompanySupportEnabled() || Sentry::getUser()->company_id == NULL);
    }

    public static function canManageUsersCompanies()
    {
        return (!static::isFullMultipleCompanySupportEnabled() || Sentry::getUser()->isSuperUser() ||
                Sentry::getUser()->company_id == NULL);
    }

    public static function getIdForUser($unescaped_input)
    {
        if (!static::isFullMultipleCompanySupportEnabled() || Sentry::getUser()->isSuperUser()) {
            return static::getIdFromInput($unescaped_input);
        } else {
            return static::getIdForCurrentUser($unescaped_input);
        }
    }

    public static function scopeCompanyables($query, $column = 'company_id')
    {
        if (!static::isFullMultipleCompanySupportEnabled()) { return $query; }
        else { return static::scopeCompanyablesDirectly($query, $column); }
    }

    public static function scopeCompanyableChildren(array $companyable_names, $query)
    {
        if      (count($companyable_names) == 0)                 { throw new Exception('No Companyable Children to scope'); }
        else if (!static::isFullMultipleCompanySupportEnabled()) { return $query;              }
        else
        {
            $f = function ($q)
            {
                static::scopeCompanyablesDirectly($q);
            };

            $q = $query->where(function ($q) use ($companyable_names, $f) {
              $q2 = $q->whereHas($companyable_names[0], $f);

              for ($i = 1; $i < count($companyable_names); $i++)
              {
                  $q2 = $q2->orWhereHas($companyable_names[$i], $f);
              }
            });
            return $q;
        }
    }

    public static function getName($companyable)
    {
        $company = $companyable->company;

        if (is_null($company)) { return '';                }
        else                   { return e($company->name); }
    }
}
