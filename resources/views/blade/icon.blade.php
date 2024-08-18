@props([
    'type' => '',
    'class' => '',
    'style' => '',
    'id' => '',
])
<i {{ $attributes->merge(['class' => Icon::icon($type).' '.$class]) }} {{ $attributes->merge(['style' => $style]) }} {{ $attributes->merge(['id' => $id]) }}  aria-hidden="true"></i>