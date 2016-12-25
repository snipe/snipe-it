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
     * JSON representation of category for datatable.
     * @return array
     */
    public function forDataTable()
    {
        $actions = Helper::generateDatatableButton('edit', route('categories.edit', $this->id));
        $actions .= Helper::generateDatatableButton(
            'delete',
            route('categories.destroy', $this->id),
            $this->itemCount() == 0, /* enabled */
            trans('admin/categories/message.delete.confirm'),
            $this->name
        );
        $results = [];
        $results['id'] = $this->id;
        $results['name'] = $this->nameUrl();
        $results['category_type'] = ucwords($this->category_type);
        $results['count'] = $this->itemCount();
        $results['acceptance'] = ($this->require_acceptance == '1') ? '<i class="fa fa-check"></i>' : '';
        $results['eula'] = $this->getEula() ? '<i class="fa fa-check"></i>' : '';
        $results['actions'] = $actions;

        return $results;
    }

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
