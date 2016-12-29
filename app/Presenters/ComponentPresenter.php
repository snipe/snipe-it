<?php

namespace App\Presenters;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Gate;

/**
 * Class ComponentPresenter
 * @package App\Presenters
 */
class ComponentPresenter extends Presenter
{

    /**
     * Formatted JSON string for data table.
     * @return array
     */
    public function forDataTable()
    {
        $actions = '<nobr>';
        if (Gate::allows('checkout', $this->model)) {
            $actions .= Helper::generateDatatableButton('checkout', route('checkout/component', $this->id), $this->numRemaining() > 0);
        }

        if (Gate::allows('update', $this->model)) {
            $actions .= Helper::generateDatatableButton('edit', route('components.edit', $this->id));
        }

        if (Gate::allows('delete', $this->model)) {
            $actions .= Helper::generateDatatableButton(
                'delete',
                route('components.destroy', $this->id),
                true, /* enabled */
                trans('admin/components/message.delete.confirm'),
                $this->name
            );
        }

        $actions .='</nobr>';

        $results = [
            'checkbox'      =>'<div class="text-center"><input type="checkbox" name="component['.$this->id.']" class="one_required"></div>',
            'id'            => $this->id,
            'name'          => $this->nameUrl(),
            'serial_number'          => $this->serial,
            'location'      => $this->locationUrl(),
            'qty'           => number_format($this->qty),
            'min_amt'       => e($this->min_amt),
            'category'      => $this->categoryUrl(),
            'order_number'  => $this->order_number,
            'purchase_date' => $this->purchase_date,
            'purchase_cost' => Helper::formatCurrencyOutput($this->purchase_cost),
            'numRemaining'  => $this->numRemaining(),
            'actions'       => $actions,
            'companyName'   => $this->companyUrl(),
        ];

        return $results;
    }

    /**
     * Link to this components name
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('components.show', $this->name, $this->id);
    }
    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('components.show', $this->id);
    }
}
