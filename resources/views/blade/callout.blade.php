@props([
    'type' => 'info',
    'icon' => null,
    'live' => 'polite',
    // 'alert' by default; callers can pass role="status" for polite info
    // callouts. Made a prop rather than passthrough so we don't emit two
    // role= attributes on the tag.
    'role' => 'alert',
])
<div {{ $attributes->merge(['class' => 'callout callout-'.$type]) }} role="{{ $role }}" aria-live="{{ $live }}" aria-atomic="true">

        @if ($icon)
            <x-icon :type="$icon" />
        @endif
        {{ $slot }}

</div>
