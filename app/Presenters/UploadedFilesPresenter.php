<?php

namespace App\Presenters;

/**
 * Class AccessoryPresenter
 */
class UploadedFilesPresenter extends Presenter
{
    /**
     * Json Column Layout for bootstrap table.
     *
     * @param  array  $hide_fields  Column field names to omit from the layout.
     *                              Callers pass `['available_actions']` for
     *                              read-only views (e.g. the model files tab
     *                              for users without models.files) so the
     *                              delete button doesn't render at all.
     * @return string
     */
    public static function dataTableLayout($hide_fields = [])
    {

        $layout = [
            [
                'field' => 'id',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.id'),
                'visible' => false,
            ],
            [
                'field' => 'icon',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => trans('general.type'),
                'visible' => true,
                'formatter' => 'iconFormatter',
            ],
            [
                'field' => 'image',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => false,
                'switchable' => true,
                'title' => trans('general.image'),
                'visible' => true,
                'formatter' => 'filePreviewFormatter',
            ],
            [
                'field' => 'filename',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.file_name'),
                'visible' => true,
                'formatter' => 'fileNameFormatter',
            ],
            [
                'field' => 'download',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => false,
                'switchable' => true,
                'title' => trans('general.download'),
                'visible' => true,
                'formatter' => 'fileDownloadButtonsFormatter',
                'printIgnore' => true,
                'class' => 'hidden-print',
            ],
            [
                'field' => 'note',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.notes'),
                'visible' => true,
            ],
            [
                'field' => 'created_by',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('general.created_by'),
                'visible' => true,
                'formatter' => 'usersLinkObjFormatter',
            ],
            [
                'field' => 'created_at',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.created_at'),
                'visible' => true,
                'formatter' => 'dateDisplayFormatter',
            ],
        ];

        if (! in_array('available_actions', $hide_fields)) {
            $layout[] = [
                'field' => 'available_actions',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => trans('table.actions'),
                'visible' => true,
                'formatter' => 'deleteUploadFormatter',
                'printIgnore' => true,
                'class' => 'hidden-print',
            ];
        }

        return json_encode($layout);
    }
}
