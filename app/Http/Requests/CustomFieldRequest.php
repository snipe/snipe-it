<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class CustomFieldRequest extends FormRequest
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
    public function rules(Request $request)
    {
        
        $rules = [];

        switch($this->method())
        {

            // Brand new
            case 'POST':
            {
                $rules['name'] = "required|unique:custom_fields";
                break;
            }

            default:break;
        }

        $rules['custom_format'] = 'valid_regex';

        return  $rules;
    }
}
