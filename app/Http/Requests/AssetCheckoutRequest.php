<?php

namespace App\Http\Requests;

class AssetCheckoutRequest extends Request
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

    protected function prepareForValidation(): void
    {
        if (!empty($this->assigned_user)) {
            $this->assigned_type =  'App\Models\User';
        } elseif (!empty($this->assigned_asset)) {
            $this->assigned_type =  'App\Models\Asset';
        } elseif (!empty($this->assigned_location)) {
            $this->assigned_type = 'App\Models\Location';
        }

        $this->merge([
            'assigned_type' => $this->assigned_type,
        ]);
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'assigned_user'         => ['required_without_all:assigned_asset,assigned_location','nullable','exists:users,id,deleted_at,NULL'],
            'assigned_asset'        => ['required_without_all:assigned_user,assigned_location','nullable','exists:assets,id,deleted_at,NULL'],
            'assigned_location'     => ['required_without_all:assigned_user,assigned_asset','nullable','exists:locations,id,deleted_at,NULL'],
            'status_id'             => 'exists:status_labels,id,deployable,1',
        ];

        return $rules;
    }


}
