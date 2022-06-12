<?php

namespace App\Presenters;

/**
 *  extends Presenter
 */
class EolAssetPresenter extends Presenter
{
    /**
     * Json Column Layout for bootstrap table
     * @return string
     */
    public static function dataTableLayout()
    {
        $layout = [
            [
                'field' => 'name',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('admin/hardware/form.name'),
                'visible' => true,
            ], [
                'field' => 'asset_tag',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('admin/hardware/table.asset_tag'),
                'visible' => true,                
            ],[
                'field' => 'asset_model',
                'searchable' => true,
                'sortable' => true,
                'title' =>  trans('admin/hardware/table.asset_model'),
                'visible' => true,
            ],[
                "field" => 'model_number',
                "searchable" => false,
                "sortable" => true,
                "title" => trans('admin/hardware/table.serial'),
                "visible" => true,
            ],[
                'field' => 'purchase_date',
                'searchable' => true,
                'sortable' => true,
                'switchable' => false,
                'title' => trans('general.purchase_date'),
                'visible' => true,
               
            ],[
                'field' => 'notes',
                'searchable' => true,
                'sortable' => false,
                'switchable' => false,
                'title' => trans('admin/hardware/form.notes'),
                'visible' => true,               
            ],[
                'field' => 'eol_date',
                'searchable' => true,
                'sortable' => true,
                'switchable' => false,
                'title' => trans('admin/hardware/table.eol_date'),
                'visible' => true,                
            ],[
                'field' => 'expiry_status',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('admin/hardware/table.eol_status'),
                'visible' => true,
            ],[
                'field' => 'days_before_eol',
                'searchable' => true,
                'sortable' => true,
                'switchable' => false,
                'title' => trans('admin/hardware/table.eol_duration'),
                'visible' => true,               
            ],
        ];

        return json_encode($layout);
    }
}
