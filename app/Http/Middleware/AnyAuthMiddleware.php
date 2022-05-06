<?php

namespace App\Http\Middleware;

use Closure;

//use Illuminate\Routing\MiddlewareNameResolver;
use \Illuminate\Auth\Middleware\Authenticate;
use \Illuminate\Auth\AuthenticationException;

class AnyAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        $auth = resolve(Authenticate::class);
        $middleware_results = null;
        $last_exception = null;

        foreach( [ 'empty', 'api' ] as $middleware_parameter ) { // first try 'auth', then 'auth:api'

            $auth_worked = false;

            // We have to assemble together an array of parameters, then use the splat
            // operator (...) to call the function with the right number of parameters
            $midparms = [$request, function ($subrequest) use (&$auth_worked) {
                $auth_worked = true;
                $last_exception = null;
            }];

            if ($middleware_parameter != 'empty') {
                $midparms[] = $middleware_parameter;
            }

            try {
                $middleware_results = $auth->handle(...$midparms); //I hate that this is so awkward :(
            } catch (AuthenticationException $e) {
                $auth_worked = false;
                $last_exception = $e;
            }

            if ( $auth_worked ) {
                return $next($request);
            }
        }

        // If there was an exception thrown during the final failure, re-throw that. Otherwise return the final failed result
        if ($last_exception) {
            throw $last_exception;
        } else {
            return $middleware_results;
        }
    }

    // This below method is cooler and could help if there were other times we wanted 'any' middleware to work, but it doesn't work
    // I had too much trouble with the MiddlewareNameResolver :/
    /* public function handle($request, Closure $next, $middleware_string)
    {
        \Log::info("Middleware string: $middleware_string");
        $middlewares = explode(",",$middleware_string);

        foreach($middlewares as $middleware) {
            $middleware_bits = explode(':', $middleware);
            $this_thing = MiddlewareNameResolver::resolve($middleware_bits[0]);

            $called_next = false;
            $results = $this_thing->handle( $request, function () use ($called_next) {
                $called_next = true;
            }, $middleware_bits[1] );

            if( $called_next == true ) { //short-circuit any further middleware checks; we're good!
                return $next($request);
            }
        }
        return $results; //nothing ever got properly short-circuited, so return the error from the *LAST* middleware
    } */

}
