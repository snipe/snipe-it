<<<<<<< HEAD
Click here to reset your password: <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
=======
{{ trans('mail.reset_password') }} <a href="{{ $link = url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
