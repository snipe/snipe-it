<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;


Route::post('/mobile/login', function (Request $request) {
    $credentials = $request->only('username', 'password');

    if (Auth::attempt($credentials)) {
        // Authentication passed...
        $user = Auth::user();
        $token = $user->createToken($request->device_name);

        return response()->json([
            'token'    => $token->accessToken,
            'token_id' => $token->token->id,
            'user'     => $user->only('id', 'first_name', 'last_name', 'email')
        ]);
    } else {
        return response()->json(['error' => 'Authentication Failed'], 401);
    }
})->name('mobile.login');

Route::post('/mobile/logout', function (Request $request) {
    $tokenId = $request->token_id;
    $tokenRepository = app(TokenRepository::class);
    $refreshTokenRepository = app(RefreshTokenRepository::class);

    // Revoke an access token...
    $tokenRepository->revokeAccessToken($tokenId);

    // Revoke all of the token's refresh tokens...
    $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);
    return response()->json(['msg' => 'logged out'], 200);
})->name('mobile.logout');