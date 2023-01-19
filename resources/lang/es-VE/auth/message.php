<?php

return array(

    'account_already_exists' => 'Una cuenta con este correo ya existe.',
    'account_not_found'      => 'El nombre de usuario o la contraseña son incorrectos.',
    'account_not_activated'  => 'La cuenta de este usuario no está activada.',
    'account_suspended'      => 'La cuenta de este usuario está suspendida.',
    'account_banned'         => 'La cuenta de este usuario está bloqueada.',
    'throttle'               => 'Demasiados intentos de inicio de sesión fallidos. Por favor, intente otra vez en alrededor de :minutes minuto/s.',

    'two_factor' => array(
        'already_enrolled'      => 'Su dispositivo ya está inscrito.',
        'success'               => 'Usted inició sesión correctamente.',
        'code_required'         => 'Se requiere el código de 2FA(Autenticación en dos pasos) .',
        'invalid_code'          => 'El código de doble factor es inválido.',
    ),

    'signin' => array(
        'error'   => 'Hubo un problema mientras se intentaba iniciar su sesión, por favor inténtelo de nuevo.',
        'success' => 'Has iniciado sesión con éxito.',
    ),

    'logout' => array(
        'error'   => 'Hubo un problema al intentar cerrar la sesión, por favor inténtelo de nuevo.',
        'success' => 'Has cerrado la sesión con éxito.',
    ),

    'signup' => array(
        'error'   => 'Hubo un problema mientras se creaba la cuenta, por favor inténtalo de nuevo.',
        'success' => 'Cuenta creada con éxito.',
    ),

    'forgot-password' => array(
        'error'   => 'Hubo un problema al intentar obtener un código para restablecer la contraseña, inténtalo de nuevo.',
        'success' => 'Si esa dirección de correo electrónico existe en nuestro sistema, recibirá un correo electrónico de recuperación de contraseña.',
    ),

    'forgot-password-confirm' => array(
        'error'   => 'Ha habido un problema mientras se intentaba restablecer tu contraseña, por favor, inténtalo de nuevo.',
        'success' => 'Tu contraseña ha sido reiniciada con éxito.',
    ),


);
