<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class VersionController extends Controller
{
    /**
     * Get the current version of Snipe-IT
     *
     * @author [Nebelkreis] [https://github.com/NebelKreis]
     *
     * @return JsonResponse Returns JSON response with version information
     */
    public function index(): JsonResponse
    {
        return response()->json(
            [
                'version' => config('version.app_version'),
                'build_version' => config('version.build_version'),
                'hash_version' => config('version.hash_version'),
                'full_version' => config('version.full_app_version')
            ]
        );
    }
}
