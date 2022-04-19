@component('mail::layout')
<<<<<<< HEAD
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
@if (($snipeSettings->show_images_in_email=='1' ) && ($snipeSettings::setupCompleted()))

@if ($snipeSettings->brand == '3')
@if ($snipeSettings->logo!='')
<img class="navbar-brand-img logo" src="{{ url('/') }}/uploads/{{ $snipeSettings->logo }}">
@endif
{{ $snipeSettings->site_name }}

@elseif ($snipeSettings->brand == '2')
@if ($snipeSettings->logo!='')
<img class="navbar-brand-img logo" src="{{ url('/') }}/uploads/{{ $snipeSettings->logo }}">
@endif
@else
{{ $snipeSettings->site_name }}
@endif
@else
Snipe-IT
@endif
@endcomponent
@endslot
=======
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            @if ($snipeSettings::setupCompleted())

                @if (($snipeSettings->brand == '3') && ($snipeSettings->show_images_in_email=='1' ))
                    @if ($snipeSettings->logo!='')
                        <img class="navbar-brand-img logo" src="{{ url('/') }}/uploads/{{ $snipeSettings->logo }}">
                    @endif
                    {{ $snipeSettings->site_name }}

                @elseif (($snipeSettings->brand == '2') && ($snipeSettings->show_images_in_email=='1' ))
                    @if ($snipeSettings->logo!='')
                        <img class="navbar-brand-img logo" src="{{ url('/') }}/uploads/{{ $snipeSettings->logo }}">
                    @endif
                @else
                    {{ $snipeSettings->site_name }}
                @endif
            @else
                Snipe-IT
            @endif
        @endcomponent
    @endslot
>>>>>>> 0a7c57e51 (show site name if show images in emails is not enabled)

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
© {{ date('Y') }} Snipe-it. All rights reserved.
@endif

@if ($snipeSettings->privacy_policy_link!='')
<a href="{{ $snipeSettings->privacy_policy_link }}">{{ trans('admin/settings/general.privacy_policy') }}</a>
@endif

@endcomponent
@endslot
@endcomponent
