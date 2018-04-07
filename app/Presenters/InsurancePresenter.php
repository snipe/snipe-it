<?php

namespace App\Presenters;

use App\Helpers\Helper;

/**
 * Class ManufacturerPresenter
 * @package App\Presenters
 */
class InsurancePresenter extends Presenter
{

    /**
     * Json Column Layout for bootstrap table
     * @return string
     */
    public static function dataTableLayout()
    {
        $layout = [

            [
                "field" => "id",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.id'),
                "visible" => true
            ],
            [
                "field" => "name",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/insurance/table.name'),
                "visible" => true,
                "formatter" => "insuranceLinkFormatter"
            ],
            [
                "field" => "started_at",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('insurance.started_at'),
                "visible" => true,
                'formatter' => 'dateDisplayFormatter'
            ],
            [
                "field" => "ended_at",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('insurance.ended_at'),
                "visible" => true,
                'formatter' => 'dateDisplayFormatter'
            ],
            [
                "field" => "created_at",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.created_at'),
                "visible" => true,
                'formatter' => 'dateDisplayFormatter'
            ],

            [
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('table.actions'),
                "visible" => true,
                "formatter" => "insuranceActionFormatter",
            ]
        ];

        return json_encode($layout);
    }



    /**
     * Link to this manufacturers name
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('insurance.show', $this->name, $this->id);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('insurance.show', $this->id);
    }
}
