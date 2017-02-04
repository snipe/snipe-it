<?php
namespace App\Presenters;

use App\Helpers\Helper;
use App\Models\SnipeModel;
use DateTime;
use Illuminate\Support\Facades\Gate;

/**
 * Class AssetPresenter
 * @package App\Presenters
 */
class AssetPresenter extends Presenter
{

    /**
     * Json Column Layout for bootstrap table
     * @return string
     */
    public static function dataTableLayout()
    {
        $layout = [
            [
                "field" => "company",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => '',
                "visible" => true,
                "formatter" => "companiesLinkObjFormatter"
            ], [
                "field" => "name",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/accessories/table.title'),
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
     * Generate html link to this items name.
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('hardware.show', e($this->name), $this->id);
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
     * @return mixed|string
     */
    public function imageUrl()
    {
        $imagePath = '';
        if ($this->image && !empty($this->image)) {
            $imagePath = $this->image;
        } elseif ($this->model && !empty($this->model->image)) {
            $imagePath = $this->model->image;
        }
        $url = config('app.url');
        if (!empty($imagePath)) {
            $imagePath = "<img src='{$url}/uploads/assets/{$imagePath}' height=50 width=50>";
        }
        return $imagePath;
    }

    /**
     * Get Displayable Name
     * @return string
     **/
    public function name()
    {
        if (empty($this->name)) {
            if (isset($this->model)) {
                return $this->model->name.' ('.$this->asset_tag.')';
            }
            return $this->asset_tag;
        } else {
            return $this->name.' ('.$this->asset_tag.')';
        }
    }

    /**
     * Helper for notification polymorphism.
     * @return mixed
     */
    public function fullName()
    {
        return $this->name();
    }
    /**
     * Returns the date this item hits EOL.
     * @return false|string
     */
    public function eol_date()
    {

        if (( $this->purchase_date ) && ( $this->model )) {
            $date = date_create($this->purchase_date);
            date_add($date, date_interval_create_from_date_string($this->model->model->eol . ' months'));
            return date_format($date, 'Y-m-d');
        }

    }

    /**
     * How many months until this asset hits EOL.
     * @return null
     */
    public function months_until_eol()
    {

        $today = date("Y-m-d");
        $d1    = new DateTime($today);
        $d2    = new DateTime($this->eol_date());

        if ($this->eol_date() > $today) {
            $interval = $d2->diff($d1);
        } else {
            $interval = null;
        }

        return $interval;
    }

    public function statusText()
    {
        if ($this->model->assignedTo) {
            return trans('general.deployed');
        }
        return $this->model->assetstatus->name;
    }
    /**
     * Date the warantee expires.
     * @return false|string
     */
    public function warrantee_expires()
    {
        $date = date_create($this->purchase_date);
        date_add($date, date_interval_create_from_date_string($this->warranty_months . ' months'));
        return date_format($date, 'Y-m-d');
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('hardware.show', $this->id);
    }

    public function glyph()
    {
        return '<i class="fa fa-barcode"></i>';
    }
}
