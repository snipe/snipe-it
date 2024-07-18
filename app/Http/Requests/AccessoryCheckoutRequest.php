<?php

namespace App\Http\Requests;

use App\Models\Accessory;
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

            $this->diff = ($this->accessory->numRemaining() - $this->checkout_qty);

            \Log::debug('num remaining in form request: '.$this->accessory->numRemaining());
            \Log::debug('accessory qty in form request: '.$this->accessory->qty);
            \Log::debug('checkout qty in form request: '.$this->checkout_qty);
            \Log::debug('diff in form request: '.$this->diff);

            $this->merge([
                'checkout_qty' => $this->checkout_qty,
                'number_remaining_after_checkout' =>  ($this->accessory->numRemaining() - $this->checkout_qty),
                'number_currently_remaining' =>  $this->accessory->numRemaining(),
                'checkout_difference' =>  $this->diff,
            ]);

            \Log::debug('---------------------------------------------');
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
                    'min:0',
                    'required',
                    'integer',
                ],

                'checkout_qty' => [
                    'integer',
                    'lte:qty',
                    'lte:number_currently_remaining',
                    'min:1',
                ],
            ],
        );
    }

    public function messages(): array
    {
        $messages = ['checkout_qty.lte' => 'There are only '.$this->accessory->qty.' available accessories, and you are trying to check out '.$this->checkout_qty.', leaving '.$this->number_remaining_after_checkout.' ('.$this->number_currently_remaining.') accessories remaining ('.$this->diff.').'];
        return $messages;
    }


    public function response(array $errors)
    {
        return $this->redirector->back()->withInput()->withErrors($errors, $this->errorBag);
    }
}
