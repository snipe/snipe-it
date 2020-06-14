@component('mail::message')

{{ trans('mail.test_mail_text') }}

{{ trans('mail.thanks') }}

{{ $snipeSettings->site_name }}
@endcomponent
