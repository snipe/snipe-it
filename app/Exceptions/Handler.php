<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use App\Helpers\Helper;
use Illuminate\Validation\ValidationException;
use Log;
use Throwable;


class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        if ($this->shouldReport($exception)) {
            Log::error($exception);
            return parent::report($exception);
        }
    }

    /**
     * Render an exception into an HTTP response.
     * 
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $e)
    {


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

    }

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
            //
        });
    }
}
