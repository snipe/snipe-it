<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>{{ trans('mail.password_reset') }}</h2>

        <div>
            {{ trans('mail.to_reset', ['web' => $snipeSettings->site_name]) }} {{ URL::to('password/reset', array($token)) }}.
        </div>
    </body>
</html>
