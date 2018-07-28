<?php 
namespace App\Http\Controllers\Account;

use App\Events\CheckoutAccepted;
use App\Events\CheckoutDeclined;
use App\Events\ItemAccepted;
use App\Events\ItemDeclined;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\CheckoutAcceptance;
use App\Models\Company;
use App\Models\Consumable;
use App\Models\Contracts\Acceptable;
use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AcceptanceController extends Controller {
	
    public function index(Request $request) {
        $acceptances = CheckoutAcceptance::forUser(Auth::user())->pending()->get();

        return view('account/accept.index', compact('acceptances'));
    }
	public function create(Request $request, $id) {

        $acceptance = CheckoutAcceptance::find($id);

        if (is_null($acceptance)) {
            return redirect()->reoute('account.accept')->with('error', trans('admin/hardware/message.does_not_exist'));
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

    public function store(Request $request, $id) {
        
        $acceptance = CheckoutAcceptance::find($id);

        if (is_null($acceptance)) {
            return redirect()->reoute('account.accept')->with('error', trans('admin/hardware/message.does_not_exist'));
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
        if ($request->filled('signature_output')) {
            $path = config('app.private_uploads').'/signatures';
            $sig_filename = "siglog-" .Str::uuid() . '-'.date('Y-m-d-his').".png";
            $data_uri = e($request->input('signature_output'));
            $encoded_image = explode(",", $data_uri);
            $decoded_image = base64_decode($encoded_image[1]);
            file_put_contents($path."/".$sig_filename, $decoded_image);
        }


        if ($request->input('asset_acceptance') == 'accepted') {

            $acceptance->accepted_at = now();
            $acceptance->signature_filename = $sig_filename;
            $acceptance->save();

            // TODO: Update state for the checkoutable

            event(new CheckoutAccepted($acceptance));

            $return_msg = trans('admin/users/message.accepted');

        } else {

            $acceptance->declined_at = now();
            $acceptance->signature_filename = $sig_filename;
            $acceptance->save();           

            // TODO: Update state for the checkoutable

            event(new CheckoutDeclined($acceptance));

            $return_msg = trans('admin/users/message.declined');

        }

        return redirect()->to('account/accept')->with('success', $return_msg);
    }	
}