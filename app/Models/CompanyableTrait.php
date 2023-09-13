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
        // In Version 6 and before locations weren't scoped by companies, so add a check for the backward compatibility setting
        if (__CLASS__ != 'App\Models\Location') {
            static::addGlobalScope(new CompanyableScope);
        } else {
            if (Setting::getSettings()->scope_locations_fmcs == 1) {
                static::addGlobalScope(new CompanyableScope);
            }
        }
    }
}
