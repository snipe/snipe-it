@props([
    'type' => 'info',
    'icon' => null,
    'title' => null,
    // 'alert' fits error/warning contexts; 'status' is more appropriate for
    // success/info notifications that shouldn't interrupt screen readers.
    'role' => 'alert',
])
<div {{ $attributes->merge(['class' => 'alert alert-'.$type.' fade in']) }} role="{{ $role }}">
    @if ($icon)
        <x-icon :type="$icon" />
    @endif
    @if ($title)
        <strong>{{ $title }}:</strong>
    @endif
    {{ $slot }}
</div>
