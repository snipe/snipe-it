<?php

namespace App\Presenters;

/**
 * Class CompanyPresenter
 * @package App\Presenters
 */
class ActionlogPresenter extends Presenter
{
    /**
     * Link to this companies name
     * @return string
     */
    public function forDataTable()
    {

        return [
            'icon'          => '<i class="'.$this->parseItemIcon().'"></i>',
            'created_at'    => date("M d, Y g:iA", strtotime($this->created_at)),
            'action_type'   => strtolower(trans('general.'.str_replace(' ', '_', $this->action_type))),
            'admin'         =>  $this->model->user ? $this->model->user->present()->nameUrl() : '',
            'target'        => $this->target(),
            'item'          => $this->item(),
            'item_type'     => $this->itemType(),
            'note'          => e($this->note),

        ];
    }

    public function admin()
    {
    }

    public function item()
    {//
        // oute('show/userfile', [$user->id, $file->id])
        if($this->action_type=='uploaded') {
            return (string) link_to_route('show/userfile', $this->model->filename, [$this->model->item->id, $this->model->id]);
        }
        if ($this->model->item) {
            return $this->model->item->present()->nameUrl();
        }
        return '';
    }

    public function target()
    {
        // Target is messy.
        // On an upload, the target is the item we are uploading to, stored as the "item" in the log.
        if ($this->action_type=='uploaded') {
            return $this->model->item->present()->nameUrl();
        }
        // If we are logging an accept/reject, the target is not stored directly, 
        // so we access it through who the item is assigned to.
        // FIXME: On a reject it's not assigned to anyone.
        if (($this->action_type=='accepted') || ($this->action_type=='declined')) {
            return $this->model->item->assignedTo->nameUrl();
        } elseif ($this->action_type=='requested') {
            if ($this->model->user) {
                return $this->model->user->present()->nameUrl();
            }
        }
        // Otherwise, we'll just take the target of the log.
        if ($this->model->target) {
            return $this->model->target->present()->nameUrl();
        }
        return '';
    }
}
