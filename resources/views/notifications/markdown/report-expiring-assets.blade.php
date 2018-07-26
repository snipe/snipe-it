@component('mail::message')

{{ trans_choice('mail.assets_warrantee_alert', $assets->count(), ['count'=>$assets->count(), 'threshold' => $threshold]) }}

@component('mail::table')
| |{{ trans('mail.name') }} |{{ trans('mail.expires') }} |{{ trans('mail.Days') }}|{{ trans('mail.supplier') }} | {{ trans('mail.assigned_to') }}
| |:------------- |:-------------|:---------|:---------|:---------|:---------|
@foreach ($assets as $asset)
@php
$expires = \App\Helpers\Helper::getFormattedDateObject($asset->present()->warrantee_expires, 'date');
$diff = round(abs(strtotime($asset->present()->warrantee_expires) - strtotime(date('Y-m-d')))/86400);
$icon = ($diff <= ($threshold / 2)) ? '🚨' : (($diff <= $threshold) ? '⚠️' : ' ');

@endphp
|{{ $icon }}| [{{ $asset->present()->name }}]({{ route('hardware.show', $asset->id) }}) | {{ $expires['formatted'] }} | {{ $diff }} {{ trans('mail.Days') }} | {{ ($asset->supplier ? e($asset->supplier->name) : '') }}|{{ ($asset->assignedTo ? e($asset->assignedTo->present()->name()) : '') }}
@endforeach
@endcomponent


@endcomponent
