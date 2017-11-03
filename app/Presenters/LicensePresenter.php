<?php

namespace App\Presenters;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Gate;

/**
 * Class LicensePresenter
 * @package App\Presenters
 */
class LicensePresenter extends Presenter
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
            ], [
                "field" => "company",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/companies/table.title'),
                "visible" => false,
                "formatter" => "companiesLinkObjFormatter"
            ], [
                "field" => "name",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/licenses/table.title'),
                "formatter" => "licensesLinkFormatter"
            ], [
                "field" => "product_key",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/licenses/form.license_key'),
                "formatter" => "licensesLinkFormatter"
            ], [
                "field" => "expiration_date",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/licenses/form.expiration'),
                'formatter' => 'dateDisplayFormatter'
            ], [
                "field" => "license_email",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/licenses/form.to_email')
            ], [
                "field" => "license_name",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/licenses/form.to_name'),
            ], [
                "field" => "supplier",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.supplier'),
                "visible" => false,
                "formatter" => "suppliersLinkObjFormatter"
            ], [
                "field" => "manufacturer",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.manufacturer'),
                "formatter" => "manufacturersLinkObjFormatter",
            ], [
                "field" => "seats",
                "searchable" => false,
                "sortable" => true,
                "title" => trans('admin/accessories/general.total'),
            ], [
                "field" => "free_seats_count",
                "searchable" => false,
                "sortable" => true,
                "title" => trans('admin/accessories/general.remaining'),
            ], [
                "field" => "purchase_date",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.purchase_date'),
                'formatter' => 'dateDisplayFormatter'
            ], [
                "field" => "purchase_cost",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.purchase_cost'),
                "footerFormatter" => 'sumFormatter',
            ], [
                "field" => "purchase_order",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('admin/licenses/form.purchase_order'),
            ], [
                "field" => "order_number",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.order_number'),
            ], [
                "field" => "notes",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.notes'),
            ]
        ];

        $layout[] = [
            "field" => "checkincheckout",
            "searchable" => false,
            "sortable" => false,
            "switchable" => true,
            "title" => 'Checkin/Checkout',
            "visible" => true,
            "formatter" => "licensesInOutFormatter",
        ];

        $layout[] = [
            "field" => "actions",
            "searchable" => false,
            "sortable" => false,
            "switchable" => false,
            "title" => trans('table.actions'),
            "formatter" => "licensesActionsFormatter",
        ];


        return json_encode($layout);
    }


    /**
     * Link to this licenses Name
     * @return string
     */
    public function nameUrl()
    {
        return (string)link_to_route('licenses.show', $this->name, $this->id);
    }

    /**
     * Link to this licenses Name
     * @return string
     */
    public function fullName()
    {
        return $this->name;
    }


    /**
     * Link to this licenses serial
     * @return string
     */
    public function serialUrl()
    {
        return (string) link_to('/licenses/'.$this->id, mb_strimwidth($this->serial, 0, 50, "..."));
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('licenses.show', $this->id);
    }
}
