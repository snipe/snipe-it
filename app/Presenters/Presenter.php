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

    // Convenience functions for datatables stuff
    public function categoryUrl()
    {
        $model = $this->model;
        // Category of Asset belongs to model.
        if ($model->model) {
            $model = $this->model->model;
        }

        if ($model->category) {
            return $model->category->present()->nameUrl();
        }

        return '';
    }

    public function locationUrl()
    {
        if ($this->model->location) {
            return $this->model->location->present()->nameUrl();
        }

        return '';
    }

    public function companyUrl()
    {
        if ($this->model->company) {
            return $this->model->company->present()->nameUrl();
        }

        return '';
    }

    public function manufacturerUrl()
    {
        $model = $this->model;
        // Category of Asset belongs to model.
        if ($model->model) {
            $model = $this->model->model;
        }

        if ($model->manufacturer) {
            return $model->manufacturer->present()->nameUrl();
        }

        return '';
    }

    public function name()
    {
        return $this->model->name;
    }

    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return $this->{$property}();
        }

        return e($this->model->{$property});
    }

    public function __call($method, $args)
    {
        return $this->model->$method($args);
    }
}
