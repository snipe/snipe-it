<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LicenseCheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'note'                  => 'string|nullable',
            'assigned_user'         => 'required_without_all:assigned_asset,assigned_location,assigned_component,assigned_accessory',
            'assigned_asset'        => 'required_without_all:assigned_user,assigned_location,assigned_component,assigned_accessory',
            'assigned_location'     => 'required_without_all:assigned_user,assigned_asset,assigned_component,assigned_accessory',
            'assigned_component'    => 'required_without_all:assigned_user,assigned_asset,assigned_location,assigned_accessory',
            'assigned_accessory'    => 'required_without_all:assigned_user,assigned_asset,assigned_location,assigned_component',
            'checkout_to_type'      => 'required|in:asset,location,user,component,accessory'
        ];
    }
}
