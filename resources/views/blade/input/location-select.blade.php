@use('App\Models\Location', 'Location')
@use('Illuminate\Support\Arr', 'Arr')

{{-- Auto-hides the "New" button when rendered inside an AJAX modal.
     See x-input.company-select for the pattern. --}}
@aware(['submitToSelect2' => false])

@props([
    'label',
    'name',
    'selected' => null,
    'required' => false,
    'multiple' => false,
    'helpText' => null,
    'hideNewButton' => false,
    'companyId' => null,
    'excludeIds' => null,
    'id' => null,
])

@php
    $selectId = $id ?? $name.'_location_select';
    $hideNewButton = $hideNewButton || $submitToSelect2;
@endphp

<div
    @class([
       'form-group',
       'has-error' => $errors->has($name),
    ])
>

    <label for="{{ $selectId }}" class="col-md-3 control-label">{{ $label }}</label>
    <div class="col-md-7">
        <select
            class="js-data-ajax"
            data-endpoint="locations"
            data-placeholder="{{ trans('general.select_location') }}"
            name="{{ $name }}"
            style="width: 100%"
            id="{{ $selectId }}"
            aria-label="{{ $name }}"
            @required($required)
            @if ($multiple)
                multiple
            @endif
            @if ($companyId)
                data-company-id="{{ $companyId }}"
            @endif
            @if ($excludeIds)
                data-exclude-ids="{{ is_array($excludeIds) ? implode(',', $excludeIds) : $excludeIds }}"
            @endif
        >
            <option value=""></option>
            @if ($selected)
                @foreach(Arr::wrap($selected) as $value)
                    <option value="{{ $value }}" selected="selected" role="option" aria-selected="true"  role="option">
                        {{ Location::find($value)?->name }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>

    <div class="col-md-1 col-sm-1 text-left">
        @unless($hideNewButton)
            @can('create', Location::class)
                <x-button.modal-add type="location" :target="$selectId"/>
            @endcan
        @endunless
    </div>

    <div class="col-md-8 col-md-offset-3"><x-form.error :name="$name" /></div>

    @if ($helpText)
        <div class="col-md-7 col-sm-11 col-md-offset-3">
            <p class="help-block">{{ $helpText }}</p>
        </div>
    @endif

</div>
