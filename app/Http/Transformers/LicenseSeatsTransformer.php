<?php

namespace App\Http\Transformers;

use App\Models\License;
use App\Models\LicenseSeat;
use Gate;
use Illuminate\Database\Eloquent\Collection;

class LicenseSeatsTransformer
{
    public function transformLicenseSeats(Collection $seats, $total)
    {
        $array = [];
        $seat_count = 0;
        foreach ($seats as $seat) {
            $seat_count++;
            $array[] = self::transformLicenseSeat($seat, $seat_count);
        }

        return (new DatatablesTransformer)->transformDatatables($array, $total);
    }

    public function transformLicenseSeat(LicenseSeat $seat, $seat_count = 0)
    {
        $array = [
            'id' => (int) $seat->id,
            'license_id' => (int) $seat->license->id,
            'assigned_user' => ($seat->user) ? [
                'id' => (int) $seat->user->id,
                'name'=> e($seat->user->present()->fullName),
                'department'=> ($seat->user->department) ?
                        [
                            'id' => (int) $seat->user->department->id,
                            'name' => e($seat->user->department->name),

                        ] : null,
            ] : null,
            'assigned_asset' => ($seat->asset) ? [
                'id' => (int) $seat->asset->id,
                'name'=> e($seat->asset->present()->fullName),
            ] : null,
            'location' => ($seat->location()) ? [
                'id' => (int) $seat->location()->id,
                'name'=> e($seat->location()->name),
            ] : null,
            'reassignable' => (bool) $seat->license->reassignable,
            'user_can_checkout' => (($seat->assigned_to == '') && ($seat->asset_id == '')),
        ];

        if ($seat_count != 0) {
            $array['name'] = 'Seat '.$seat_count;
        }

        $permissions_array['available_actions'] = [
            'checkout' => Gate::allows('checkout', License::class),
            'checkin' => Gate::allows('checkin', License::class),
            'clone' => Gate::allows('create', License::class),
            'update' => Gate::allows('update', License::class),
            'delete' => Gate::allows('delete', License::class),
        ];

        $array += $permissions_array;

        return $array;
    }
}
