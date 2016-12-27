<?php

namespace App\Presenters;


use App\Helpers\Helper;
use Illuminate\Support\Facades\Gate;

/**
 * Class ConsumablePresenter
 * @package App\Presenters
 */
class ConsumablePresenter extends Presenter
{

    /**
     * Formatted JSON for data table.
     * @return array
     */
    public function forDataTable()
    {
        $actions = '<nobr>';
        if (Gate::allows('checkout', $this->model)) {
            $actions .= Helper::generateDatatableButton('checkout', route('checkout/consumable', $this->id), $this->numRemaining() > 0);
        }

        if (Gate::allows('update', $this->model)) {
            $actions .= Helper::generateDatatableButton('edit', route('consumables.edit', $this->id));
        }
        if (Gate::allows('delete', $this->model)) {
            $actions .= Helper::generateDatatableButton(
                'delete',
                route('consumables.destroy', $this->id),
                true, /* enabled */
                trans('admin/consumables/message.delete.confirm'),
                $this->name
            );
        }
        $actions .='</nobr>';

        $results = [
            'actions'       => $actions,
            'category'      => $this->categoryUrl(),
            'companyName'   => $this->companyUrl(),
            'id'            => $this->id,
            'item_no'       => $this->item_no,
            'location'      => $this->locationUrl(),
            'manufacturer'  => $this->manufacturerUrl(),
            'min_amt'       => $this->min_amt,
            'model_number'  => $this->model_number,
            'name'          => $this->nameUrl(),
            'numRemaining'  => $this->numRemaining(),
            'order_number'  => $this->order_number,
            'purchase_cost'  => Helper::formatCurrencyOutput($this->purchase_cost),
            'purchase_date'  => $this->purchase_date,
            'qty'           => $this->qty,
        ];
        return $results;
    }

    /**
     * Link to this consumables name
     * @return string
     */
    public function nameUrl()
    {
        return (string)link_to_route('consumables.show', $this->name, $this->id);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('consumables.show', $this->id);
    }
}
