<?php

namespace App\Presenters;

/**
 * Class DepreciationPresenter
 */
class DepreciationPresenter extends Presenter
{
    /**
     * Json Column Layout for bootstrap table
     * @return string
     */
    public static function dataTableLayout()
    {
        $layout = [
            [
                'field' => 'id',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.id'),
                'visible' => false,
            ], [
                'field' => 'name',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('general.name'),
                'visible' => true,
                'formatter' => 'depreciationsLinkFormatter',
            ],

            [
                'field' => 'term_length',
                'searchable' => true,
                'sortable' => true,
                'title' =>  trans('admin/depreciations/table.term'),
                'visible' => true,
            ],

            [
                'field' => 'term_type',
                'searchable' => true,
                'sortable' => true,
                'title' =>  trans('admin/depreciations/table.term_type'),
                'visible' => true,
            ],

            [
                "field" => 'depreciation_min',
                "searchable" => false,
                "sortable" => true,
                "title" => trans('admin/depreciations/table.depreciation_min'),
                "visible" => true,
            ],
            [
                'field' => 'actions',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => trans('table.actions'),
                'visible' => true,
                'formatter' => 'depreciationsActionsFormatter',
            ],
        ];

        return json_encode($layout);
    }
}
