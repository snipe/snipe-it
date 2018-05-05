<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\Setting;

class SaveUserRequest extends Request
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
            'last_name' => 'min:1|max:191|nullable',
            'locale' => 'max:10|nullable',
            'employee_num' => 'nullable',
            'activated' => 'boolean',
            'jobtitle' => 'min:1|max:191|nullable',
            'phone' => 'min:1|max:191|nullable',
            'location_id' => 'nullable|exists:locations,id,1',
            'department_id' => 'nullable|exists:departments,id,',
            'company_id' => 'nullable|exists:companies,id,1',
            'manager_id' => 'nullable|exists:users,id,1',
            'notes' => 'nullable',
            'address' => 'nullable|max:191',
            'city' => 'nullable|max:191',
            'state' => 'nullable|max:3',
            'zip' => 'nullable|max:10',

        ];

        switch($this->method())
        {

            // Brand new user
            case 'POST':
            {
                $rules['first_name'] = 'required|string|min:1';
                $rules['username'] = 'required_unless:ldap_import,1|string|min:1';
                if ($this->request->get('ldap_import') == false)
                {
                    $rules['password'] = Setting::passwordComplexityRulesSaving('store');
                }
                break;
            }

            // Save all fields
            case 'PUT':
                $rules['first_name'] = 'required|string|min:1';
                $rules['username'] = 'required_unless:ldap_import,1|string|min:1';
                $rules['password'] = Setting::passwordComplexityRulesSaving('update');
                break;

            // Save only what's passed
            case 'PATCH':
            {
                $rules['password'] = Setting::passwordComplexityRulesSaving('update');
                break;
            }

            default:break;
        }

        $rules['password_confirm'] = 'sometimes|required_with:password';

        return $rules;

    }
}
