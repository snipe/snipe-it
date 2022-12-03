<?php

namespace Modules\RentOrders\Presenters;

use App\Presenters\Presenter;
use Illuminate\Database\Eloquent\Model;

/**
 * Class CategoryPresenter
 */
class RentOrdersPresenter extends Presenter
{
    public function __construct(Model $model)
    {
        $this->model = $model;
    }
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
                'title' => "Id",
                'visible' => true,
            ],[
                'field' => 'created_by',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => 'Creado Por:',
                'visible' => true,
                'formatter'=>"createdByFormatter",
            ],[
                'field' => 'assigned_to',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => 'Asignado A:',
                'visible' => true,
                'formatter'=>"assignedToFormatter",
            ],[
                'field' => 'status',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => "Estado",
                'visible' => true,
                'formatter'=>"statusFormatter",
            ],[
                'field' => 'created_at',
                'searchable' => true,
                'sortable' => true,
                'visible' => true,
                'title' => "Creado",
                'formatter' => 'createdAtFormatter',
            ],[
                'field' => 'updated_at',
                'searchable' => true,
                'sortable' => true,
                'visible' => true,'formatter' => 'dateDisplayFormatter',
                'title' => 'Actualizado',
                'formatter' => 'updatedAtFormatter',
            ],[
                'field' => 'actions',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => trans('table.actions'),
                'formatter' => 'rentOrderActionsFormatter',
            ],
        ];

        return json_encode($layout);
    }

    public function viewName()
    {
        return route('rentorders.show',$this->name, $this->id);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('rentorders.show', $this->id);
    }
}
