<?php

namespace App\Services;

use App\Models\PredefinedKit;
use App\Models\User;
use App\Http\Controllers\CheckInOutRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Events\CheckoutableCheckedOut;


/**
 * Class incapsulates checkout logic for reuse in different controllers
 * @author [D. Minaev.] [<dmitriy.minaev.v@gmail.com>]
 */
class PredefinedKitCheckoutService
{
    use AuthorizesRequests;
    /**
     * @param Request $request, this function works with fields: checkout_at, expected_checkin, note
     * @param PredefinedKit $kit kit for checkout
     * @param User $user checkout target
     * @return array Empty array if all ok, else [string_error1, string_error2...]
     */
    public function checkout(Request $request, PredefinedKit $kit, User $user) {
        try {

            // Check if the user exists
            if (is_null($user) ) {
                return [trans('admin/users/message.user_not_found')];
            }

            $errors = [];

            $assets_to_add = $this->getAssetsToAdd($kit, $user, $errors);
            $license_seats_to_add = $this->getLicenseSeatsToAdd($kit, $user, $errors);
            $consumables_to_add = $this->getConsumablesToAdd($kit, $user, $errors);
            $accessories_to_add = $this->getAccessoriesToAdd($kit, $user, $errors);

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

            $errors = DB::transaction(
            function () use ($user, $admin, $checkout_at, $expected_checkin, $errors, $assets_to_add, $license_seats_to_add, $consumables_to_add, $accessories_to_add, $note) {
                // assets
                foreach ($assets_to_add as $asset) {
                    $asset->location_id = $user->location_id;
                    $error = $asset->checkOut($user, $admin, $checkout_at, $expected_checkin, $note, null);
                    if ($error) {
                        array_merge_recursive($errors, $asset->getErrors()->toArray());
                    }
                }
                // licenses
                foreach ($license_seats_to_add as $licenseSeat) {
                    $licenseSeat->user_id = $admin->id;
                    $licenseSeat->assigned_to = $user->id;
                    if ($licenseSeat->save()) {
                        event(new CheckoutableCheckedOut($licenseSeat, $user, $admin, $note));
                    }
                    else {
                        $errors []= 'Something went wrong saving a license seat';
                    }
                }
                // consumables
                foreach($consumables_to_add as $consumable) {
                    $consumable->assigned_to = $user->id;
                    $consumable->users()->attach($consumable->id, [
                        'consumable_id' => $consumable->id,
                        'user_id' => $admin->id,
                        'assigned_to' => $user->id
                    ]);
                    event(new CheckoutableCheckedOut($consumable, $user, $admin, $note));
                }
                //accessories
                foreach($accessories_to_add as $accessory) {
                    $accessory->assigned_to = $user->id;
                    $accessory->users()->attach($accessory->id, [
                        'accessory_id' => $accessory->id,
                        'user_id' => $admin->id,
                        'assigned_to' => $user->id
                    ]);
                    event(new CheckoutableCheckedOut($accessory, $user, $admin, $note));
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

    protected function getAssetsToAdd($kit, $user, &$errors) {
        $models = $kit->models()
                        ->with( ['assets' => function($hasMany) { $hasMany->RTD(); }] )
                        ->get();
        $assets_to_add = [];
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

        return $assets_to_add;
    }

    protected function getLicenseSeatsToAdd($kit, $user, &$errors) {
        $seats_to_add = [];
        $licenses = $kit->licenses()
                        ->with('freeSeats')
                        ->get();
        foreach($licenses as $license) {
            $quantity = $license->pivot->quantity;
            if( $quantity > count($license->freeSeats) ) {
                $errors []= "Don't have free seats for license " . $license->name . '. Need ' . $quantity . ' seats.';      // TODO: trans
            }
            for($i=0; $i < $quantity; $i++) {
                $seats_to_add []= $license->freeSeats[$i];
            }
        }
        return $seats_to_add;
    }

    protected function getConsumablesToAdd($kit, $user, &$errors) {
        // $consumables = $kit->consumables()->withCount('consumableAssignments as consumable_assignments_count')->get();
        $consumables = $kit->consumables()->with('users')->get();
        foreach($consumables as $consumable) {
            if( $consumable->numRemaining() < $consumable->pivot->quantity ) {
                $errors []= "Don't have available consumable " . $consumable->name . '. Need ' . $consumable->pivot->quantity;      // TODO: trans
            }
        }
        return $consumables;
    }

    protected function getAccessoriesToAdd($kit, $user, &$errors) {
        $accessories = $kit->accessories()->with('users')->get();
        foreach($accessories as $accossory) {
            if( $accossory->numRemaining() < $accossory->pivot->quantity ) {
                $errors []= "Don't have available accossory " . $accossory->name . '. Need ' . $accossory->pivot->quantity;      // TODO: trans
            }
        }
        return $accessories;
    }
}
