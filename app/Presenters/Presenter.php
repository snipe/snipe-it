<?php

namespace App\Presenters;


use App\Models\SnipeModel;

abstract class Presenter
{
    /**
     * @var SnipeModel
     */
    protected $model;

    /**
     * Presenter constructor.
     * @param SnipeModel $model
     */
    public function __construct(SnipeModel $model)
    {
        $this->model = $model;
    }

    public function __get($property)
    {
        if( method_exists($this, $property)) {
            return $this->{$property}();
        }

        return e($this->model->{$property});
    }

    public function __call($method, $args)
    {
        return $this->model->$method($args);
    }
}
