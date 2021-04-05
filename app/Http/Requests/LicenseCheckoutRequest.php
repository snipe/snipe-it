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
        $rules = [
		  'checkout_to_type'      => 'string',
		  'assigned_to'         => 'string',		  
		  'note'   => 'string|nullable',
          'asset_id'  => 'string|nullable',
	    ];		
        return $rules;
    }
}
