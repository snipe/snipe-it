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
     * JSON representation of this license for data table.
     * @return array
     */
    public function forDataTable()
    {
        $actions = '<span style="white-space: nowrap;">';

        if (Gate::allows('checkout', License::class)) {
            $actions .= Helper::generateDatatableButton(
                'checkout',
                route('licenses.freecheckout', $this->id),
                $this->remaincount() > 0
            );
        }

        if (Gate::allows('create', $this->model)) {
            $actions .= Helper::generateDatatableButton('clone', route('clone/license', $this->id));
        }
        if (Gate::allows('update', $this->model)) {
            $actions .= Helper::generateDatatableButton('edit', route('licenses.edit', $this->id));
        }
        if (Gate::allows('delete', $this->model)) {
            $actions .= Helper::generateDatatableButton(
                'delete',
                route('licenses.destroy', $this->id),
                true, /*enabled*/
                trans('admin/licenses/message.delete.confirm'),
                $this->name
            );
        }
        $actions .='</span>';

        $results = [
            'actions'           => $actions,
            'company'           => $this->companyUrl(),
            'expiration_date'   => $this->expiration_date,
            'id'                => $this->id,
            'license_email'     => $this->license_email,
            'license_name'      => $this->license_name,
            'manufacturer'      => $this->manufacturerUrl(),
            'name'              => $this->nameUrl(),
            'notes'             => $this->notes,
            'order_number'      => $this->order_number,
            'purchase_cost'     => Helper::formatCurrencyOutput($this->purchase_cost),
            'purchase_date'     => $this->purchase_date,
            'purchase_order'    => $this->purchase_order,
            'remaining'         => $this->remaincount(),
            'serial'            => $this->serialUrl(),
            'totalSeats'        => $this->model->licenseSeatsCount,
        ];

        return $results;
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
     * Link to this licenses serial
     * @return string
     */
    public function serialUrl()
    {
        return (string) link_to('/licenses/'.$this->id, mb_strimwidth($this->serial, 0, 50, "..."));
    }
}
