<?php

namespace App\Http\Requests;

use App\Models\LicenseSeat;
use Illuminate\Foundation\Http\FormRequest;

class LicenseCheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'note'   => 'string|nullable',
            'asset_id'  => 'required_without:assigned_to',
        ];
    }

    public function findLicenseSeatToCheckout($license, $seatId)
    {
        // This returns null if seatId is null
        if (!$licenseSeat = LicenseSeat::find($seatId)) {
            $licenseSeat = $license->freeSeat();
        }

        if (!$licenseSeat) {
            if ($seatId) {
                return redirect()->route('licenses.index')->with('error', 'This Seat is not available for checkout.');
            }
            return redirect()->route('licenses.index')->with('error', 'There are no available seats for this license');
        }

        if(!$licenseSeat->license->is($license)) {
            return redirect()->route('licenses.index')->with('error', 'The license seat provided does not match the license.');
        }

        return $licenseSeat;
    }
}
