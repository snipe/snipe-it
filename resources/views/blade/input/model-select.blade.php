@use('App\Models\AssetModel', 'AssetModel')
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
    'hideNewButton' => false,
    'id' => null,
])

@php
    $selectId = $id ?? $name.'_select';
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
            data-endpoint="models"
            data-placeholder="{{ trans('general.select_model') }}"
            name="{{ $name }}{{ $multiple ? '[]' : '' }}"
            id="{{ $selectId }}"
            style="width: 100%"
            aria-label="{{ $label }}"
            @required($required)
            @if ($multiple) multiple @endif
        >
            <option value=""></option>
            @if ($selected)
                @foreach(Arr::wrap($selected) as $value)
                    <option value="{{ $value }}" selected="selected" role="option" aria-selected="true">
                        {{ AssetModel::find($value)?->name }}
                    </option>
                @endforeach
            @endif
        </select>
    </div>

    @unless($hideNewButton)
        <div class="col-md-1 col-sm-1 text-left">
            @can('create', AssetModel::class)
                <x-button.modal-add type="model" :target="$selectId"/>
                <span class="mac_spinner" style="padding-left: 10px; color: green; display:none; width: 30px;">
                    <i class="fas fa-spinner fa-spin" aria-hidden="true"></i>
                </span>
            @endcan
        </div>
    @endunless

    <div class="col-md-8 col-md-offset-3"><x-form.error :name="$name" /></div>
</div>
