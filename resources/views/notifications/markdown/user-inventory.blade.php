@component('mail::message')

This is a reminder of the items currently checked out to you. If you feel this list is inaccurate (something is missing, or something appears here that you believe you never received), please email {{ config('mail.reply_to.name') }} at {{ config('mail.reply_to.address') }}.


@component('mail::table')

@if ($assets->count() > 0)

## {{ $assets->count() }} Assets

<table width="100%">
<tr><th align="left">{{ trans('mail.name') }} </th><th align="left">{{ trans('mail.asset_tag') }}</th></tr>
@foreach($assets as $asset)
<tr><td>{{ $asset->present()->name }}</td><td> {{ $asset->asset_tag }} </td></tr>
@endforeach
</table>
@endif

@if ($accessories->count() > 0)
## {{ $accessories->count() }} Accessories

<table width="100%">
<tr><th align="left">{{ trans('mail.name') }} </th></tr>
@foreach($accessories as $accessory)
<tr><td>{{ $accessory->name }}</td></tr>
@endforeach
</table>
@endif

@if ($licenses->count() > 0)
## {{ $licenses->count() }} Licenses

<table width="100%">
<tr><th align="left"{{ trans('mail.name') }} </th></tr>
@foreach($licenses as $license)
<tr><td>{{ $license->name }}</td></tr>
@endforeach
</table>
@endif


@endcomponent


@endcomponent
