<?php

namespace App\Presenters;


/**
 * Class ComponentPresenter
 * @package App\Presenters
 */
class ConsumablePresenter extends Presenter
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
                "visible" => false
            ],
            [
                "field" => "company",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.company'),
                "visible" => false,
                "formatter" => 'companiesLinkObjFormatter',
            ],
            [
                "field" => "name",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.name'),
                "visible" => true,
                "formatter" => 'consumablesLinkFormatter',
            ],
            [
                "field" => "image",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.image'),
                "visible" => false,
                "formatter" => 'imageFormatter',
            ], [
                "field" => "category",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.category'),
                "formatter" => "categoriesLinkObjFormatter"
            ],[
                "field" => "model_number",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.model_no'),
            ],[
                "field" => "item_no",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/consumables/general.item_no')
            ], [
                "field" => "qty",
                "searchable" => false,
                "sortable" => false,
                "title" => trans('admin/components/general.total'),
                "visible" => true,
            ], [
                "field" => "remaining",
                "searchable" => false,
                "sortable" => false,
                "title" => trans('admin/components/general.remaining'),
                "visible" => true,
            ], [
                "field" => "min_amt",
                "searchable" => false,
                "sortable" => false,
                "title" => trans('general.min_amt'),
                "visible" => true,
            ],  [
                "field" => "location",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.location'),
                "formatter" => "locationsLinkObjFormatter"
            ], [
                "field" => "manufacturer",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.manufacturer'),
                "visible" => false,
                "formatter" => "manufacturersLinkObjFormatter"
            ], [
                "field" => "order_number",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.order_number'),
                "visible" => true,
            ],[
                "field" => "purchase_date",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.purchase_date'),
                "visible" => true,
                "formatter" => "dateDisplayFormatter",
            ],[
                "field" => "purchase_cost",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.purchase_cost'),
                "visible" => true,
                "footerFormatter" => 'sumFormatter',
            ],[
                "field" => "change",
                "searchable" => false,
                "sortable" => false,
                "visible" => true,
                "title" => trans('general.change'),
                "formatter" => "consumablesInOutFormatter",
            ], [
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('table.actions'),
                "visible" => true,
                "formatter" => "consumablesActionsFormatter",
            ]
        ];

        return json_encode($layout);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('consumables.show', $this->id);
    }

    /**
     * Generate html link to this items name.
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('consumables.show', e($this->name), $this->id);
    }


}
