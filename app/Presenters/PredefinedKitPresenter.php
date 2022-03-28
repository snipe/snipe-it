<?php

namespace App\Presenters;

/**
 * Class LicensePresenter
 */
class PredefinedKitPresenter extends Presenter
{
    /**
     * Json Column Layout for bootstrap table of kits
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
                'formatter' => 'kitsLinkFormatter',
            ],
        ];

        $layout[] = [
            'field' => 'checkincheckout',
            'searchable' => false,
            'sortable' => false,
            'switchable' => true,
            'title' => trans('general.checkin').'/'.trans('general.checkout'),
            'visible' => true,
            'formatter' => 'kitsInOutFormatter',
        ];

        $layout[] = [
            'field' => 'actions',
            'searchable' => false,
            'sortable' => false,
            'switchable' => false,
            'title' => trans('table.actions'),
            'formatter' => 'kitsActionsFormatter',
        ];

        return json_encode($layout);
    }

    /**
     * Json Column Layout for bootstrap table of kit models
     * @return string
     */
    public static function dataTableModels()
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
                'field' => 'pivot_id',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.id'),
                'visible' => false,
            ], [
                'field' => 'owner_id',
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
                'formatter' => 'modelsLinkFormatter',
            ], [
                'field' => 'quantity',
                'searchable' => false,
                'sortable' => false,
                'title' => trans('general.quantity'),
            ], [
                'field' => 'actions',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => trans('table.actions'),
                'formatter' => 'kits_modelsActionsFormatter',
            ],
        ];

        return json_encode($layout);
    }

    /**
     * Json Column Layout for bootstrap table of kit licenses
     * @return string
     */
    public static function dataTableLicenses()
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
                'field' => 'pivot_id',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.id'),
                'visible' => false,
            ], [
                'field' => 'owner_id',
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
                'formatter' => 'licensesLinkFormatter',
            ], [
                'field' => 'quantity',
                'searchable' => false,
                'sortable' => false,
                'title' => trans('general.quantity'),
            ], [
                'field' => 'actions',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => trans('table.actions'),
                'formatter' => 'kits_licensesActionsFormatter',
            ],
        ];

        return json_encode($layout);
    }

    /**
     * Json Column Layout for bootstrap table of kit accessories
     * @return string
     */
    public static function dataTableAccessories()
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
                'field' => 'pivot_id',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.id'),
                'visible' => false,
            ], [
                'field' => 'owner_id',
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
                'formatter' => 'accessoriesLinkFormatter',
            ], [
                'field' => 'quantity',
                'searchable' => false,
                'sortable' => false,
                'title' => trans('general.quantity'),
            ], [
                'field' => 'actions',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => trans('table.actions'),
                'formatter' => 'kits_accessoriesActionsFormatter',
            ],
        ];

        return json_encode($layout);
    }

    /**
     * Json Column Layout for bootstrap table of kit consumables
     * @return string
     */
    public static function dataTableConsumables()
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
                'field' => 'pivot_id',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.id'),
                'visible' => false,
            ], [
                'field' => 'owner_id',
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
                'formatter' => 'consumablesLinkFormatter',
            ], [
                'field' => 'quantity',
                'searchable' => false,
                'sortable' => false,
                'title' => trans('general.quantity'),
            ], [
                'field' => 'actions',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => trans('table.actions'),
                'formatter' => 'kits_consumablesActionsFormatter',
            ],
        ];

        return json_encode($layout);
    }

    /**
     * Link to this kit Name
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('kits.show', $this->name, $this->id);
    }

    /**
     * @return string
     */
    public function fullName()
    {
        return $this->name;
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('kits.show', $this->id);
    }
}
