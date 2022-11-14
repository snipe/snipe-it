@component('mail::message')

{{ trans('general.reminder_checked_out_items', array('reply_to_name' => config('mail.reply_to.name'), 'reply_to_address' => config('mail.reply_to.address')))}}

@component('mail::table')

@if ($assets->count() > 0)

## {{ $assets->count() }} {{ trans('general.assets') }}

<table width="100%">
<tr><th align="left">{{ trans('mail.name') }} </th><th align="left">{{ trans('mail.asset_tag') }}</th></tr>
@foreach($assets as $asset)
<tr><td>{{ $asset->present()->name }}</td><td> {{ $asset->asset_tag }} </td></tr>
@endforeach
</table>
@endif

@if ($accessories->count() > 0)
## {{ $accessories->count() }} {{ trans('general.accessories') }}

<table width="100%">
<tr><th align="left">{{ trans('mail.name') }} </th></tr>
@foreach($accessories as $accessory)
<tr><td>{{ $accessory->name }}</td></tr>
@endforeach
</table>
@endif

@if ($licenses->count() > 0)
## {{ $licenses->count() }} {{ trans('general.licenses') }}

<table width="100%">
<tr><th align="left"{{ trans('mail.name') }} </th></tr>
@foreach($licenses as $license)
<tr><td>{{ $license->name }}</td></tr>
@endforeach
</table>
@endif


@endcomponent


@endcomponent
