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
            'admin'         =>  $this->admin(),
            'target'        => $this->target(),
            'item'          => $this->item(),
            'item_type'     => $this->itemType(),
            'note'          => e($this->note),

        ];
    }

    public function admin()
    {
        if ($user = $this->model->user) {
            if(empty($user->deleted_at)) {
                return $user->present()->nameUrl();
            }
            // The user was deleted
            return '<del>'.$user->present()->name()."</del> (deleted)";
        }

        return '';
    }

    public function item()
    {
        if($this->action_type=='uploaded') {
            return (string) link_to_route('show/userfile', $this->model->filename, [$this->model->item->id, $this->model->id]);
        }
        if ($item = $this->model->item) {
            if (empty($item->deleted_at)) {
                return $this->model->item->present()->nameUrl();
            }
            // The item was deleted
            return '<del>'.$item->present()->name().'</del> (deleted)';
        }
        return '';
    }

    public function target()
    {
        $target = null;
        // Target is messy.
        // On an upload, the target is the item we are uploading to, stored as the "item" in the log.
        if ($this->action_type=='uploaded') {
            $target = $this->model->item;
        } elseif (($this->action_type=='accepted') || ($this->action_type=='declined')) {
        // If we are logging an accept/reject, the target is not stored directly, 
        // so we access it through who the item is assigned to.
        // FIXME: On a reject it's not assigned to anyone.
            $target = $this->model->item->assignedTo;
        } elseif ($this->action_type=='requested') {
            if ($this->model->user) {
                $target = $this->model->user;
            }
        } elseif ($this->model->target) {
        // Otherwise, we'll just take the target of the log.   
            $target = $this->model->target;
        }

        if($target) {
            if (empty($target->deleted_at)) {
                return $target->present()->nameUrl();
            }
            return '<del>'.$target->present()->name().'</del>';
        }
        return '';
    }
}
