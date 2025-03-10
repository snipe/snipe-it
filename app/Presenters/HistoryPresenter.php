<?php

namespace App\Presenters;

/**
 * Class AccessoryPresenter
 */
class HistoryPresenter extends Presenter
{
    /**
     * Json Column Layout for bootstrap table
     * @return string
     */
    public static function dataTableLayout()
    {
        $layout = [
            [
                'field' => 'icon',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('admin/hardware/table.icon'),
                'visible' => true,
                'class' => 'hidden-xs',
                'formatter' => 'iconFormatter',
            ],
            [
                'field' => 'created_at',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.created_at'),
                'visible' => false,
                'formatter' => 'dateDisplayFormatter',
            ],
            [
                'field' => 'created_by',
                'searchable' => false,
                'sortable' => true,
                'title' => trans('general.created_by'),
                'visible' => false,
                'formatter' => 'usersLinkObjFormatter',
            ],
            [
                'field' => 'action_date',
                'searchable' => false,
                'sortable' => true,
                'title' => trans('general.action_date'),
                'visible' => false,
                'formatter' => 'dateDisplayFormatter',
            ],
            [
                'field' => 'action_type',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.action'),
                'visible' => false,
            ],
            [
                'field' => 'item',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.item'),
                'visible' => false,
                'formatter' => 'polymorphicItemFormatter',
            ], [
                'field' => 'target',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.target'),
                'visible' => false,
                'formatter' => 'polymorphicItemFormatter',
            ],
            [
                'field' => 'file',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.file_name'),
                'visible' => false,
                'formatter' => 'fileUploadNameFormatter',
            ],
            [
                'field' => 'file_download',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.download'),
                'visible' => false,
                'formatter' => 'fileUploadFormatter',
            ],
            [
                'field' => 'note',
                'searchable' => true,
                'sortable' => true,
                'visible' => false,
                'title' => trans('general.notes'),
                'formatter' => 'notesFormatter'
            ],
            [
                'field' => 'signature_file',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.signature'),
                'visible' => false,
                'formatter' => 'imageFormatter',
            ],
            [
                'field' => 'log_meta',
                'searchable' => false,
                'sortable' => false,
                'visible' => true,
                'title' => trans('admin/hardware/table.changed'),
                'formatter' => 'changeLogFormatter',
            ],
            [
                'field' => 'remote_ip',
                'searchable' => false,
                'sortable' => false,
                'visible' => true,
                'title' => trans('admin/settings/general.login_ip'),
            ],
            [
                'field' => 'user_agent',
                'searchable' => false,
                'sortable' => false,
                'visible' => true,
                'title' => trans('admin/settings/general.login_user_agent'),
            ],
            [
                'field' => 'action_source',
                'searchable' => false,
                'sortable' => false,
                'visible' => true,
                'title' => trans('general.action_source'),
            ],
        ];

        return json_encode($layout);
    }

}