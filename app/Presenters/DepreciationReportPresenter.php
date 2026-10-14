<?php

namespace App\Presenters;

use App\Enums\FileStorage;
use DateTime;
use Illuminate\Support\Facades\Storage;

/**
 * Class DepreciationReportPresenter
 */
class DepreciationReportPresenter extends Presenter
{
    /**
     * Json Column Layout for bootstrap table
     *
     * @return string
     */
    public static function dataTableLayout()
    {
        $layout = [
            [
                'field' => 'company',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'switchable' => true,
                'title' => trans('general.company'),
                'visible' => false,
            ], [
                'field' => 'category',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('general.category'),
                'visible' => true,
            ], [
                'field' => 'name',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'switchable' => false,
                // Match the import wizard's Name label so
                // downloads use importer's auto-mapper.
                'title' => trans('general.item_name_var', ['item' => trans('general.asset')]),
                'visible' => false,
            ], [
                'field' => 'asset_tag',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('general.asset_tag'),
                'visible' => true,
            ], [
                'field' => 'model',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('general.asset_model'),
                'visible' => true,
            ],  [
                'field' => 'model_number',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('admin/models/table.modelnumber'),
                'visible' => false,
            ], [
                'field' => 'serial',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('admin/hardware/form.serial'),
                'visible' => true,
            ], [
                'field' => 'depreciation',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('general.depreciation'),
                'visible' => true,
            ], [
                'field' => 'number_of_months',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('admin/depreciations/general.number_of_months'),
                'visible' => true,
            ],  [
                'field' => 'status',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('admin/hardware/table.status'),
                'visible' => true,
            ], [
                'field' => 'checked_out_to',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('admin/hardware/table.checkoutto'),
                'visible' => false,
            ], [
                'field' => 'location',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('admin/hardware/table.location'),
                'visible' => true,
            ],  [
                'field' => 'manufacturer',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('general.manufacturer'),
                'visible' => false,
            ], [
                'field' => 'supplier',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'title' => trans('general.supplier'),
                'visible' => false,
            ], [
                'field' => 'purchase_date',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'visible' => true,
                'title' => trans('general.purchase_date'),
                'formatter' => 'dateDisplayFormatter',
            ], [
                'field' => 'currency',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => false,
                'visible' => false,
                'title' => 'Currency',
            ], [
                'field' => 'purchase_cost',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'visible' => true,
                'title' => trans('general.purchase_cost'),
                'footerFormatter' => 'sumFormatter',
                'class' => 'text-right',
            ], [
                'field' => 'order_number',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'visible' => false,
                'title' => trans('general.order_number'),
            ],  [
                'field' => 'eol',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => false,
                'visible' => false,
                'title' => trans('general.eol'),
                'formatter' => 'dateDisplayFormatter',
            ], [
                'field' => 'book_value',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => false,
                'visible' => true,
                'title' => trans('admin/hardware/table.book_value'),
                'footerFormatter' => 'sumFormatter',
                'class' => 'text-right',
            ], [
                'field' => 'monthly_depreciation',
                'scope' => 'col',
                'searchable' => true,
                'sortable' => true,
                'visible' => true,
                'title' => trans('admin/hardware/table.monthly_depreciation'),
            ], [
                'field' => 'diff',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => false,
                'visible' => true,
                'title' => trans('admin/hardware/table.diff'),
                'footerFormatter' => 'sumFormatter',
                'class' => 'text-right',
            ], [
                'field' => 'warranty_expires',
                'scope' => 'col',
                'searchable' => false,
                'sortable' => false,
                'visible' => false,
                'title' => trans('admin/hardware/form.warranty_expires'),
                'formatter' => 'dateDisplayFormatter',
            ],
        ];

        return json_encode($layout);
    }

    /**
     * Generate html link to this items name.
     *
     * @return string
     */
    public function nameUrl()
    {
        if (auth()->user()->can('view', ['\App\Models\Depreciation', $this])) {
            return '<a href="'.route('depreciations.show', $this->id).'">'.e($this->display_name).'</a>';
        } else {
            return e($this->display_name);
        }
    }

    public function modelUrl()
    {
        if ($this->model->model) {
            return $this->model->model->present()->nameUrl();
        }

        return '';
    }

    /**
     * Generate img tag to this items image.
     *
     * @return mixed|string
     */
    public function imageUrl()
    {
        $imagePath = '';
        if ($this->image && ! empty($this->image)) {
            $imagePath = $this->image;
            $imageAlt = $this->name;
        } elseif ($this->model && ! empty($this->model->image)) {
            $imagePath = $this->model->image;
            $imageAlt = $this->model->name;
        }
        $url = config('app.url');
        if (! empty($imagePath)) {
            $imagePath = '<img src="'.$url.'/uploads/assets/'.$imagePath.' height="50" width="50" alt="'.$imageAlt.'">';
        }

        return $imagePath;
    }

