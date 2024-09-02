<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

/**
 * This controller provide the health route  for
 * the Snipe-IT Asset Management application.
 *
 * @version   v1.0
 *
 * @return \Illuminate\Http\JsonResponse

 */
class HealthController extends BaseController
{
    /**
     * Returns a fixed JSON content ({ "status": "ok"}) which indicate the app is up and running
     */
    public function get()
    {
        try {
            DB::select('select 2 + 2');
            return response()->json([
                'status' => 'ok',
            ], 200);

        } catch (\PDOException $e) {
            return response()->json([
                'status' => 'database error: '.$e->getMessage(),
            ], 500);
        }



    }
}
