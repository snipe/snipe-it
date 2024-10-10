<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class StoreLabelSettings extends FormRequest
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
            'labels_per_page'                     => 'numeric',
            'labels_width'                        => 'numeric',
            'labels_height'                       => 'numeric',
            'labels_pmargin_left'                 => 'numeric|nullable',
            'labels_pmargin_right'                => 'numeric|nullable',
            'labels_pmargin_top'                  => 'numeric|nullable',
            'labels_pmargin_bottom'               => 'numeric|nullable',
            'labels_display_bgutter'              => 'numeric|nullable',
            'labels_display_sgutter'              => 'numeric|nullable',
            'labels_fontsize'                     => 'numeric|min:5',
            'labels_pagewidth'                    => 'numeric|nullable',
            'labels_pageheight'                   => 'numeric|nullable',
            'qr_text'                             => 'max:31|nullable',
        ];
    }
}
