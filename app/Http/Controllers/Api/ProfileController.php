<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\CheckoutRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Laravel\Passport\TokenRepository;
use Illuminate\Contracts\Validation\Factory as ValidationFactory;

class ProfileController extends Controller
{

    /**
     * The token repository implementation.
     *
     * @var \Laravel\Passport\TokenRepository
     */
    protected $tokenRepository;

    /**
     * Create a controller instance.
     *
     * @param  \Laravel\Passport\TokenRepository  $tokenRepository
     * @param  \Illuminate\Contracts\Validation\Factory  $validation
     * @return void
     */
    public function __construct(TokenRepository $tokenRepository, ValidationFactory $validation)
    {
        $this->validation = $validation;
        $this->tokenRepository = $tokenRepository;
    }

    /**
     * Display a listing of requested assets.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.3.0]
     *
     * @return array
     */
    public function requestedAssets()
    {
        $checkoutRequests = CheckoutRequest::where('user_id', '=', Auth::user()->id)->get();

        $results = [];
        $results['total'] = $checkoutRequests->count();

        foreach ($checkoutRequests as $checkoutRequest) {

            // Make sure the asset and request still exist
            if ($checkoutRequest && $checkoutRequest->itemRequested()) {
                $results['rows'][] = [
                    'image' => e($checkoutRequest->itemRequested()->present()->getImageUrl()),
                    'name' => e($checkoutRequest->itemRequested()->present()->name()),
                    'type' => e($checkoutRequest->itemType()),
                    'qty' => (int) $checkoutRequest->quantity,
                    'location' => ($checkoutRequest->location()) ? e($checkoutRequest->location()->name) : null,
                    'expected_checkin' => Helper::getFormattedDateObject($checkoutRequest->itemRequested()->expected_checkin, 'datetime'),
                    'request_date' => Helper::getFormattedDateObject($checkoutRequest->created_at, 'datetime'),
                ];
            }
        }

        return $results;
    }


    /**
     * Delete an API token
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v6.0.5]
     *
     * @return \Illuminate\Http\Response
     */
    public function createApiToken(Request $request) {

        $accessTokenName = $request->input('name', 'Auth Token');

        if ($accessToken = Auth::user()->createToken($accessTokenName)->accessToken) {
            return response()->json(Helper::formatStandardApiResponse('success', $accessToken, 'Personal access token '.$accessTokenName.' created successfully'));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, 'Token could not be created.'));

    }


    /**
     * Delete an API token
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v6.0.5]
     *
     * @return \Illuminate\Http\Response
     */
    public function deleteApiToken($tokenId) {

        $token = $this->tokenRepository->findForUser(
            $tokenId, Auth::user()->getAuthIdentifier()
        );

        if (is_null($token)) {
            return new Response('', 404);
        }

        $token->revoke();

        return new Response('', Response::HTTP_NO_CONTENT);

    }


    /**
     * Show user's API tokens
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v6.0.5]
     *
     * @return \Illuminate\Http\Response
     */
    public function showApiTokens(Request $request) {

        $tokens = $this->tokenRepository->forUser(Auth::user()->getAuthIdentifier());

        return $tokens->load('client')->filter(function ($token) {
            return $token->client->personal_access_client && ! $token->revoked;
        })->values();

    }



}
