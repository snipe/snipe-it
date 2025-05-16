<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class VersionController extends Controller
{
    /**
     * Get the current version of Snipe-IT
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'version' => config('version.app_version'),
            'full_version' => config('version.full_app_version'),
            'build_version' => config('version.build_version'),
            'hash_version' => config('version.hash_version')
        ]);
    }
}
