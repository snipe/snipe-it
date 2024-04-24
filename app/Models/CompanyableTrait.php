<?php

namespace App\Models;

trait CompanyableTrait
{
    /**
     * This trait is used to scope models to the current company. To use this scope on companyable models,
     * we use the "use Companyable;" statement at the top of the mode.
     *
     * We CANNOT USE THIS ON USERS, as it causes an infinite loop and prevents users from logging in, since this scope will be
     * applied to the currently logged in (or logging in) user in addition to the user model for viewing lists of users.
     *
     * @see \App\Models\Company\Company::scopeCompanyables()
     * @return void
     */
    public static function bootCompanyableTrait()
    {
        static::addGlobalScope(new CompanyableScope);
    }
}
