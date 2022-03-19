@component('mail::message')
# {{ trans('mail.hello') }},

{{ trans('mail.Expected_Checkin_Date', ['date' => $date]) }}

@if ((isset($asset)) && ($asset!=''))
{{ trans('mail.asset_name') }} {{ $asset }}
@endif
{{ trans('mail.asset_tag') }} {{ $asset_tag }}
@if (isset($serial))
{{ trans('mail.serial') }}: {{ $serial }}
@endif

**[{{ trans('mail.your_assets') }}]({{ route('view-assets') }})**

{{ trans('mail.best_regards') }}

{{ $snipeSettings->site_name }}

@endcomponent
