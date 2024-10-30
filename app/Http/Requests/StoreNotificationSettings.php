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
            'admin_cc_email'                      => 'email_array|nullable',
            'alert_threshold'                     => 'numeric|nullable|gt:0',
            'alert_interval'                      => 'numeric|nullable|gt:0',
            'audit_warning_days'                  => 'numeric|nullable|gt:0',
            'due_checkin_days'                    => 'numeric|nullable|gt:0',
            'audit_interval'                      => 'numeric|nullable|gt:0',
        ];
    }

}
