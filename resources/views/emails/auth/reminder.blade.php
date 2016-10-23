<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h2>Password Reset</h2>

        <div>
            To reset your {{ \App\Models\Setting::getSettings()->site_name }} password, complete this form: {{ URL::to('password/reset', array($token)) }}.
        </div>
    </body>
</html>
