<?php
namespace App\Http\Transformers;

use App\Models\LicenseSeat;
use Gate;
use Illuminate\Database\Eloquent\Collection;
use App\Helpers\Helper;

class LicenseSeatsTransformer
{

    public function transformLicenseSeats (Collection $seats, $total)
    {
        $array = array();
        $seat_count = 0;
        foreach ($seats as $seat) {
            $seat_count++;
            $array[] = self::transformLicenseSeat($seat, $seat_count);
        }
        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformLicenseSeat (LicenseSeat $seat, $seat_count)
    {
        $array = [
            'id' => (int) $seat->id,
            'license_id' => (int) $seat->license->id,
            'name' => 'Seat '.$seat_count,
            'assigned_user' => ($seat->user) ? [
                'id' => (int) $seat->user->id,
                'name'=> e($seat->user->present()->fullName)
            ] : null,
            'assigned_asset' => ($seat->asset) ? [
                'id' => (int) $seat->asset->id,
                'name'=> e($seat->asset->present()->fullName)
            ] : null,
            'location' => ($seat->location()) ? [
                'id' => (int) $seat->location()->id,
                'name'=> e($seat->location()->name)
            ] : null,
            'reassignable' => (bool) $seat->license->reassignable,
            'user_can_checkout' => (($seat->assigned_to=='') && ($seat->asset_id=='')) ? true : false,
        ];

        $permissions_array['available_actions'] = [
            'checkout' => Gate::allows('checkout', License::class) ? true : false,
            'checkin' => Gate::allows('checkin', License::class) ? true : false,
            'clone' => Gate::allows('create', License::class) ? true : false,
            'update' => Gate::allows('update', License::class) ? true : false,
            'delete' => Gate::allows('delete', License::class) ? true : false,
        ];

        $array += $permissions_array;

        return $array;
    }





}
