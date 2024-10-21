<?php

namespace App\Http\Controllers\Api;

use App\Actions\CheckoutRequests\CreateCheckoutRequest;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class CheckoutRequest extends Controller
{
    public function store($assetId): JsonResponse
    {
        CreateCheckoutRequest::run($assetId);
    }
}
