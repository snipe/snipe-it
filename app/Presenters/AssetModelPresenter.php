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

    public function eolText()
    {
        if ($this->eol) {
            return $this->eol.' '.trans('general.months');
        }
        return '';
    }

    /**
     * Pretty name for this model
     * @return string
     */
    public function modelName()
    {
        $name = '';
        if ($this->model->manufacturer) {
            $name .= $this->model->manufacturer->name;
        }
        $name .= $this->name;

        if ($this->model_number) {
            $name .=" (#".$this->model_number.')';
        }
        return $name;
    }

    /**
     * Standard url for use to view page.
     * @return string
     */
    public function nameUrl()
    {
        return  (string) link_to_route('models.show', $this->name, $this->id);
    }

    /**
     * Generate img tag to this models image.
     * @return string
     */
    public function imageUrl()
    {
        if (!empty($this->image)) {
            return '<img src="' . url('/') . '/uploads/models/' . $this->image . '" height=50 width=50>';
        }
        return '';
    }

    /**
     * Generate img tag to this models image.
     * @return string
     */
    public function imageSrc()
    {
        if (!empty($this->image)) {
            return url('/') . '/uploads/models/' . $this->image;
        }
        return '';
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('models.show', $this->id);
    }
}
