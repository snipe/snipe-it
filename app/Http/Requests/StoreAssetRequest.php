<?php

namespace App\Http\Requests;

use App\Models\Asset;
use App\Models\Company;
use Illuminate\Support\Facades\Gate;

class StoreAssetRequest extends ImageUploadRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Gate::allows('create', new Asset);
    }

    public function prepareForValidation(): void
    {
        if ($this->has('assigned_user')) {
            $assigned_to = $this->assigned_user;
        } elseif ($this->has('assigned_location')) {
            $assigned_to = $this->assigned_location;
        } elseif ($this->has('assigned_asset')) {
            $assigned_to = $this->assigned_asset;
        }

        $this->merge([
            'asset_tag' => $this->asset_tag ?? Asset::autoincrement_asset(),
            'company_id' => Company::getIdForCurrentUser($this->company_id),
            'assigned_to' => $assigned_to ?? null,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = array_merge(
            (new Asset)->getRules(),
            parent::rules(),
        );

        return $rules;
    }
}
