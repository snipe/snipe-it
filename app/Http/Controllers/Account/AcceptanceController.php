<?php 
namespace App\Http\Controllers\Account;

use App\Events\ItemAccepted;
use App\Events\ItemDeclined;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Company;
use App\Models\Consumable;
use App\Models\Contracts\Acceptable;
use App\Models\License;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class AcceptanceController extends Controller {
	
    public function index(Request $request) {
        return '';
    }
	public function edit(Request $request, $type, $id) {

        $item = $this->getItemById($type, $id);

        if (is_null($item)) {
            return redirect()->reoute('account.accept')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        if ($item->isAccepted()) {
            return redirect()->route('account.accept')->with('error', trans('admin/users/message.error.asset_already_accepted'));
        }        

        if (! $item->isCheckedOutTo(Auth::user())) {
            return redirect()->route('account.accept')->with('error', trans('admin/users/message.error.incorrect_user_accepted'));
        }

        if (!Company::isCurrentUserHasAccess($item)) {
            return redirect()->route('account.accept')->with('error', trans('general.insufficient_permissions'));
        }        

        return view('account/accept', compact('item'));
	}

    public function update(Request $request, $type, $id) {
        $item = $this->getItemById($type, $id);

        if (is_null($item)) {
            return redirect()->reoute('account.accept')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        if ($item->isAccepted()) {
            return redirect()->route('account.accept')->with('error', trans('admin/users/message.error.asset_already_accepted'));
        }      

        if (! $item->isCheckedOutTo(Auth::user())) {
            return redirect()->route('account.accept')->with('error', trans('admin/users/message.error.incorrect_user_accepted'));
        }

        if (!Company::isCurrentUserHasAccess($item)) {
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

            $item->accept(Auth::user(), $sig_filename);

            event(new ItemAccepted($item, Auth::user(), $sig_filename));

            $return_msg = trans('admin/users/message.accepted');

        } else {

            $item->decline(Auth::user(), $sig_filename);

            event(new ItemDeclined($item, Auth::user(), $sig_filename));

            $return_msg = trans('admin/users/message.declined');

        }

        return redirect()->to('account/accept')->with('success', $return_msg);
    }

    private function getItemById($type, $id) : ? Acceptable {
        switch ($type) {
            case 'asset':
                $item = Asset::findOrFail($id);
                break;
            case 'consumable':
                $item = Consumable::findOrFail($id);
                break;
            case 'license':
                $item = License::findOrFail($id);
                break;                  
            default:
                $item = null;
                break;
        }

        return $item;
    }	
}