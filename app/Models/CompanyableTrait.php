<?php

namespace App\Models;

trait CompanyableTrait
{
    /**
     * Boot the companyable trait for a model.
     *
     * @return void
     */
    public static function bootCompanyableTrait()
    {
        static::addGlobalScope(new CompanyableScope);
    }
}
