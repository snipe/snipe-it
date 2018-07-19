@component('mail::message')

    {{ trans_choice('mail.license_expiring_alert', $licenses->count(), ['count'=>$licenses->count(), 'threshold' => $threshold]) }}

@component('mail::table')
| |{{ trans('mail.name') }} |{{ trans('mail.expires') }} |{{ trans('mail.Days') }}
| |:------------- |:-------------|:-------------|
@foreach ($licenses as $license)
@php
$expires = \App\Helpers\Helper::getFormattedDateObject($license->expiration_date, 'date');
$diff = round(abs(strtotime($license->expiration_date->format('Y-m-d')) - strtotime(date('Y-m-d')))/86400);

$icon = ($diff <= ($threshold / 2)) ? '🚨' : (($diff <= $threshold) ? '⚠️' : ' ');


@endphp
|{{ $icon }}| [{{ $license->name }}]({{ route('licenses.show', $license->id) }}) | {{ $expires['formatted'] }} | {{ $diff }} {{ trans('mail.Days') }}
@endforeach
@endcomponent


@endcomponent
