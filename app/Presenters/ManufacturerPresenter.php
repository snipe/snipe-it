<?php

namespace App\Presenters;

use App\Helpers\Helper;

/**
 * Class ManufacturerPresenter
 * @package App\Presenters
 */
class ManufacturerPresenter extends Presenter
{


    /**
     * Link to this manufacturers name
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('manufacturers.show', $this->name, $this->id);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('manufacturers.show', $this->id);
    }
}
