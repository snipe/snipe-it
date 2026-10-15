@props([
    'target' => null,
    'checkoutDate' => null,
    'checkoutBy' => null,
])

@if ($target || $checkoutDate || $checkoutBy)
    @if ($target)
        @php
            $iconType = match (class_basename($target)) {
                'User' => 'user',
                'Asset' => 'asset',
                'Location' => 'location',
                default => null,
            };
            $tagColor = $target->tag_color ?? null;
            $link = method_exists($target->present(), 'formattedNameLink')
                ? $target->present()->formattedNameLink()
                : e($target->present()->fullName() ?? $target->name ?? '');
        @endphp

        <x-form.static :label="trans('general.checked_out_to')">
            @if ($iconType)
                <x-icon :type="$iconType" class="fa-fw" style="{{ $tagColor ? 'color: '.e($tagColor).';' : '' }}" />
            @endif
            {!! $link !!}
        </x-form.static>
    @endif

    @if ($checkoutDate || $checkoutBy)
        <x-form.static :label="trans('general.checked_out')">
            @if ($checkoutDate)
                {{ \App\Helpers\Helper::getFormattedDateObject($checkoutDate, 'datetime', false) }}
            @endif
            @if ($checkoutBy)
                {{ strtolower(trans('general.by')) }}
                <x-icon type="user" class="fa-fw" />
                {!! $checkoutBy->present()->formattedNameLink() !!}
            @endif
        </x-form.static>
    @endif
@endif
