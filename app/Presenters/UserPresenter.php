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
     * Json Column Layout for bootstrap table
     * @return string
     */
    public static function dataTableLayout()
    {
        $layout = [
            [
                "field" => "checkbox",
                "checkbox" => true
            ],
            [
                "field" => "id",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.id'),
                "visible" => false
            ],
            [
                "field" => "avatar",
                "searchable" => false,
                "sortable" => false,
                "switchable" => true,
                "title" => 'Avatar',
                "visible" => false,
                "formatter" => "imageFormatter"
            ],
            [
                "field" => "company",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/companies/table.title'),
                "visible" => false,
                "formatter" => "companiesLinkObjFormatter"
            ],
            [
                "field" => "name",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/users/table.name'),
                "visible" => true,
                "formatter" => "usersLinkFormatter"
            ],
            [
                "field" => "jobtitle",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/users/table.title'),
                "visible" => true,
                "formatter" => "usersLinkFormatter"
            ],
            [
                "field" => "email",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/users/table.email'),
                "visible" => true,
                "formatter" => "emailFormatter"
            ],
            [
                "field" => "phone",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/users/table.phone'),
                "visible" => true,
                "formatter"    => "phoneFormatter",
            ],
            [
                "field" => "address",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.address'),
                "visible" => false,
            ],
            [
                "field" => "city",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.city'),
                "visible" => false,
            ],
            [
                "field" => "state",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.state'),
                "visible" => false,
            ],
            [
                "field" => "country",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.country'),
                "visible" => false,
            ],
            [
                "field" => "zip",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.zip'),
                "visible" => false,
            ],
            [
                "field" => "username",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/users/table.username'),
                "visible" => true,
                "formatter" => "usersLinkFormatter"
            ],
            [
                "field" => "employee_num",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/users/table.employee_num'),
                "visible" => false
            ],
            [
                "field" => "department",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.department'),
                "visible" => true,
                "formatter" => "departmentsLinkObjFormatter"
            ],
            [
                "field" => "location",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/users/table.location'),
                "visible" => true,
                "formatter" => "locationsLinkObjFormatter"
            ],
            [
                "field" => "manager",
                "searchable" => true,
                "sortable" => true,
                "title" => trans('admin/users/table.manager'),
                "visible" => true,
                "formatter" => "usersLinkObjFormatter"
            ],
            [
                "field" => "assets_count",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => ' <span class="hidden-md hidden-lg">Assets</span>'
                            .'<span class="hidden-xs"><i class="fa fa-barcode fa-lg"></i></span>',
                "visible" => true,
            ],
            [
                "field" => "licenses_count",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => ' <span class="hidden-md hidden-lg">Licenses</span>'
                    .'<span class="hidden-xs"><i class="fa fa-floppy-o fa-lg"></i></span>',
                "visible" => true,
            ],
            [
                "field" => "consumables_count",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => ' <span class="hidden-md hidden-lg">Consumables</span>'
                    .'<span class="hidden-xs"><i class="fa fa-tint fa-lg"></i></span>',
                "visible" => true,
            ],
            [
                "field" => "accessories_count",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => ' <span class="hidden-md hidden-lg">Accessories</span>'
                    .'<span class="hidden-xs"><i class="fa fa-keyboard-o fa-lg"></i></span>',
                "visible" => true,
            ],
            [
                "field" => "notes",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.notes'),
                "visible" => true,
            ],
            [
                "field" => "groups",
                "searchable" => false,
                "sortable" => false,
                "switchable" => true,
                "title" => trans('general.groups'),
                "visible" => true,
                'formatter' => 'groupsFormatter'
            ],
            [
                "field" => "two_factor_enrolled",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('admin/users/general.two_factor_enrolled'),
                "visible" => false,
                'formatter' => 'trueFalseFormatter'
            ],
            [
                "field" => "two_factor_activated",
                "searchable" => false,
                "sortable" => false,
                "switchable" => true,
                "title" => trans('admin/users/general.two_factor_active'),
                "visible" => false,
                'formatter' => 'trueFalseFormatter'
            ],
            [
                "field" => "activated",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.login_enabled'),
                "visible" => true,
                'formatter' => 'trueFalseFormatter'
            ],
            [
                "field" => "created_at",
                "searchable" => true,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.created_at'),
                "visible" => false,
                'formatter' => 'dateDisplayFormatter'
            ],
            [
                "field" => "last_login",
                "searchable" => false,
                "sortable" => true,
                "switchable" => true,
                "title" => trans('general.last_login'),
                "visible" => false,
                'formatter' => 'dateDisplayFormatter'
            ],
            [
                "field" => "actions",
                "searchable" => false,
                "sortable" => false,
                "switchable" => false,
                "title" => trans('table.actions'),
                "visible" => true,
                "formatter" => "usersActionsFormatter",
            ]
        ];

        return json_encode($layout);
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
     * Standard accessor.
     * @TODO Remove presenter::fullName() entirely?
     * @return string
     */
    public function name()
    {
        return $this->fullName();
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

        // Set a fun, gender-neutral default icon
        return url('/').'/img/default-sm.png';

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

    public function glyph()
    {
        return '<i class="fa fa-user"></i>';
    }
}
