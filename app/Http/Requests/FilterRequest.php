<?php

namespace App\Http\Requests;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\Location;
use App\Models\Maintenance;
use App\Models\User;
use App\Rules\ValidJson;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    /**
     * Normalize scalar item_type / target_type inputs into
     * single-element arrays so a request can pass either shape
     * (?item_type=asset OR ?item_type[]=asset&item_type[]=component)
     * and downstream code always sees an array. Multi-value is used
     * by the activity report toolbar's multi-select dropdowns.
     */
    protected function prepareForValidation(): void
    {
        foreach (['item_type', 'target_type'] as $key) {
            $value = $this->input($key);
            if (is_string($value) && $value !== '') {
                $this->merge([$key => [$value]]);
            }
        }
    }

    public function rules(): array
    {
        $allowedTypes = [
            'accessory',
            Accessory::class,
            'asset',
            Asset::class,
            'assetmodel',
            'assetModel',
            'AssetModel',
            AssetModel::class,
            'component',
            Component::class,
            'consumable',
            Consumable::class,
            'license',
            License::class,
            'licenseseat',
            'licenseSeat',
            'LicenseSeat',
            LicenseSeat::class,
            'location',
            Location::class,
            'maintenance',
            Maintenance::class,
            'user',
            User::class,
        ];

        return [
            'filter' => ['nullable', new ValidJson],
            'item_type' => ['nullable', 'array'],
            'item_type.*' => [Rule::in($allowedTypes)],
            'target_type' => ['nullable', 'array'],
            'target_type.*' => [Rule::in($allowedTypes)],
        ];
    }
}
