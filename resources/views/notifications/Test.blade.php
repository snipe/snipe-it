@component('mail::message')

{{ trans('mail.test_mail_text') }}

Thanks,<br>
{{ $snipeSettings->site_name }}
@endcomponent
