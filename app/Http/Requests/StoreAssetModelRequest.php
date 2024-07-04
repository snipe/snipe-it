<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Validation\Rule;

class StoreAssetModelRequest extends ImageUploadRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation(): void
    {

        $this->category_type = Category::find($this->category_id)->category_type;
        $this->merge([
            'category_type' => $this->category_type,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge(
            ['category_type' => 'required|in:asset'],
            parent::rules(),
        );
    }

    public function messages(): array
    {
        $messages = ['category_type.in' => 'The category must be an asset category, dummy.'];
        return $messages;
    }
}
