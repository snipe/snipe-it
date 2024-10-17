@component('mail::message')
# {{ trans('mail.hello') }} {{ $target->present()->fullName() }},

{{ trans('mail.the_following_item') }}

@component('mail::table')
|        |          |
| ------------- | ------------- |
| **{{ trans('mail.asset_name') }}** | {{ $item->name }} |
@if (isset($item->manufacturer))
| **{{ trans('general.manufacturer') }}** | {{ $item->manufacturer->name }} |
@endif
@if ($target->can('update', $item))
| **Key** | {{ $item->serial }} |
@endif
@if (isset($item->category))
| **{{ trans('general.category') }}** | {{ $item->category->name }} |
@endif
@if ($admin)
| **{{ trans('general.administrator') }}** | {{ $admin->present()->fullName() }} |
@endif
@if ($note)
| **{{ trans('mail.additional_notes') }}** | {{ $note }} |
@endif
@endcomponent

{{ trans('mail.best_regards') }}

{{ $snipeSettings->site_name }}

@endcomponent
