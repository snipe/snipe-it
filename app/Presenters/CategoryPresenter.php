<?php

namespace App\Presenters;

use App\Helpers\Helper;

/**
 * Class CategoryPresenter
 * @package App\Presenters
 */
class CategoryPresenter extends Presenter
{

    /**
     * Link to this categories name
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('categories.show', $this->name, $this->id);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('categories.show', $this->id);
    }
}
