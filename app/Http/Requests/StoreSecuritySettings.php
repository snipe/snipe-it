<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreSecuritySettings extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'pwd_secure_min' => 'numeric|required|min:8',
            'custom_forgot_pass_url' => 'url|nullable',
            'privacy_policy_link' => 'nullable|url',
            'login_remote_user_enabled' => 'numeric|nullable',
            'login_common_disabled' => 'numeric|nullable',
            'login_remote_user_custom_logout_url' => 'string|nullable',
            // Reject HTTP_-prefixed server variable names. PHP populates
            // $_SERVER[HTTP_*] directly from inbound request headers, so
            // configuring a HTTP_-prefixed name here lets any unauthenticated
            // caller spoof the header and get logged in as any active user,
            // including superuser (pre-auth takeover). Legitimate values are
            // REMOTE_USER (default, populated by Apache mod_auth_*), or a
            // name that the operator's upstream proxy / FastCGI explicitly
            // sets from a vetted source. Reported by Brayden Arnold.
            'login_remote_user_header_name' => 'string|nullable|not_regex:/^HTTP_/i',
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'login_remote_user_header_name.not_regex' => trans('admin/settings/general.login_remote_user_header_http_prefix_rejected'),
        ];
    }
}
