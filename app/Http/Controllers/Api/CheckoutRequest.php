<?php

namespace App\Http\Controllers\Api;

use App\Actions\CheckoutRequests\CancelCheckoutRequest;
use App\Actions\CheckoutRequests\CreateCheckoutRequest;
use App\Exceptions\AssetNotRequestable;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;

class CheckoutRequest extends Controller
{
    public function store(Asset $asset): JsonResponse
    {
        try {
            CreateCheckoutRequest::run($asset, auth()->user());
            return response()->json(Helper::formatStandardApiResponse('success', null, trans('admin/hardware/message.requests.success')));
        } catch (AssetNotRequestable $e) {
            return response()->json(Helper::formatStandardApiResponse('error', 'Asset is not requestable'));
        } catch (AuthorizationException $e) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('general.insufficient_permissions')));
        } catch (\Exception $e) {
            report($e);
            return response()->json(Helper::formatStandardApiResponse('error', null, 'Something terrible has gone wrong and we\'re not sure if we can help - may god have mercy on your soul. Contact your admin :)'));
        }
    }

    public function destroy(Asset $asset): JsonResponse
    {
        try {
            CancelCheckoutRequest::run($asset, auth()->user());
            return response()->json(Helper::formatStandardApiResponse('success', null, trans('admin/hardware/message.requests.canceled')));
        } catch (\Exception $e) {
            report($e);
            return response()->json(Helper::formatStandardApiResponse('error', null, $e->getMessage()));
        }
    }
}
