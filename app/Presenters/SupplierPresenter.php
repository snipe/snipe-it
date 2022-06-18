<?php

namespace App\Presenters;

/**
 * Class ManufacturerPresenter
 */
class SupplierPresenter extends Presenter
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
            ],
            [
                'field' => 'name',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('admin/suppliers/table.name'),
                'visible' => true,
                'formatter' => 'suppliersLinkFormatter',
            ],
            [
                'field' => 'image',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.image'),
                'visible' => true,
                'formatter' => 'imageFormatter',
            ],
            [
                'field' => 'address',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('admin/suppliers/table.address'),
                'visible' => true,
            ],
            [
                'field' => 'contact',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('admin/suppliers/table.contact'),
                'visible' => true,
            ],
            [
                'field' => 'email',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('admin/suppliers/table.email'),
                'visible' => true,
                'formatter' => 'emailFormatter',
            ],
            [
                'field' => 'phone',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('admin/suppliers/table.phone'),
                'visible' => true,
                'formatter' => 'phoneFormatter',
            ],
            [
                'field' => 'fax',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('admin/suppliers/table.fax'),
                'visible' => false,
            ],
            [
                'field' => 'url',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('admin/suppliers/table.url'),
                'visible' => false,
                'formatter' => 'linkFormatter',
            ],
            [
                'field' => 'assets_count',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => ' <span class="hidden-md hidden-lg">Assets</span>'
                    .'<span class="hidden-xs"><i class="fas fa-barcode fa-lg"></i></span>',
                'visible' => true,
            ],
            [
                'field' => 'licenses_count',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => ' <span class="hidden-md hidden-lg">Licenses</span>'
                    .'<span class="hidden-xs"><i class="far fa-save fa-lg"></i></span>',
                'visible' => true,
            ],
            [
                'field' => 'accessories_count',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => ' <span class="hidden-md hidden-lg">Accessories</span>'
                    .'<span class="hidden-xs"><i class="far fa-keyboard fa-lg"></i></span>',
                'visible' => true,
            ],
            [
                'field' => 'consumables_count',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => ' <span class="hidden-md hidden-lg">Consumables</span>'
                    .'<span class="hidden-xs"><i class="fas fa-tint fa-lg"></i></span>',
                'visible' => true,
            ],
            [
                'field' => 'components_count',
                'searchable' => false,
                'sortable' => true,
                'switchable' => true,
                'title' => ' <span class="hidden-md hidden-lg">Components</span>'
                    .'<span class="hidden-xs"><i class="far fa-hdd fa-lg"></i></span>',
                'visible' => true,
            ],
            [
                'field' => 'actions',
                'searchable' => false,
                'sortable' => false,
                'switchable' => false,
                'title' => trans('table.actions'),
                'visible' => true,
                'formatter' => 'suppliersActionsFormatter',
            ],
        ];

        return json_encode($layout);
    }

    /**
     * Link to this manufacturers name
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('manufacturers.show', $this->name, $this->id);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('manufacturers.show', $this->id);
    }
}