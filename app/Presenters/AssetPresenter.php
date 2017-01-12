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

    public function detail() {
        return $this->model;
    }

    /**
     * Bootstrap Table Bits
     * @param array $all_custom_fields Preloaded cache of custom fields
     * @return mixed
     */
    public function forDataTable($all_custom_fields)
    {
        // Actions

        $inout = '';
        $actions = '<div style="white-space: nowrap;">';
        if ($this->model->deleted_at=='') {
            if (Gate::allows('create', $this->model)) {
                $actions .= Helper::generateDatatableButton('clone', route('clone/hardware', $this->model->id));
            }
            if (Gate::allows('update', $this->model)) {
                $actions .= Helper::generateDatatableButton('edit', route('hardware.edit', $this->model->id));
            }

            if (Gate::allows('delete', $this->model)) {
                $actions .= Helper::generateDatatableButton(
                    'delete',
                    route('hardware.destroy', $this->model->id),
                    true, /*enabled*/
                    trans('admin/hardware/message.delete.confirm'),
                    $this->model->asset_tag
                );
            }
        } elseif ($this->model->model->deleted_at=='') {
            $actions .= Helper::generateDatatableButton('restore', route('restore/hardware', $this->model->id));
        }

        $actions .= '</div>';

        if (($this->model->availableForCheckout())) {
            if (Gate::allows('checkout', $this->model)) {
                $inout = '<a href="' . route(
                    'checkout/hardware',
                    $this->model->id
                ) . '" class="btn btn-info btn-sm" title="Checkout this asset to a user" data-toggle="tooltip">' . trans('general.checkout') . '</a>';
            }

        } else {
            if (!empty($this->model->assigned_to)) {
                if (Gate::allows('checkin', $this->model)) {
                    $inout = '<a href="' . route(
                        'checkin/hardware',
                        $this->model->id
                    ) . '" class="btn btn-primary btn-sm" title="Checkin this asset" data-toggle="tooltip">' . trans('general.checkin') . '</a>';
                }
            }
        }

        $results = [];
        $results['checkbox'] = '<div class="text-center"><input type="checkbox" name="edit_asset['.$this->id.']" class="one_required"></div>';
        $results['id']        = $this->id;

        $results['name'] = $this->nameUrl();
        $results['asset_tag'] = $this->assetTagUrl();
        $results['serial'] = $this->serial;
        $results['image'] = $this->imageUrl();
        // Presets for when conditionals fail.
        $results['model'] = $this->modelUrl();
        $results['model_number'] = $this->model->model_number;
        $results['category'] = $this->categoryUrl();
        $results['manufacturer'] = $this->manufacturerUrl();
        $results['status_label'] = '';
        $results['assigned_to'] = '';
        if ($assigned = $this->model->assignedTo) {
            $results['assigned_to'] = $assigned->present()->glyph() . ' ' . $assigned->present()->nameUrl();
        }
        $results['status_label'] = $this->statusText();
        $results['location'] = '';
        if (isset($assigned) and !empty($assignedLoc = $this->model->assetLoc)) {
            $results['location'] = $assignedLoc->present()->nameUrl();
        } elseif (!empty($this->model->defaultLoc)) {
            $results['location'] = $this->model->defaultLoc->present()->nameUrl();
        }

        $results['eol'] = $this->eol_date() ?: '';
        $results['purchase_cost'] = Helper::formatCurrencyOutput($this->purchase_cost);
        $results['purchase_date'] = $this->purchase_date ?: '';
        $results['notes'] = $this->notes;
        $results['order_number'] = $this->order_number;
        if (!empty($this->order_number)) {
            $results['order_number'] = link_to_route('hardware.index', $this->order_number, ['order_number' => $this->order_number]);
        }

        $results['last_checkout'] = $this->last_checkout ?: '';
        $results['expected_checkin'] = $this->expected_checkin ?: '';
        $results['created_at'] = '';
        if (!empty($this->created_at)) {
            $results['created_at'] = $this->created_at->format('F j, Y h:iA');
        }
        $results['companyName'] = $this->companyUrl();
        $results['actions'] = $actions;
        $results['change'] = $inout;


        // Custom Field bits
        foreach ($all_custom_fields as $field) {
            $column_name = $field->db_column_name();

            if ($field->isFieldDecryptable($this->model->{$column_name})) {

                if (Gate::allows('admin')) {
                    if (($field->format=='URL') && ($this->model->{$column_name}!='')) {
                        $row[$column_name] = '<a href="'.Helper::gracefulDecrypt($field, $this->model->{$column_name}).'" target="_blank">'.Helper::gracefulDecrypt($field, $this->model->{$column_name}).'</a>';
                    } else {
                        $row[$column_name] = Helper::gracefulDecrypt($field, $this->model->{$column_name});
                    }

                } else {
                    $row[$field->db_column_name()] = strtoupper(trans('admin/custom_fields/general.encrypted'));
                }
            } else {
                if (($field->format=='URL') && ($this->model->{$field->db_column_name()}!='')) {
                    $row[$field->db_column_name()] = '<a href="'.$this->model->{$field->db_column_name()}.'" target="_blank">'.$this->model->{$field->db_column_name()}.'</a>';
                } else {
                    $row[$field->db_column_name()] = e($this->model->{$field->db_column_name()});
                }
            }

        }

        return $results;
    }

    /**
     * Generate html link to this items asset tag
     * @return string
     */
    public function assetTagUrl()
    {
        return (string) link_to_route('hardware.show', e($this->asset_tag), $this->id);
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
