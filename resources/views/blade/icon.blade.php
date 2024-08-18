@props([
    'type' => '',
])
<i class="{{ Icon::icon($type) }} {{ $attributes->get('class') }}"{{ isset($style) ?  $attributes->merge(['style' => $style]) : '' }} aria-hidden="true"></i>