    /**
     * Generate img tag to this items image.
     *
     * @return mixed|string
     */
    public function imageSrc()
    {
        $imagePath = '';
        if ($this->image && ! empty($this->image)) {
            $imagePath = $this->image;
        } elseif ($this->model && ! empty($this->model->image)) {
            $imagePath = $this->model->image;
        }
        if (! empty($imagePath)) {
            return Storage::disk('public')->url(FileStorage::Assets->publicPath().e($imagePath));
        }

        return $imagePath;
    }

    /**
     * Get Displayable Name
     *
     * @return string
     *
     * @todo this should be factored out - it should be subsumed by fullName (below)
     *
     **/
    public function name()
    {
        return $this->fullName;
    }

    /**
     * Helper for notification polymorphism.
     *
     * @return mixed
     */
    public function fullName()
    {
        $str = '';

        // Asset name
        if ($this->model->name) {
            $str .= $this->model->name;
        }

        // Asset tag
        if ($this->asset_tag) {
            $str .= ' ('.$this->model->asset_tag.')';
        }

        // Asset Model name
        if ($this->model->model) {
            $str .= ' - '.$this->model->model->name;
        }

        return $str;
    }

    /**
     * Returns the date this item hits EOL.
     *
     * @return false|string
     */
    public function eol_date()
    {

        if (($this->purchase_date) && ($this->model->model) && ($this->model->model->eol)) {
            $date = date_create($this->purchase_date);
            date_add($date, date_interval_create_from_date_string($this->model->model->eol.' months'));

            return date_format($date, 'Y-m-d');
        }

    }

    /**
     * How many months until this asset hits EOL.
     *
     * @return null
     */
    public function months_until_eol()
    {

        $today = date('Y-m-d');
        $d1 = new DateTime($today);
        $d2 = new DateTime($this->eol_date());

        if ($this->eol_date() > $today) {
            $interval = $d2->diff($d1);
        } else {
            $interval = null;
        }

        return $interval;
    }

    /**
     * @return string
     *                This handles the status label "meta" status of "deployed" if
     *                it's assigned. Should maybe deprecate.
     */
    public function statusMeta()
    {
        if ($this->model->assigned) {
            return 'deployed';
        }

        return $this->model->status->getStatuslabelType();
    }

    /**
     * @return string
     *                This handles the status label "meta" status of "deployed" if
     *                it's assigned. Should maybe deprecate.
     */
    public function statusText()
    {
        if ($this->model->assigned) {
            return trans('general.deployed');
        }

        return $this->model->status->name;
    }

    /**
     * @return string
     *                This handles the status label "meta" status of "deployed" if
     *                it's assigned. Results look like:
     *
     * (if assigned and the status label is "Ready to Deploy"):
     * (Deployed)
     *
     * (f assigned and status label is not "Ready to Deploy":)
     * Deployed (Another Status Label)
     *
     * (if not deployed:)
     * Another Status Label
     */
    public function fullStatusText()
    {
        // Make sure the status is valid
        if ($this->status) {

            // If the status is assigned to someone or something...
            if ($this->model->assigned) {

                // If it's assigned and not set to the default "ready to deploy" status
                if ($this->status->name != trans('general.ready_to_deploy')) {
                    return trans('general.deployed').' ('.$this->model->status->name.')';
                }

                // If it's assigned to the default "ready to deploy" status, just
                // say it's deployed - otherwise it's confusing to have a status that is
                // both "ready to deploy" and deployed at the same time.
                return trans('general.deployed');
            }

            // Return just the status name
            return $this->model->status->name;
        }

        // This status doesn't seem valid - either data has been manually edited or
        // the status label was deleted.
        return 'Invalid status';
    }

    /**
     * Date the warantee expires.
     *
     * @return false|string
     */
    public function warranty_expires()
    {
        if (($this->purchase_date) && ($this->warranty_months)) {
            $date = date_create($this->purchase_date);
            date_add($date, date_interval_create_from_date_string($this->warranty_months.' months'));

            return date_format($date, 'Y-m-d');
        }

        return false;
    }

    /**
     * Url to view this item.
     *
     * @return string
     */
    public function viewUrl()
    {
        return route('hardware.show', $this->id);
    }

    public function glyph()
    {
        return '<x-icon type="reports" class="text-orange" />';
    }
}
