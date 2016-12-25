<?php

namespace App\Presenters;


use App\Helpers\Helper;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

/**
 * Class UserPresenter
 * @package App\Presenters
 */
class UserPresenter extends Presenter
{

    /**
     * Generates json for bootstrap table.
     * @param string $status Status of User to filter on
     * @return array
     */
    public function forDataTable($status = null)
    {
        $group_names = '';
        $actions = '<nobr>';

        foreach ($this->model->groups as $group) {
            $group_names .= link_to_route('update/group', $group->name, $group->id, ['class' => 'label label-default']);
        }
        if (!is_null($this->model->deleted_at)) {
            if (Gate::allows('delete', $this)) {
                $actions .= Helper::generateDatatableButton('restore', route('restore/user', $this->id));
            }
        } else {
            if (Gate::allows('delete', $this)) {
                if ($this->accountStatus() == 'suspended') {
                    $actions .= link_to_route(
                        'unsuspend/user',
                        '<span class="fa fa-clock-o"></span>"',
                            $this->id,
                            ['class' => 'btn btn-default btn-sm']
                    );
                }
            }
            if (Gate::allows('update', $this)) {
                $actions .= Helper::generateDatatableButton('edit', route('users.edit', $this->id));
                $actions .= Helper::generateDatatableButton('clone', route('clone/user', $this->id));
            }
            if (Gate::allows('delete', $this)) {
                if ((Auth::user()->id !== $this->id) && (!config('app.lock_passwords'))) {
                    $actions .= Helper::generateDatatableButton(
                        'delete',
                        route('users.destroy', $this->id),
                        true, /*enabled*/
                        "Are you sure you wish to delete this user?",
                        $this->first_name
                    );
                } else {
                    $actions .= ' <span class="btn delete-asset btn-danger btn-sm disabled"><i class="fa fa-trash icon-white"></i></span>';
                }
            }
        }
        $actions .= '</nobr>';
        $result = [
            'id'            => $this->id,
            'checkbox'      => ($status!='deleted') ? '<div class="text-center hidden-xs hidden-sm"><input type="checkbox" name="edit_user['.e($this->id).']" class="one_required"></div>' : '',
            'name'          => $this->fullName(),
            'jobtitle'      => $this->jobtitle,
            'email'         => $this->emailLink(),
            'username'      => $this->username,
            'location'      => ($this->model->userloc) ? $this->model->userloc->present()->nameUrl() : '',
            'manager'       => ($this->model->manager) ? $this->manager->present()->nameUrl() : '',
            'employee_num'  => $this->employee_num,
            'assets'        => $this->model->assets()->count(),
            'licenses'      => $this->model->licenses()->count(),
            'accessories'   => $this->model->accessories()->count(),
            'consumables'   => $this->model->consumables()->count(),
            'groups'        => $group_names,
            'notes'         => $this->notes,
            'two_factor_enrolled'        => ($this->two_factor_enrolled=='1') ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times  text-danger"></i>',
            'two_factor_optin'        => (($this->two_factor_optin=='1') || (Setting::getSettings()->two_factor_enabled=='2') ) ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times  text-danger"></i>',
            'created_at'    => ($this->model->created_at!='')  ? e($this->model->created_at->format('F j, Y h:iA')) : '',
            'activated'     => ($this->activated=='1') ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times  text-danger"></i>',
            'actions'       => $actions ?: '',
            'companyName'   => $this->companyUrl()

        ];

        return $result;
    }

    public function emailLink()
    {
        if ($this->email) {
            return '<a href="mailto:'.$this->email.'">'.$this->email.'</a>'
                .'<a href="mailto:'.$this->email.'" class="hidden-xs hidden-sm"><i class="fa fa-envelope"></i></a>';
        }
        return '';
    }
    /**
     * Returns the user full name, it simply concatenates
     * the user first and last name.
     *
     * @return string
     */
    public function fullName()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Returns the user Gravatar image url.
     *
     * @return string
     */
    public function gravatar()
    {

        if ($this->avatar) {
            return config('app.url').'/uploads/avatars/'.$this->avatar;
        }

        if ((Setting::getSettings()->load_remote=='1') && ($this->email!='')) {
            $gravatar = md5(strtolower(trim($this->email)));
            return "//gravatar.com/avatar/".$gravatar;
        }

        return false;

    }

    /**
     * Formatted url for use in tables.
     * @return string
     */
    public function nameUrl()
    {
        return (string) link_to_route('users.show', $this->fullName(), $this->id);
    }

    /**
     * Url to view this item.
     * @return string
     */
    public function viewUrl()
    {
        return route('users.show', $this->id);
    }
}
