@use('App\Helpers\Helper')

@props([
    'item' => null,
    'name' => 'qty',
    'label' => null,
    'min' => 0,
    'max' => null,
    'value' => null,
    'help_text' => null,
    'help_icon' => null,
])

<div
    @class([
        'form-group',
        'has-error' => $errors->has($name),
    ])
>
    <label for="{{ $name }}" class="col-md-3 control-label">
        {{ $label ?? trans('general.quantity') }}
    </label>
    <div class="col-md-9">
        <div class="col-md-3" style="padding-left: 0">
            <input
                class="form-control"
                type="number"
                name="{{ $name }}"
                id="{{ $name }}"
                aria-label="{{ $label ?? trans('general.quantity') }}"
                @if ($help_text) aria-describedby="{{ $name }}-help" @endif
                value="{{ old($name, $value ?? $item?->{$name} ?? '') }}"
                min="{{ $min }}"
                @if ($max) max="{{ $max }}" @endif
                maxlength="5"
                @required($item && Helper::checkIfRequired($item, $name))
            />
        </div>
        <div class="col-md-12" style="padding-left: 0">
            <x-form.error :name="$name" />
            @if ($help_text)
                <x-form.help :name="$name" :icon="$help_icon">{{ $help_text }}</x-form.help>
            @endif
        </div>
    </div>
</div>
