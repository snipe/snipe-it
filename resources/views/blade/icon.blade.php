@props([
    'type' => '',
])
<i class="{{ Icon::icon($type) }} {{ $attributes->get('class') }}"
   aria-hidden="true" {{ isset($style) ? 'style="'.$attributes->get('style').'"' : '' }}></i>