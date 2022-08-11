@component('mail::message')
# {{ trans('mail.hello') }},

{{ $intro_text }}.

@if (($snipeSettings->show_images_in_email =='1') && $item->getImageUrl())
<center><img src="{{ $item->getImageUrl() }}" alt="Asset" style="max-width: 570px;"></center>
@endif

@component('mail::table')
|        |          |
| ------------- | ------------- |
| **{{ trans('mail.user') }}** | [{{ $assigned_to->present()->fullName() }}]({{ route('users.show', $assigned_to->id) }}) |
| **{{ trans('general.requested') }}** | {{ $accepted_date }} |
@if ((isset($item_tag)) && ($item_tag!=''))
| **{{ trans('mail.asset_tag') }}** | {{ $item_tag }} |
@endif
@if ((isset($item_model)) && ($item_model!=''))
| **{{ trans('mail.asset_name') }}** | {{ $item_model }} |
@endif
@if (isset($item->model))
| **{{ trans('general.asset_model') }}** | {{ $item->model->name }} |
@endif
@if (isset($item_serial))
| **{{ trans('mail.serial') }}** | {{ $item_serial }} |
@endif
@endcomponent

{{ trans('mail.best_regards') }}

{{ $snipeSettings->site_name }}

@endcomponent
