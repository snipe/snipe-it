@if ($setupCompleted = \App\Models\Setting::setupCompleted())
@component('mail::message')
@endif

{{ trans('mail.test_mail_text') }}

{{ trans('mail.best_regards') }}
{{ $snipeSettings->site_name }}
@if ($setupCompleted)
@endcomponent
@endif
