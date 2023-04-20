<?php

namespace App\Http\Requests;

use App\Models\Manufacturer;

class SaveManufacturerRequest extends ImageUploadRequest
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
       return parent::rules() + (new Manufacturer())->getRules();
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'support_url' => $this->input('support_url'),
        ]);
        dd($this->all());
    }
}
