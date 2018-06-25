@component('mail::message')
# {{ trans('mail.hello') }},

The following {{ $assets->count() }} items are due to be checked in soon:

@component('mail::table')
| Asset | Checked Out to | Expected Checkin |
| ------------- | ------------- |
@foreach ($assets as $asset)
@php
$checkin = \App\Helpers\Helper::getFormattedDateObject($asset->expected_checkin, 'date');
@endphp
| [{{ $asset->present()->name }}]({{ route('hardware.show', ['assetId' => $asset->id]) }}) | [{{ $asset->assigned->present()->fullName }}]({{ route('users.show', ['user'=>$asset->assigned->id]) }})  | {{ $checkin['formatted'] }}
@endforeach
@endcomponent

Thanks,

{{ $snipeSettings->site_name }}

@endcomponent
