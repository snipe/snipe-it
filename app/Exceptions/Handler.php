<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Session\TokenMismatchException::class,
        \Illuminate\Validation\ValidationException::class,
        \Intervention\Image\Exception\NotSupportedException::class,
        \League\OAuth2\Server\Exception\OAuthServerException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        

        $this->reportable(function (Throwable $e) {

            // CSRF token mismatch error
            if ($e instanceof \Illuminate\Session\TokenMismatchException) {
                return redirect()->back()->with('error', trans('general.token_expired'));
            }


            // Handle Ajax requests that fail because the model doesn't exist
            if ($request->ajax() || $request->wantsJson()) {
                

                if ($e instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
                    $className = last(explode('\\', $e->getModel()));
                    return response()->json(Helper::formatStandardApiResponse('error', null, $className . ' not found'), 200);
                }

                if ($this->isHttpException($e)) {

                    $statusCode = $e->getStatusCode();

                    switch ($e->getStatusCode()) {
                        case '404':
                        return response()->json(Helper::formatStandardApiResponse('error', null, $statusCode . ' endpoint not found'), 404);
                        case '405':
                            return response()->json(Helper::formatStandardApiResponse('error', null, 'Method not allowed'), 405);
                        default:
                            return response()->json(Helper::formatStandardApiResponse('error', null, $statusCode), 405);

                    }
                }
            }


            if ($this->isHttpException($e) && (isset($statusCode)) && ($statusCode == '404' )) {
                return response()->view('layouts/basic', [
                    'content' => view('errors/404')
                ],$statusCode);
            }

            return parent::render($request, $e);
            });
    }
}
