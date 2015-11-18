<?php

trait CompanayableTrait
{
    /**
     * Boot the companayable trait for a model.
     *
     * @return void
     */
    public static function bootCompanayableTrait()
    {
        static::addGlobalScope(new CompanayableScope);
    }
}
