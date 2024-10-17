<?php

namespace App\Actions;

use Illuminate\Support\Facades\Facade;

abstract class BaseAction extends Facade
{
    public static function __callStatic($method, $args)
    {
        return (new static)->$method(...$args);
    }

    //abstract static function run($parameters = null)
    //{
    //    return call_user_func($this->run(...$parameters));
    //}

}
