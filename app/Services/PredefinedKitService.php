<?php

namespace App\Services;

use App\Models\PredefinedKit;
use App\Models\User;
use App\Http\Controllers\CheckInOutRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class PredefinedKitService
{
    use AuthorizesRequests;
    /**
     * @return array [string_error1, string_error2...]
     */
    public function checkout(Request $request, PredefinedKit $kit, User $user) {
        try {

            $models = $kit->models()
                        ->with( ['assets' => function($hasMany) { $hasMany->RTD(); }] )
                        ->get();
            //$licenses = $kit->licenses()->with(['assets' => function($hasMany) { $hasMany->RTD();  }])->get();

            // Check if the user exists
            if (is_null($user) ) {
                return [trans('admin/users/message.user_not_found')];
            }

            $assets_to_add = [];
            $errors = [];
            foreach($models as $model) {
                $assets = $model->assets;
                $quantity = $model->pivot->quantity;
                foreach($assets as $asset) {

                    if ($asset->availableForCheckout()
                    && !$asset->is($user)) {

                        $this->authorize('checkout', $asset);
                        $quantity -= 1;
                        $assets_to_add []= $asset;
                        if($quantity <= 0) {
                            break;
                        }
                    }
                }
                if($quantity > 0) {
                    $errors []= "Don't have available assets for model " . $model->name . '. Need ' . $model->pivot->quantity . ' assets.';      // TODO: trans
                }
            }

            if( count($errors) > 0 ) {
                return $errors;
            }

            $checkout_at = date("Y-m-d H:i:s");
            if (($request->filled('checkout_at')) && ($request->get('checkout_at')!= date("Y-m-d"))) {
                $checkout_at = $request->get('checkout_at');
            }

            $expected_checkin = '';
            if ($request->filled('expected_checkin')) {
                $expected_checkin = $request->get('expected_checkin');
            }

            $admin = Auth::user();

            $note = e($request->get('note'));

            $errors = DB::transaction(function () use ($user, $admin, $checkout_at, $expected_checkin, $errors, $assets_to_add, $note) {

                foreach ($assets_to_add as $asset) {                  

                    $asset->location_id = $user->location_id;
                    
                    $error = $asset->checkOut($user, $admin, $checkout_at, $expected_checkin, $note, null);

                    if ($error) {
                        array_merge_recursive($errors, $asset->getErrors()->toArray());
                    }
                }
                return $errors;
            });

            return $errors;
            
        } catch (ModelNotFoundException $e) {
            return [$e->getMessage()];
        } catch (CheckoutNotAllowed $e) {
            return [$e->getMessage()];
        }
    }

}
