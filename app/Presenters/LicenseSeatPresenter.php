<?php

namespace App\Presenters;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Gate;

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
