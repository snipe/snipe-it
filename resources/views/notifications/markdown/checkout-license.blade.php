@component('mail::message')
# {{ trans('mail.hello') }} {{ $target->present()->fullName() }},

{{ trans('mail.new_item_checked') }}

@component('mail::table')
|        |          |
| ------------- | ------------- |
@if (isset($checkout_date))
| **{{ trans('mail.checkout_date') }}** | {{ $checkout_date }} |
@endif
| **{{ trans('general.license') }}** | {{ $item->name }} |
@if (isset($item->manufacturer))
| **{{ trans('general.manufacturer') }}** | {{ $item->manufacturer->name }} |
@endif
@if ($target->can('update', $item))
| **Key** | {{ $item->serial }} |
@endif
@if ($note)
| **{{ trans('mail.additional_notes') }}** | {{ $note }} |
@endif
@if ($admin)
| **{{ trans('general.administrator') }}** | {{ $admin->present()->fullName() }} |
@endif
@endcomponent


Thanks,

{{ $snipeSettings->site_name }}

@endcomponent
