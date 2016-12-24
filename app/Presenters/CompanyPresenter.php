<?php

namespace App\Presenters;


/**
 * Class CompanyPresenter
 * @package App\Presenters
 */
class CompanyPresenter extends Presenter
{
    /**
     * Link to this companies name
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('companies.show', $this->name, $this->id);
    }
}
