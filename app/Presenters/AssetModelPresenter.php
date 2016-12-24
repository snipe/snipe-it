<?php
/**
 * Created by PhpStorm.
 * User: parallelgrapefruit
 * Date: 12/23/16
 * Time: 12:15 PM
 */

namespace App\Presenters;


use App\Helpers\Helper;

/**
 * Class AssetModelPresenter
 * @package App\Presenters
 */
class AssetModelPresenter extends Presenter
{
    /**
    * JSON representation of Accessory for datatable.
     * @return array
     */
    public function forDataTable()
    {

        $actions = '<div style="white-space: nowrap;">';
        if ($this->deleted_at == '') {
            $actions .= Helper::generateDatatableButton('clone', route('clone/model', $this->id));
            $actions .= Helper::generateDatatableButton('edit', route('models.edit', $this->id));
            $actions .= Helper::generateDatatableButton(
                'delete',
                route('models.destroy', $this->id),
                trans('admin/models/message.delete.confirm'),
                $this->name
            );
        } else {
            $actions .= Helper::generateDatatableButton('restore', route('restore/model', $this->id));
        }
        $actions .="</div>";

        $results = [];

        $results['id'] = $this->id;
        $results['manufacturer'] = $this->model->manufacturer->present()->nameUrl();
        $results['name'] = $this->nameUrl();
        $results['image'] = $this->imageUrl();
        $results['model_number'] = $this->model_number;
        $results['numassets'] = $this->assets()->count();
        $results['depreciation'] = trans('general.no_depreciation');
        if(($depreciation = $this->model->depreciation) and $depreciation->id > 0) {
            $results['depreciation'] = $depreciation->name.' ('.$depreciation->months.')';
        }
        $results['category'] = $this->model->category ? $this->model->category->present()->nameUrl() : '';
        $results['eol'] = $this->eol ? $this->eol.' '.trans('general.months') : '';
        $results['note'] = $this->note();
        $results['fieldset'] = $this->model->fieldset ? link_to_route('custom_fields/model', $this->model->fieldset->name, $this->model->fieldset->id) : '';
        $results['actions']           = $actions;

        return $results;
    }

    /**
     * Formatted note for this model
     * @return string
     */
    public function note()
    {
        $Parsedown = new \Parsedown();

        if ($this->model->note) {
            return $Parsedown->text($this->model->note);
        }

    }

    /**
     * Pretty name for this model
     * @return string
     */
    public function modelName()
    {
        $name = $this->manufacturer->name.' '.$this->name;
        if ($this->model_number) {
            $name .=" / ".$this->model_number;
        }
        return $name;
    }

    /**
     * Standard url for use to view page.
     * @return string
     */
    public function nameUrl()
    {
        return  (string) link_to_route('models.show',$this->name, $this->id);
    }

    /**
     * Generate img tag to this models image.
     * @return string
     */
    public function imageUrl()
    {
        if(!empty($this->image)) {
            return '<img src="' . url('/') . '/uploads/models/' . $this->image . '" height=50 width=50>';
        }
        return '';
    }
}
