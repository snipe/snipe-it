@component('mail::message')

{{ trans('mail.test_mail_text') }}

Thanks,<br>
    @if ($snipeSettings->show_url_in_emails=='1')
        <p><a href="{{ url('/') }}">{{ $snipeSettings->site_name }}</a></p>
    @else
        <p>{{ $snipeSettings->site_name }}</p>
    @endif
@endcomponent
