<?php

namespace App\Presenters;

use App\Helpers\Helper;

/**
 * Class LocationPresenter
 * @package App\Presenters
 */
class LocationPresenter extends Presenter
{
    /**
     * JSON representation of this location for data table.
     * @return array
     */
    public function forDataTable()
    {
        $actions = '<nobr>';
        $actions .= Helper::generateDatatableButton('edit', route('locations.edit', $this->id));
        $actions .= Helper::generateDatatableButton(
            'delete',
            route('locations.destroy', $this->id),
            true, /*enabled*/
            trans('admin/locations/message.delete.confirm'),
            $this->name
        );
        $actions .= '</nobr>';

        $results = [
            'actions'           => $actions,
            'address'           => $this->address,
            'assets_checkedout' => $this->model->assets()->count(),
            'assets_default'    => $this->model->assignedassets()->count(),
            'city'              => $this->city,
            'country'           => $this->country,
            'currency'          => $this->currency,
            'id'                => $this->id,
            'name'              => $this->nameUrl(),
            'parent'            => ($this->model->parent) ? $this->model->parent->present()->nameUrl() : '',
            'state'             => $this->state,
            'zip'               => $this->zip,
            //  'assets'        => ($this->assets->count() + $this->assignedassets->count()),
        ];

        return $results;
    }

    /**
     * Link to this locations name
     * @return string
     */
    public function nameUrl()
    {
        return (string)link_to_route('locations.show', $this->name, $this->id);
    }

    /**
     * Getter for Polymorphism.
     * @return mixed
     */
    public function name()
    {
        return $this->model->name;
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('locations.show', $this->id);
    }
}
