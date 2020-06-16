@component('mail::message')

    {{ trans_choice('mail.license_renewal_alert', $licenses->count(), ['count'=>$licenses->count(), 'threshold' => $threshold]) }}

@component('mail::table')
| |{{ trans('mail.name') }} |{{ trans('mail.renewal') }} |{{ trans('mail.Days') }}
| |:------------- |:-------------|:-------------|
@foreach ($licenses as $license)
@php
$renewal = \App\Helpers\Helper::getFormattedDateObject($license->renewal_date, 'date');
$diff = round(abs(strtotime($license->renewal_date->format('Y-m-d')) - strtotime(date('Y-m-d')))/86400);

$icon = ($diff <= ($threshold / 2)) ? '🚨' : (($diff <= $threshold) ? '⚠️' : ' ');


@endphp
|{{ $icon }}| [{{ $license->name }}]({{ route('licenses.show', $license->id) }}) | {{ $renewal['formatted'] }} | {{ $diff }} {{ trans('mail.Days') }}
@endforeach
@endcomponent


@endcomponent
