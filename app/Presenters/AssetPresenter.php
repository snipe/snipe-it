<?php
namespace App\Presenters;

use App\Models\CustomField;
use DateTime;

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
                "field" => "checkbox",
                "checkbox" => true
            ], [
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
                "title" => trans('general.company'),
                "visible" => false,
                "formatter" => 'assetCompanyObjFilterFormatter'
            ], [
                "field" => "name",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/hardware/form.name'),
                "visible" => true,
                "formatter" => "hardwareLinkFormatter"
            ], [
                "field" => "image",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/hardware/table.image'),
                "visible" => true,
                "formatter" => "imageFormatter"
            ], [
                "field" => "asset_tag",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/hardware/table.asset_tag'),
                "visible" => true,
                "formatter" => "hardwareLinkFormatter"
            ], [
                "field" => "serial",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/hardware/form.serial'),
                "visible" => true,
                "formatter" => "hardwareLinkFormatter"
            ],  [
                "field" => "model",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/hardware/form.model'),
                "visible" => true,
                "formatter" => "modelsLinkObjFormatter"
            ], [
                "field" => "model_number",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/models/table.modelnumber'),
                "visible" => false
            ], [
                "field" => "category",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.category'),
                "visible" => true,
                "formatter" => "categoriesLinkObjFormatter"
            ], [
                "field" => "status_label",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/hardware/table.status'),
                "visible" => true,
                "formatter" => "statuslabelsLinkObjFormatter"
            ], [
                "field" => "assigned_to",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/hardware/form.checkedout_to'),
                "visible" => true,
                "formatter" => "polymorphicItemFormatter"
            ], [
                "field" => "employee_number",
                "searchable" => false,
                "sortable" => false,
                "title" => trans('admin/users/table.employee_num'),
                "visible" => false,
                "formatter" => "employeeNumFormatter"
            ],[
                "field" => "location",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/hardware/table.location'),
                "visible" => true,
                "formatter" => "deployedLocationFormatter"
            ],  [
                "field" => "manufacturer",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.manufacturer'),
                "visible" => false,
                "formatter" => "manufacturersLinkObjFormatter"
            ],[
                "field" => "supplier",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('general.supplier'),
                "visible" => false,
                "formatter" => "suppliersLinkObjFormatter"
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
                "footerFormatter" => 'sumFormatter',
            ], [
                "field" => "order_number",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.order_number'),
                'formatter' => "orderNumberObjFilterFormatter"
            ], [
                "field" => "warranty_months",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('admin/hardware/form.warranty')
            ],[
                "field" => "warranty_expires",
                "searchable" => false,
                "sortable" => false,
                "visible" => false,
                "title" => 'Warranty Expires',
                "formatter" => "dateDisplayFormatter"
            ],[
                "field" => "notes",
                "searchable" => true,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.notes'),
            ], [
                "field" => "created_at",
                "searchable" => false,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.created_at'),
                "formatter" => "dateDisplayFormatter"
            ], [
                "field" => "updated_at",
                "searchable" => false,
                "sortable" => true,
                "visible" => false,
                "title" => trans('general.updated_at'),
                "formatter" => "dateDisplayFormatter"
            ], [
                "field" => "last_checkout",
                "searchable" => false,
                "sortable" => true,
                "visible" => false,
                "title" => trans('admin/hardware/table.checkout_date'),
                "formatter" => "dateDisplayFormatter"
            ], [
                "field" => "expected_checkin",
                "searchable" => false,
                "sortable" => true,
                "visible" => false,
                "title" => trans('admin/hardware/form.expected_checkin'),
                "formatter" => "dateDisplayFormatter"
            ],
        ];

        // This looks complicated, but we have to confirm that the custom fields exist in custom fieldsets
        // *and* those fieldsets are associated with models, otherwise we'll trigger
        // javascript errors on the bootstrap tables side of things, since we're asking for properties
        // on fields that will never be passed through the REST API since they're not associated with
        // models. We only pass the fieldsets that pertain to each asset (via their model) so that we
        // don't junk up the REST API with tons of custom fields that don't apply

        $fields =  CustomField::whereHas('fieldset', function ($query) {
            $query->whereHas('models');
        })->get();

        foreach ($fields as $field) {
            $layout[] = [
                "field" => 'custom_fields.'.$field->convertUnicodeDbSlug(),
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => ($field->field_encrypted=='1') ?'<i class="fa fa-lock"></i> '.e($field->name) : e($field->name),
                "formatter" => "customFieldsFormatter"
            ];

        }

        $layout[] = [
            "field" => "checkincheckout",
            "searchable" => false,
            "sortable" => false,
            "switchable" => true,
            "title" => 'Checkin/Checkout',
            "visible" => true,
            "formatter" => "hardwareInOutFormatter",
        ];
        
        $layout[] = [
            "field" => "actions",
            "searchable" => false,
            "sortable" => false,
            "switchable" => false,
            "title" => trans('table.actions'),
            "formatter" => "hardwareActionsFormatter",
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
     * Generate img tag to this items image.
     * @return mixed|string
     */
    public function imageSrc()
    {
        $imagePath = '';
        if ($this->image && !empty($this->image)) {
            $imagePath = $this->image;
            return 'poop';
        } elseif ($this->model && !empty($this->model->image)) {
            $imagePath = $this->model->image;
            return 'fart';
        }
        if (!empty($imagePath)) {
            return config('app.url').'/uploads/assets/'.$imagePath;
        }
        return $imagePath;
    }

    /**
     * Get Displayable Name
     * @return string
     **/
    public function name()
    {
        
        if (empty($this->model->name)) {
            if (isset($this->model->model)) {
                return $this->model->model->name.' ('.$this->model->asset_tag.')';
            }
            return $this->model->asset_tag;
        } else {
            return $this->model->name . ' (' . $this->model->asset_tag . ')';
        }

    }

    /**
     * Helper for notification polymorphism.
     * @return mixed
     */
    public function fullName()
    {
        $str = '';
        if ($this->model->name) {
            $str .= $this->name;
        }

        if ($this->asset_tag) {
            $str .= ' ('.$this->model->asset_tag.')';
        }
        if ($this->model->model) {
            $str .= ' - '.$this->model->model->name;
        }
        return $str;
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

    /**
     * @return string
     * This handles the status label "meta" status of "deployed" if
     * it's assigned. Should maybe deprecate.
     */
    public function statusMeta()
    {
        if ($this->model->assigned) {
            return strtolower(trans('general.deployed'));
        }
        return $this->model->assetstatus->getStatuslabelType();
    }

    /**
     * @return string
     * This handles the status label "meta" status of "deployed" if
     * it's assigned. Should maybe deprecate.
     */
    public function statusText()
    {
        if ($this->model->assigned) {
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

