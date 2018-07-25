<?php
namespace App\Models\Traits;

use App\Models\CompanyableScope;

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
