<?php

namespace App\Http\Middleware;

use App\Helpers\Helper;
use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnforceApiTwoFactorEnrollment
{
    public function handle(Request $request, Closure $next)
    {
        // If auth:api didn't populate a user (bad token, no token), let it
        // produce the standard 401 rather than emitting a 403 here.
        $user = $request->user();
        if ($user === null) {
            return $next($request);
        }

        $settings = Setting::getSettings();
        if ($settings === null) {
            return $next($request);
        }

        // Normalize the same way CheckForTwoFactor does: only '1' (optional)
        // and '2' (required for all) count as on. Empty, '0', null all mean
        // 2FA is disabled and we don't gate the API.
        $mode = (string) $settings->two_factor_enabled;
        if ($mode !== '1' && $mode !== '2') {
            return $next($request);
        }

        // Optional mode only gates users who opted in; matches the web-side
        // semantics so an install can't accidentally break every legacy PAT
        // by flipping optional 2FA on.
        if ($mode === '1' && (string) $user->two_factor_optin !== '1') {
            return $next($request);
        }

        // Stateless bearer tokens can't prompt for a live TOTP code, so the
        // strongest guarantee we can enforce is that the token's owner has
        // provisioned and confirmed a TOTP secret. A PAT owned by a not-yet-
        // enrolled user gets refused so that setting two_factor_enabled = 2
        // actually gates the API surface (previously it only gated the web
        // group, leaving already-issued PATs fully live). Web session auth
        // still flows through CheckForTwoFactor and remains untouched.
        if ((string) $user->two_factor_enrolled !== '1') {
            return response()->json(
                Helper::formatStandardApiResponse('error', null, trans('auth/message.two_factor.please_enroll')),
                Response::HTTP_FORBIDDEN,
            );
        }

        return $next($request);
    }
}
