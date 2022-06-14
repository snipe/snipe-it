@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])

{{-- Check that the $snipeSettings variable is set, images are set to be shown, and setup is complete --}}


@if (isset($snipeSettings) && ($snipeSettings::setupCompleted()))

    {{-- Show images in email!  --}}
    @if (($snipeSettings->show_images_in_email=='1' ) && (($snipeSettings->brand == '3') || ($snipeSettings->brand == '2')))

        {{-- $snipeSettings->brand = 1 = Text  --}}
        {{-- $snipeSettings->brand = 2 = Logo  --}}
        {{-- $snipeSettings->brand = 3 = Logo + Text  --}}
        @if ($snipeSettings->brand == '3')

            @if ($snipeSettings->email_logo!='')
            <img style="max-height: 100px; vertical-align:middle;" src="{{ \Storage::disk('public')->url(e($snipeSettings->email_logo)) }}">
            @elseif ($snipeSettings->logo!='')
            <img style="max-height: 100px; vertical-align:middle;" src="{{ \Storage::disk('public')->url(e($snipeSettings->logo)) }}">
            @endif

            <br><br>
            {{ $snipeSettings->site_name }}
            <br><br>
        {{-- else if branding type is just logo --}}
        @elseif ($snipeSettings->brand == '2')
            @if ($snipeSettings->email_logo!='')

            <img style="max-width: 100px; vertical-align:middle;" src="{{ \Storage::disk('public')->url(e($snipeSettings->email_logo)) }}">
            @elseif ($snipeSettings->logo!='')
            <img style="max-width: 100px; vertical-align:middle;" src="{{ \Storage::disk('public')->url(e($snipeSettings->logo)) }}">
            @endif
        @endif
    @else
        {{ $snipeSettings->site_name }}
    @endif

{{-- Either the $snipeSettings variable isn't set or setup is not complete --}}
@else
{{ config('app.name') }}
@endif

@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
@if($snipeSettings::setupCompleted())
© {{ date('Y') }} {{ $snipeSettings->site_name }}. All rights reserved.
@else
© {{ date('Y') }} Snipe-IT. All rights reserved.
@endif

@if ($snipeSettings->privacy_policy_link!='')
<a href="{{ $snipeSettings->privacy_policy_link }}">{{ trans('admin/settings/general.privacy_policy') }}</a>
@endif

@endcomponent
@endslot
@endcomponent
