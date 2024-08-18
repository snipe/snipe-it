@props([
    'type' => '',
    'class' => '',
    'style' => '',
])
<i {{ $attributes->merge(['class' => Icon::icon($type).' '.$class]) }} {{ $attributes->merge(['style' => $style]) }} aria-hidden="true"></i>