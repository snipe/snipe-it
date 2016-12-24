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
                "field" => "companyName",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/companies/table.title'),
                "visible" => false,
            ], [
                "field" => "name",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/accessories/table.title'),
            ], [
                "field" => "category",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/accessories/general.accessory_category'),
            ], [
                "field" => "model_number",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/models/table.modelnumber'),
            ], [
                "field" => "manufacturer",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.manufacturer'),
            ], [
                "field" => "location",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.location'),
            ], [
                "field" => "qty",
                "searchable" => false,
                "sortable" => false,
                "title" => trans('admin/accessories/general.total'),
            ], [
                "field" => "purchase_date",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.purchase_date'),
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
            ], [
                "field" => "min_amt",
                "searchable" => false,
                "sortable" => true,
                "title" => trans('general.min_amt'),
            ], [
                "field" => "numRemaining",
                "searchable" => false,
                "sortable" => false,
                "title" => trans('admin/accessories/general.remaining'),
            ], [
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('table.actions'),
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
            $actions .= Helper::generateDatatableButton('edit', route('accessories.update', $this->id));
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
        $results['category'] = $this->categoryUrl();
        $results['model_number'] = $this->model_number;
        $results['qty'] = $this->qty;
        $results['order_number'] = $this->order_number;
        $results['min_amt'] = $this->min_amt;
        $results['location'] = $this->locationUrl();
        $results['purchase_date'] = $this->purchase_date;
        $results['purchase_cost'] = Helper::formatCurrencyOutput($this->purchase_cost);
        $results['numRemaining'] = $this->numRemaining();
        $results['companyName'] = $this->companyUrl();
        $results['manufacturer'] = $this->manufacturerUrl();
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

    
}
