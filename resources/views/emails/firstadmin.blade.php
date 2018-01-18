{{ trans('mail.hi') }} {{ $first_name }},

{{ trans('mail.login_first_admin') }}

URL: {{ url('/') }}
{{ trans('mail.username') }} {{ $username }}
{{ trans('mail.password') }} {{ $password }}
