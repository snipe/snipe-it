{{-- IMPORTANT!!! Make sure there is no newline at the end of this file, or it will break the loaders for the tables --}}

@props([
    'type' => '',
    'class' => false,
    'style' => false,
    'id' => false,
    'title' => false,
])
<i {{ $attributes->merge(['class' => Icon::icon($type).' '.$class]) }} {{ isset($style) ? $attributes->merge(['style' => $style]): '' }}  {{ isset($title) ? $attributes->merge(['title' => $title]): '' }}  aria-hidden="true"></i>