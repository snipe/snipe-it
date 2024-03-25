<?php

namespace App\Http\Requests;

use App\Models\Asset;
use App\Models\Company;
use Carbon\Carbon;
use Carbon\Exceptions\InvalidFormatException;
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
        // Guard against users passing in an array for company_id instead of an integer.
        // If the company_id is not an integer then we simply use what was
        // provided to be caught by model level validation later.
        $idForCurrentUser = is_int($this->company_id)
            ? Company::getIdForCurrentUser($this->company_id)
            : $this->company_id;

        $this->parseLastAuditDate();

        $this->merge([
            'asset_tag' => $this->asset_tag ?? Asset::autoincrement_asset(),
            'company_id' => $idForCurrentUser,
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

    private function parseLastAuditDate(): void
    {
        if ($this->input('last_audit_date')) {
            try {
                $lastAuditDate = Carbon::parse($this->input('last_audit_date'));

                $this->merge([
                    'last_audit_date' => $lastAuditDate->startOfDay()->format('Y-m-d H:i:s'),
                ]);
            } catch (InvalidFormatException $e) {
                // we don't need to do anything here...
                // we'll keep the provided date in an
                // invalid format so validation picks it up later
            }
        }
    }
}
