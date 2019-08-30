<?php

namespace App\Presenters;

use App\Helpers\Helper;

/**
 * Class ManufacturerPresenter
 * @package App\Presenters
 */
class ManufacturerPresenter extends Presenter
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
                "field" => "name",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/manufacturers/table.name'),
                "visible" => true,
                "formatter" => "manufacturersLinkFormatter"
            ],
            [
                "field" => "image",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.image'),
                "visible" => true,
                "formatter" => "imageFormatter"
            ],
            [
                "field" => "url",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/manufacturers/table.url'),
                "visible" => true,
                "formatter" => "linkFormatter"
            ],
            [
                "field" => "support_url",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/manufacturers/table.support_url'),
                "visible" => true,
                "formatter" => "linkFormatter"
            ],

            [
                "field" => "support_phone",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/manufacturers/table.support_phone'),
                "visible" => true,
                "formatter" => "phoneFormatter"
            ],

            [
                "field" => "support_email",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/manufacturers/table.support_email'),
                "visible" => true,
                "formatter" => "emailFormatter"
            ],

            [
                "field" => "assets_count",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => ' <span class="hidden-md hidden-lg">Assets</span>'
                    .'<span class="hidden-xs"><i class="fa fa-barcode fa-lg"></i></span>',
                "visible" => true,
            ],
            [
                "field" => "licenses_count",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => ' <span class="hidden-md hidden-lg">Licenses</span>'
                    .'<span class="hidden-xs"><i class="fa fa-floppy-o fa-lg"></i></span>',
                "visible" => true,
            ],
            [
                "field" => "consumables_count",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => ' <span class="hidden-md hidden-lg">Consumables</span>'
                    .'<span class="hidden-xs"><i class="fa fa-tint fa-lg"></i></span>',
                "visible" => true,
            ],
            [
                "field" => "accessories_count",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => ' <span class="hidden-md hidden-lg">Accessories</span>'
                    .'<span class="hidden-xs"><i class="fa fa-keyboard-o fa-lg"></i></span>',
                "visible" => true,
            ],
            [
                "field" => "created_at",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.created_at'),
                "visible" => false,
                'formatter' => 'dateDisplayFormatter'
            ],

            [
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('table.actions'),
                "visible" => true,
                "formatter" => "manufacturersActionsFormatter",
            ]
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
