<?php

return array(

    'account_already_exists' => 'Ya existe un usuario con este e-mail.',
    'account_not_found'      => 'El nombre de usuario o contraseña es incorrecta.',
    'account_not_activated'  => 'Este usuario no está activado.',
    'account_suspended'      => 'Este usuario está desactivado.',
    'account_banned'         => 'Este usuario ha sido expulsado.',
    'throttle'               => 'Demasiados intentos de inicio de sesión fallidos. Por favor, intente otra vez en alrededor de :minutes minuto/s.',

    'two_factor' => array(
        'already_enrolled'      => 'Su dispositivo ya está inscrito.',
        'success'               => 'Ha iniciado sesión exitosamente.',
        'code_required'         => 'Se requiere el código de 2FA(Autenticación en dos pasos) .',
        'invalid_code'          => 'El código de doble factor es inválido.',
        'enter_two_factor_code' => 'Por favor ingrese su código de autenticación de dos factores.',
        'please_enroll'         => 'Por favor inscriba un dispositivo en la autenticación de dos factores.',
    ),

    'signin' => array(
        'error'   => 'Ha habido un problema al iniciar sesión. Por favor, vuelve a intentarlo.',
        'success' => 'Ha iniciado sesión exitosamente.',
    ),

    'logout' => array(
        'error'   => 'Hubo un problema al intentar cerrar la sesión, por favor inténtelo de nuevo.',
        'success' => 'Ha cerrado la sesión exitosamente.',
    ),

    'signup' => array(
        'error'   => 'Ha habido un problema al crear la cuenta. Por favor, vuelve a intentarlo.',
        'success' => 'Cuenta creada correctamente.',
    ),

    'forgot-password' => array(
        'error'   => 'Ha habido un problema al intentar resetear el password. Por favor, vuelve a intentarlo.',
        'success' => 'Si esa dirección de correo electrónico existe en nuestro sistema, recibirá un correo electrónico de recuperación de contraseña.',
    ),

    'forgot-password-confirm' => array(
        'error'   => 'Hubo un problema al intentar restablecer su contraseña, por favor inténtelo de nuevo.',
        'success' => 'Su contraseña se ha restablecido correctamente.',
    ),


);
