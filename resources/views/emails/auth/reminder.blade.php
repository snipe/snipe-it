<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
<<<<<<< HEAD
        <h2>Password Reset</h2>

        <div>
            To reset your {{ \App\Models\Setting::getSettings()->site_name }} password, complete this form: {{ URL::to('password/reset', array($token)) }}.
=======
        <h2>{{ trans('mail.password_reset') }}</h2>

        <div>
            {{ trans('mail.to_reset', ['web' => \App\Models\Setting::getSettings()->site_name]) }} {{ URL::to('password/reset', array($token)) }}.
>>>>>>> 62f5a1b2c7934f534fc8fc8299831fc32e794a72
        </div>
    </body>
</html>
