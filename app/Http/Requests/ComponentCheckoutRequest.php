<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ComponentCheckoutRequest extends Request
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
            "asset_id"   => 'required',
            "assigned_qty"   => 'required|numeric|min:1',
        ];
    }
}
