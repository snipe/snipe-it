@component('mail::message')
# {{ trans('mail.hello') }} {{ $target->present()->fullName() }},

{{ trans('mail.the_following_item') }}

@if ($item->getImageUrl())
<center><img src="{{ $item->getImageUrl() }}" alt="Asset" style="max-width: 570px;"></center>
@endif

@component('mail::table')
|        |          |
| ------------- | ------------- |
| **{{ trans('mail.asset_name') }}** | {{ $item->name }} |
| **{{ trans('mail.asset_tag') }}** | {{ $item->asset_tag }} |
@if (isset($item->manufacturer))
| **{{ trans('general.manufacturer') }}** | {{ $item->manufacturer->name }} |
@endif
@if (isset($item->model_no))
| **{{ trans('general.model_no') }}** | {{ $item->model_no }} |
@endif
@if ($admin)
| **{{ trans('general.administrator') }}** | {{ $admin->present()->fullName() }} |
@endif
@if ($note)
| **{{ trans('mail.additional_notes') }}** | {{ $note }} |
@endif
@endcomponent

Thanks,

{{ $snipeSettings->site_name }}

@endcomponent
