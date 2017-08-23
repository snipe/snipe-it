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

        $settings = Setting::getSettings();

        $rules = [];
        $security_rules = '';

        $rules['first_name'] = 'required|string|min:1';
        $rules['username'] = 'required|string|min:1|unique_undeleted';

        // Check if they have uncommon password enforcement selected in settings
        if ($settings->pwd_secure_uncommon == 1) {
            $security_rules .= '|dumbpwd';
        }

        // Check for any secure password complexity rules that may have been selected
        if ($settings->pwd_secure_complexity!='') {
            $security_rules  .= '|'.$settings->pwd_secure_complexity;
        }


        if ((\Route::currentRouteName()=='api.users.update') || (\Route::currentRouteName()=='users.update')) {
            $rules['password'] = 'nullable|min:'.$settings->pwd_secure_min.$security_rules;
        } else {
            $rules['password'] = 'required|min:'.$settings->pwd_secure_min.$security_rules;
        }

        $rules['password_confirm'] = 'sometimes|required_with:password';

        return $rules;

    }
}
