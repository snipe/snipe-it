<?php

trait CompanyableChildTrait
{
    /**
     * Boot the companayable trait for a model.
     *
     * @return void
     */
    public static function bootCompanyableChildTrait()
    {
        static::addGlobalScope(new CompanyableChildScope);
    }
}
