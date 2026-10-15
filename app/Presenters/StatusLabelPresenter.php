<?php

namespace App\Presenters;

/**
 * Class StatusLabelPresenter
 */
class StatusLabelPresenter extends Presenter
{
    /**
     * Json Column Layout for bootstrap table
     *
     * @return string
     */
    public static function dataTableLayout()
    {
        $layout = [
            [
                'field' => 'checkbox',
                'scope' => 'col',
                'checkbox' => true,
                'formatter' => 'checkboxEnabledFormatter',
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
                'formatter' => 'statuslabelsLinkFormatter',
            ], [
                'field' => 'type',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => trans('admin/statuslabels/table.status_type'),
                'visible' => true,
                'formatter' => 'statusLabelTypeFormatter',
            ], [
                'field' => 'assets_count',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => true,
                'switchable' => false,
                'title' => trans('general.assets'),
                'visible' => true,
            ], [
                'field' => 'color',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('admin/statuslabels/table.color'),
                'visible' => true,
                'formatter' => 'colorTagFormatter',
            ],  [
                'field' => 'show_in_nav',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('admin/statuslabels/table.show_in_nav'),
                'visible' => true,
                'formatter' => 'trueFalseFormatter',
            ], [
                'field' => 'default_label',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('admin/statuslabels/table.default_label'),
                'visible' => true,
                'formatter' => 'trueFalseFormatter',
            ], [
                'field' => 'notes',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.notes'),
                'visible' => false,
            ], [
                'field' => 'created_by',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => true,
                'title' => trans('general.created_by'),
                'visible' => false,
                'formatter' => 'usersLinkObjFormatter',
            ], [
                'field' => 'created_at',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.created_at'),
                'visible' => false,
                'formatter' => 'dateDisplayFormatter',
            ], [
                'field' => 'updated_at',
                'scope' => 'col',
                'searchable' => true,
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
                'formatter' => 'statuslabelsActionsFormatter',
                'printIgnore' => true,
            ],
        ];

        return json_encode($layout);
    }
}
