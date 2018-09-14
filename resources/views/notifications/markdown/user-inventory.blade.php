@component('mail::message')

This is a reminder of the items currently checked out to you. If you feel this list is inaccurate (something is missing, or something appears here that you believe you never received), please email {{ config('mail.reply_to.name') }} at {{ config('mail.reply_to.address') }}.


@component('mail::table')

@if ($assets->count() > 0)
## {{ $assets->count() }} Assets
|{{ trans('mail.name') }} |{{ trans('mail.asset_tag') }} |
|:------------- |:-------------|:---------|
@foreach($assets as $asset)
|{{ $asset->present()->name }} |{{ $asset->asset_tag }} |
@endforeach
@endif

@if ($accessories->count() > 0)
## {{ $accessories->count() }} Accessories
|{{ trans('mail.name') }} |
| |:------------- |
@foreach($accessories as $accessory)
|{{ $accessory->name }} |
@endforeach
@endif

@if ($licenses->count() > 0)
## {{ $licenses->count() }} Licenses

| |:------------- |
@foreach($licenses as $license)
|{{ $asset->$license }} |
@endforeach
@endif


@endcomponent


@endcomponent
