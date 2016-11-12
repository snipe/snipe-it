<<<<<<< HEAD
Hi {{ $first_name }},

Login to your new Snipe-IT installation using the credentials below:

URL: {{ config('app.url') }}
Username: {{ $username }}
Password: {{ $password }}
=======
{{ trans('mail.hi') }} {{ $first_name }},

{{ trans('mail.login_first_admin') }}

URL: {{ config('app.url') }}
{{ trans('mail.username') }} {{ $username }}
{{ trans('mail.password') }} {{ $password }}
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
