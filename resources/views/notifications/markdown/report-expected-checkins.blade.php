@component('mail::message')
# {{ trans('mail.hello') }},

{{ trans('general.due_to_checkin', array('count' => $assets->count())) }}

@component('mail::table')
| {{ trans('general.assets') }} | {{ trans('general.checked_out_to') }} | {{ trans('general.expected_checkin') }} |
| ------------- | ------------- | ------------- |
@foreach ($assets as $asset)
@php
$checkin = Helper::getFormattedDateObject($asset->expected_checkin, 'date');
@endphp
| [{{ $asset->present()->name }}]({{ route('hardware.show', $asset) }}) | [{{ $asset->assignedTo->present()->fullName }}]({{ route($asset->targetShowRoute().'.show', [$asset->assignedTo->id]) }})  | {{ $checkin['formatted'] }}
@endforeach
@endcomponent

{{ trans('mail.best_regards') }}

{{ $snipeSettings->site_name }}

@endcomponent
