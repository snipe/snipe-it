<?php

namespace App\Http\Requests;

use App\Models\Accessory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreNotificationSettings extends FormRequest
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
            'alert_email'                         => 'email_array|nullable',
            'admin_cc_email'                      => 'email|nullable',
            'alert_threshold'                     => 'numeric|nullable',
            'alert_interval'                      => 'numeric|nullable',
            'audit_warning_days'                  => 'numeric|nullable',
            'due_checkin_days'                    => 'numeric|nullable',
            'audit_interval'                      => 'numeric|nullable',
        ];
    }
}
