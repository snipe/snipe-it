<?php

namespace App\Presenters;

/**
 * Class AssetModelPresenter
 */
class AssetMaintenancesPresenter extends Presenter
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
                'field' => 'company',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('admin/companies/table.title'),
                'visible' => false,
                'formatter' => 'companiesLinkObjFormatter',
            ], [
                'field' => 'asset_name',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('admin/asset_maintenances/table.asset_name'),
                'formatter' => 'assetNameLinkFormatter',
            ], [
                'field' => 'asset_tag',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('admin/hardware/table.asset_tag'),
                'formatter' => 'assetTagLinkFormatter',
            ], [
                'field' => 'model',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('admin/hardware/form.model'),
                'visible' => false,
                'formatter' => 'modelsLinkObjFormatter',
            ], [
                'field' => 'supplier',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.supplier'),
                'visible' => false,
                'formatter' => 'suppliersLinkObjFormatter',
            ], [
                'field' => 'location',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('general.location'),
                'formatter' => 'locationsLinkObjFormatter',
            ], [
                'field' => 'asset_maintenance_type',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('admin/asset_maintenances/form.asset_maintenance_type'),
            ], [
                'field' => 'title',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('admin/asset_maintenances/form.title'),
            ], [
                'field' => 'start_date',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('admin/asset_maintenances/form.start_date'),
                'formatter' => 'dateDisplayFormatter',
            ], [
                'field' => 'completion_date',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('admin/asset_maintenances/form.completion_date'),
                'formatter' => 'dateDisplayFormatter',
            ], [
                'field' => 'notes',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('admin/asset_maintenances/form.notes'),
            ], [
                'field' => 'is_warranty',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('admin/asset_maintenances/table.is_warranty'),
                'formatter' => 'trueFalseFormatter'
            ], [
                'field' => 'cost',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('admin/asset_maintenances/form.cost'),
                'class' => 'text-right',
            ], [
                'field' => 'user_id',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('general.admin'),
                'formatter' => 'usersLinkObjFormatter',
            ], [
                'field' => 'actions',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => trans('table.actions'),
                'visible' => true,
                'formatter' => 'maintenancesActionsFormatter',
            ],
        ];

        return json_encode($layout);
    }
}
