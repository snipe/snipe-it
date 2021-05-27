<?php 
namespace App\Http\Controllers\Account;

use App\Events\CheckoutAccepted;
use App\Events\CheckoutDeclined;
use App\Events\ItemAccepted;
use App\Events\ItemDeclined;
use App\Http\Controllers\Controller;
use App\Models\CheckoutAcceptance;
use App\Models\Company;
use App\Models\Contracts\Acceptable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AcceptanceController extends Controller {
	
    /**
     * Show a listing of pending checkout acceptances for the current user
     * 
     * @return View
     */
    public function index() {
        $acceptances = CheckoutAcceptance::forUser(Auth::user())->pending()->get();

        return view('account/accept.index', compact('acceptances'));
    }

    /**
     * Shows a form to either accept or decline the checkout acceptance
     * 
     * @param  int  $id
     * @return mixed
     */
	public function create($id) {

        $acceptance = CheckoutAcceptance::find($id);

        if (is_null($acceptance)) {
            return redirect()->route('account.accept')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        if (! $acceptance->isPending()) {
            return redirect()->route('account.accept')->with('error', trans('admin/users/message.error.asset_already_accepted'));
        }        

        if (! $acceptance->isCheckedOutTo(Auth::user())) {
            return redirect()->route('account.accept')->with('error', trans('admin/users/message.error.incorrect_user_accepted'));
        }

        if (!Company::isCurrentUserHasAccess($acceptance->checkoutable)) {
            return redirect()->route('account.accept')->with('error', trans('general.insufficient_permissions'));
        }        

        return view('account/accept.create', compact('acceptance'));
	}

    /**
     * Stores the accept/decline of the checkout acceptance
     * 
     * @param  Request $request
     * @param  int  $id
     * @return Redirect
     */
    public function store(Request $request, $id) {
        
        $acceptance = CheckoutAcceptance::find($id);

        if (is_null($acceptance)) {
            return redirect()->route('account.accept')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        if (! $acceptance->isPending()) {
            return redirect()->route('account.accept')->with('error', trans('admin/users/message.error.asset_already_accepted'));
        }        

        if (! $acceptance->isCheckedOutTo(Auth::user())) {
            return redirect()->route('account.accept')->with('error', trans('admin/users/message.error.incorrect_user_accepted'));
        }

        if (!Company::isCurrentUserHasAccess($acceptance->checkoutable)) {
            return redirect()->route('account.accept')->with('error', trans('general.insufficient_permissions'));
        }   

        if (!$request->filled('asset_acceptance')) {
            return redirect()->back()->with('error', trans('admin/users/message.error.accept_or_decline'));
        }

        /**
         * Get the signature and save it
         */

        if (!Storage::exists('private_uploads/signatures'))  Storage::makeDirectory('private_uploads/signatures', 775);


        $sig_filename = '';
        if ($request->filled('signature_output')) {
            $sig_filename = "siglog-" .Str::uuid() . '-'.date('Y-m-d-his').".png";
            $data_uri = e($request->input('signature_output'));
            $encoded_image = explode(",", $data_uri);
            $decoded_image = base64_decode($encoded_image[1]);
            Storage::put('private_uploads/signatures/'.$sig_filename, (string)$decoded_image);
        }


        if ($request->input('asset_acceptance') == 'accepted') {

            $acceptance->accept($sig_filename);

            event(new CheckoutAccepted($acceptance));

            $return_msg = trans('admin/users/message.accepted');

        } else {

            $acceptance->decline($sig_filename);         

            event(new CheckoutDeclined($acceptance));

            $return_msg = trans('admin/users/message.declined');

        }

        return redirect()->to('account/accept')->with('success', $return_msg);
    }	
}
