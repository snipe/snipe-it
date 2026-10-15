@props([
    'label' => null,
    'icon' => 'checkmark',
    'disabled' => false,
])

@php
    $label ??= trans('general.save');
@endphp

<button
    type="submit"
    {{ $attributes->merge(['class' => 'btn btn-primary', 'id' => 'submit_button']) }}
    @disabled($disabled)
>
    @if ($icon)
        <x-icon :type="$icon" />
    @endif
    {{ $label }}
</button>
