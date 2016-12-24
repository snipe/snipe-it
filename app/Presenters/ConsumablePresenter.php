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
            'id'            => $this->id,
            'name'          => $this->nameUrl(),
            'location'      => ($this->model->location) ? $this->model->location->present()->nameUrl() : '',
            'min_amt'           => $this->min_amt,
            'qty'           => $this->qty,
            'manufacturer'  => ($this->model->manufacturer) ? $this->model->manufacturer->present()->nameUrl() : '',
            'model_number'      => $this->model_number,
            'item_no'       => $this->item_no,
            'category'      => ($this->model->category) ? $this->model->category->present()->nameUrl() : 'Missing category',
            'order_number'  => $this->order_number,
            'purchase_date'  => $this->purchase_date,
            'purchase_cost'  => Helper::formatCurrencyOutput($this->purchase_cost),
            'numRemaining'  => $this->numRemaining(),
            'actions'       => $actions,
            'companyName'   => $this->model->company ? $this->model->company->present()->nameUrl() : '',
        ];
        return $results;
    }

    /**
     * Link to this consumables name
     * @return string
     */
    private function nameUrl()
    {
        return (string)link_to_route('consumables.show', $this->name, $this->id);
    }
}
