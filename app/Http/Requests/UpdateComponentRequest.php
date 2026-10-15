<?php

namespace App\Http\Requests;

use App\Helpers\Helper;
use Illuminate\Support\Facades\Gate;

class UpdateComponentRequest extends ImageUploadRequest
{
    public function authorize(): bool
    {
        return Gate::allows('update', $this->component);
    }

    public function prepareForValidation(): void
    {
        if ($this->filled('purchase_cost') && ! is_float($this->input('purchase_cost')) && preg_match('/^[\d.,]+$/', (string) $this->input('purchase_cost'))) {
            $this->merge(['purchase_cost' => Helper::ParseCurrency($this->input('purchase_cost'))]);
        }
    }

    public function response(array $errors)
    {
        return $this->redirector->back()->withInput()->withErrors($errors, $this->errorBag);
    }
}
