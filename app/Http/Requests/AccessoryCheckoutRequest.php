<?php

namespace App\Http\Requests;

use App\Models\Accessory;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class AccessoryCheckoutRequest extends ImageUploadRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('checkout', new Accessory);
    }

    public function prepareForValidation(): void
    {

        if ($this->accessory) {

            $this->merge([
                'checkout_qty' => (int) $this->checkout_qty ?? 1,
                'number_remaining_after_checkout' => (int) ($this->accessory->numRemaining() - $this->checkout_qty) ?? 0,
            ]);
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return array_merge(
            [
                'assigned_to'  => [
                    'required',
                    'integer',
                    'exists:users,id,deleted_at,NULL',
                    'not_array'
                ],
                'number_remaining_after_checkout' => [
                    //'gte:checkout_qty',
                    'required',
                    'integer',
                    'min:0',
                ],
                'checkout_qty' => [
                    'lte:number_remaining_after_checkout',
                ],
            ],
        );
    }

    public function messages(): array
    {
        $messages = ['checkout_qty.lte' => 'There are only  '.$this->accessory->qty.'/'.$this->number_remaining_after_checkout.' accessories remaining, trying to check out '.$this->checkout_qty];
        return $messages;
    }


    public function response(array $errors)
    {
        return $this->redirector->back()->withInput()->withErrors($errors, $this->errorBag);
    }
}
