<?php

namespace App\Presenters;

/**
 * Class LicensePresenter
 * @package App\Presenters
 */
class LicenseSeatPresenter extends Presenter
{
    public function name()
    {
        return $this->model->license->name;
    }
}
