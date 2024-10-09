<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreLdapSettings extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('superuser');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ldap_username_field' => 'not_in:sAMAccountName',
            'ldap_auth_filter_query' => 'not_in:uid=samaccountname|required_if:ldap_enabled,1',
            'ldap_filter' => 'nullable|regex:"^[^(]"|required_if:ldap_enabled,1',
        ];
    }

    public function messages() : array
    {
        return [
            'ldap_username_field.not_in' => '<code>sAMAccountName</code> (mixed case) will likely not work. You should use <code>samaccountname</code> (lowercase) instead. ',
            'ldap_auth_filter_query.not_in' => '<code>uid=samaccountname</code> is probably not a valid auth filter. You probably want <code>uid=</code> ',
            'ldap_filter.regex' => 'This value should probably not be wrapped in parentheses.',
        ];
    }
}
