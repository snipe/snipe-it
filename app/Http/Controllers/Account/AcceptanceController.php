<?php

namespace App\Http\Controllers\Account;

use App\Events\CheckoutAccepted;
use App\Events\CheckoutDeclined;
use App\Events\ItemAccepted;
use App\Events\ItemDeclined;
use App\Http\Controllers\Controller;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\CheckoutAcceptance;
use App\Models\Company;
use App\Models\Contracts\Acceptable;
use App\Models\User;
use App\Models\AssetModel;
use App\Models\Accessory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\SettingsController;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class AcceptanceController extends Controller
{
    /**
     * Show a listing of pending checkout acceptances for the current user
     *
     * @return View
     */
    public function index()
    {
        $acceptances = CheckoutAcceptance::forUser(Auth::user())->pending()->get();

        return view('account/accept.index', compact('acceptances'));
    }

    /**
     * Shows a form to either accept or decline the checkout acceptance
     *
     * @param  int  $id
     * @return mixed
     */
    public function create($id)
    {
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

        if (! Company::isCurrentUserHasAccess($acceptance->checkoutable)) {
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
    public function store(Request $request, $id)
    {
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

        if (! Company::isCurrentUserHasAccess($acceptance->checkoutable)) {
            return redirect()->route('account.accept')->with('error', trans('general.insufficient_permissions'));
        }

        if (! $request->filled('asset_acceptance')) {
            return redirect()->back()->with('error', trans('admin/users/message.error.accept_or_decline'));
        }

        /**
         * Get the signature and save it
         */
        if (! Storage::exists('private_uploads/signatures')) {
            Storage::makeDirectory('private_uploads/signatures', 775);
        }

        $sig_filename = '';
        if ($request->filled('signature_output')) {
            $sig_filename = 'siglog-'.Str::uuid().'-'.date('Y-m-d-his').'.png';
            $data_uri = e($request->input('signature_output'));
            $encoded_image = explode(',', $data_uri);
            $decoded_image = base64_decode($encoded_image[1]);
            $acceptance->stored_eula_file = 'accepted-eula-'.date('Y-m-d-h-i-s').'.pdf';
            $path = Storage::put('private_uploads/signatures/'.$sig_filename, (string) $decoded_image);
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

        $item = $acceptance->checkoutable_type::find($acceptance->checkoutable_id);

        if ($acceptance->checkoutable_type== 'App\Models\Asset') {
            $assigned_to = User::find($item->assigned_to);
            $asset_model = AssetModel::find($item->model_id);
            $branding_settings = SettingsController::getPDFBranding();
            $data = [
                'item_tag' => $item->asset_tag,
                'item_model' => $asset_model->name,
                'item_serial' => $item->serial,
                'eula' => $item->getEula(),
                'check_out_date' => Carbon::parse($acceptance->created_at)->format($branding_settings->date_display_format),
                'accepted_date' => Carbon::parse($acceptance->accepted_at)->format($branding_settings->date_display_format),
                'assigned_to' => $assigned_to->first_name . ' ' . $assigned_to->last_name,
                'company_name' => $branding_settings->site_name,
                'signature' => storage_path() . '/private_uploads/signatures/' . $sig_filename,
                'logo' => public_path() . '/uploads/' . $branding_settings->logo,
                'date_settings' => $branding_settings->date_display_format,
            ];
            $pdf = Pdf::loadView('account.accept.accept-asset-eula', $data);
            Storage::put('private_uploads/eula-pdfs/' . $acceptance->stored_eula_file, $pdf->output());

            $a = new Actionlog();
            $a->stored_eula = $item->getEula();
            $a->stored_eula_file = $acceptance->stored_eula_file;
            $a->save();

            return redirect()->to('account/accept')->with('success', $return_msg);
        }
//
        $accessory_user= DB::table('checkout_acceptances')->find($acceptance->assigned_to_id);
        $assigned_to = User::find($accessory_user->assigned_to_id);
        $accessory_model = Accessory::find($item->id);
        $branding_settings = SettingsController::getPDFBranding();
        $data = [
            'item_tag' => $item->model_number,
            'item_model' => $accessory_model->name,
            'eula' => $item->getEula(),
            'check_out_date' => Carbon::parse($acceptance->created_at)->format($branding_settings->date_display_format),
            'accepted_date' => Carbon::parse($acceptance->accepted_at)->format($branding_settings->date_display_format),
//          'assigned_by'    => self
            'assigned_to' => $assigned_to->first_name . ' ' . $assigned_to->last_name,
            'company_name' => $branding_settings->site_name,
            'signature' => storage_path() . '/private_uploads/signatures/' . $sig_filename,
            'logo' => public_path() . '/uploads/' . $branding_settings->logo,
            'date_settings' => $branding_settings->date_display_format,
        ];
        $pdf = Pdf::loadView('account.accept.accept-accessory-eula', $data);
        Storage::put('private_uploads/eula-pdfs/' . $acceptance->stored_eula_file, $pdf->output());

        $a = new Actionlog();
        $a->stored_eula = $item->getEula();
        $a->stored_eula_file = $acceptance->stored_eula_file;
        $a->save();

        return redirect()->to('account/accept')->with('success', $return_msg);
    }
}