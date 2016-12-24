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
     * JSON representation of this manufacturer for data table.
     * @return array
     */
    public function forDataTable()
    {
        $actions = '<nobr>';
        $actions .= Helper::generateDatatableButton('edit', route('manufacturers.edit', $this->id));
        $actions .= Helper::generateDatatableButton(
            'delete',
            route('manufacturers.destroy', $this->id),
            true, /*enabled*/
            trans('admin/manufacturers/message.delete.confirm'),
            $this->name
        );
        $actions .= '</nobr>';

        $results = [
            'id'            => $this->id,
            'name'          => $this->nameUrl(),
            'assets'        => $this->assets()->count(),
            'licenses'      => $this->licenses()->count(),
            'accessories'   => $this->accessories()->count(),
            'consumables'   => $this->consumables()->count(),
            'actions'       => $actions
        ];

        return $results;
    }

    /**
     * Link to this manufacturers name
     * @return string
     */
    public function nameUrl()
    {
       return (string) link_to_route('manufacturers.show', $this->name, $this->id);
    }
}
