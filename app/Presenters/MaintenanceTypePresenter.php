<?php

namespace App\Presenters;

class MaintenanceTypePresenter extends Presenter
{
    public static function dataTableLayout(): string
    {
        $layout = [
            [
                'field' => 'checkbox',
                'scope' => 'col',
                'checkbox' => true,
                'titleTooltip' => trans('general.select_all_none'),
                'printIgnore' => true,
                'class' => 'hidden-print',
            ], [
                'field' => 'id',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.id'),
                'visible' => false,
            ], [
                'field' => 'name',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'switchable' => false,
                'title' => trans('general.name'),
                'visible' => true,
                // maintenanceTypesLinkFormatter is auto-generated from
                // the formatters array in bootstrap-table.blade.php and
                // renders the row's tag_color as a leading colored
                // square, matching how categories and other tag-colored
                // entities read on their index tables.
                'formatter' => 'maintenanceTypesLinkFormatter',
            ], [
                'field' => 'maintenances_count',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('admin/maintenances/general.maintenances'),
                'visible' => true,
                'class' => 'text-right',
            ], [
                'field' => 'created_by',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.created_by'),
                'visible' => false,
                'formatter' => 'usersLinkObjFormatter',
            ], [
                'field' => 'created_at',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.created_at'),
                'visible' => false,
                'formatter' => 'dateDisplayFormatter',
            ], [
                'field' => 'updated_at',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.updated_at'),
                'visible' => false,
                'formatter' => 'dateDisplayFormatter',
            ], [
                'field' => 'actions',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => trans('table.actions'),
                'visible' => true,
                'formatter' => 'maintenanceTypesActionsFormatter',
                'printIgnore' => true,
            ],
        ];

        return json_encode($layout);
    }
}
