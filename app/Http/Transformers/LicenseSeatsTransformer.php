<?php
namespace App\Http\Transformers;

use App\Models\License;
use App\Models\LicenseSeat;
use Gate;
use Illuminate\Database\Eloquent\Collection;

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
            'assigned_to' => $this->transformAssignedTo($seat),
            'reassignable' => (bool) $seat->license->reassignable,
            'user_can_checkout' => $seat->assigned ? false : true,
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

    /**
     * Transforms the assignedTo relationship.
     *
     * @author [D. Stumm] [@dennis95stumm]
     * @param $seat
     * @return array|null
     */
    private function transformAssignedTo($seat)
    {
        if ($seat->assignedType()=='user') {
            return $seat->assigned ? [
                'id' => (int) $seat->assigned->id,
                'username' => e($seat->assigned->username),
                'name' => e($seat->assigned->getFullNameAttribute()),
                'first_name'=> e($seat->assigned->first_name),
                'last_name'=> ($seat->assigned->last_name) ? e($seat->assigned->last_name) : null,
                'employee_number' =>  ($seat->assigned->employee_num) ? e($seat->assigned->employee_num) : null,
                'type' => 'user'
            ] : null;
        }
        return $seat->assigned ? [
            'id' => $seat->assigned->id,
            'name' => $seat->assigned->display_name,
            'type' => $seat->assignedType()
        ] : null;
    }



}
