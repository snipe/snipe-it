<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class AssetCheckoutRequest extends Request
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
        $rules = [
            "assigned_user"         => 'required_without_all:assigned_asset,assigned_location',
            "assigned_asset"        => 'required_without_all:assigned_user,assigned_location|different:'.$this->id,
            "assigned_location"     => 'required_without_all:assigned_user,assigned_asset',
            "checkout_to_type"      => 'required|in:asset,location,user'
        ];


        return $rules;
    }
}
