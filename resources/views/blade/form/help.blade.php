@props(['name', 'icon' => null])
<p {{ $attributes->merge(['class' => 'help-block', 'id' => $name.'-help']) }}>
    @if ($icon)
        <x-icon :type="$icon" />
    @endif
    {{ $slot }}
</p>
