<?php

namespace App\Http\Controllers\Api;

use App\Actions\CheckoutRequests\CreateCheckoutRequest;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckoutRequest extends Controller
{
    public function store($assetId): JsonResponse
    {
        $status = CreateCheckoutRequest::run($assetId);

        return match ($status) {
            'doesNotExist' => response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/hardware/message.does_not_exist_or_not_requestable'))),
            'accessDenied' => response()->json(Helper::formatStandardApiResponse('error', null, trans('general.insufficient_permissions'))),
            default => response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/hardware/message.request_successfully_created'))),
        };
    }
}
