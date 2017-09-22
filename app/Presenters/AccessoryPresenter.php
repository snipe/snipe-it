<?php
/**
 * Created by PhpStorm.
 * User: parallelgrapefruit
 * Date: 12/23/16
 * Time: 11:51 AM
 */

namespace App\Presenters;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Gate;

/**
 * Class AccessoryPresenter
 * @package App\Presenters
 */
class AccessoryPresenter extends Presenter
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
                "title" => trans('general.name'),
                "formatter" => "accessoriesLinkFormatter"
            ], [
                "field" => "category",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/accessories/general.accessory_category'),
                "formatter" => "categoriesLinkObjFormatter"
            ], [
                "field" => "model_number",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/models/table.modelnumber'),
                "formatter" => "accessoriesLinkFormatter"
            ], [
                "field" => "manufacturer",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.manufacturer'),
                "formatter" => "manufacturersLinkObjFormatter",
            ], [
                "field" => "location",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.location'),
                "formatter" => "locationsLinkObjFormatter",
            ], [
                "field" => "qty",
                "searchable" => false,
                "sortable" => false,
                "title" => trans('admin/accessories/general.total'),
            ],  [
                "field" => "min_qty",
                "searchable" => false,
                "sortable" => true,
                "title" => trans('general.min_amt'),
            ], [
                "field" => "remaining_qty",
                "searchable" => false,
                "sortable" => false,
                "title" => trans('admin/accessories/general.remaining'),
            ], [
                "field" => "purchase_date",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.purchase_date'),
                "formatter" => "dateDisplayFormatter"
            ], [
                "field" => "purchase_cost",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.purchase_cost'),
            ], [
                "field" => "order_number",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.order_number'),
            ],[
                "field" => "change",
                "searchable" => false,
                "sortable" => false,
                "visible" => true,
                "title" => trans('general.change'),
                "formatter" => "accessoriesInOutFormatter",
            ], [
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('table.actions'),
                "formatter" => "accessoriesActionsFormatter",
            ]
        ];

        return json_encode($layout);
    }

    /**
     * JSON representation of Accessory for datatable.
     * @return array
     */
    public function forDataTable()
    {

        $actions = '<nobr>';
        if (Gate::allows('checkout', $this->model)) {
            $actions .= Helper::generateDatatableButton(
                'checkout',
                route('checkout/accessory', $this->id),
                $this->numRemaining() > 0
            );
        }
        if (Gate::allows('update', $this->model)) {
            $actions .= Helper::generateDatatableButton('edit', route('accessories.edit', $this->id));
        }
        if (Gate::allows('delete', $this->model)) {
            $actions .= Helper::generateDatatableButton(
                'delete',
                route('accessories.destroy', $this->id),
                true, /*enabled*/
                trans('admin/accessories/message.delete.confirm'),
                $this->name
            );
        }
        $actions .= '</nobr>';

        $results = [];
        $results['name'] = $this->nameUrl();
        $results['category'] = '';
        if ($this->model->category) {
            $results['category'] = $this->model->category->present()->nameUrl();
        }
        $results['model_number'] = $this->model_number;
        $results['qty'] = $this->qty;
        $results['order_number'] = $this->order_number;
        $results['min_amt'] = $this->min_amt;
        $results['location'] = $this->model->location ? $this->model->location->present()->nameUrl() : '';
        $results['purchase_date'] = $this->purchase_date;
        $results['purchase_cost'] = Helper::formatCurrencyOutput($this->purchase_cost);
        $results['numRemaining'] = $this->numRemaining();
        $results['companyName'] = $this->model->company ? $this->model->company->present()->nameUrl() : '';
        $results['manufacturer'] = $this->model->manufacturer ? $this->model->manufacturer->present()->nameUrl() : '';
        $results['actions']       = $actions;

        return $results;
    }

    /**
     * Pregenerated link to this accessories view page.
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('accessories.show', $this->name, $this->id);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('accessories.show', $this->id);
    }

    public function name()
    {
        return $this->model->name;
    }
}
