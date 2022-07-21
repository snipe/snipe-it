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
use App\Models\Setting;
use App\Models\User;
use App\Models\AssetModel;
use App\Models\Accessory;
use App\Models\License;
use App\Models\Component;
use App\Models\Consumable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Http\Controllers\SettingsController;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use phpDocumentor\Reflection\Types\Compound;
use App\Http\Controllers\ReportsController;

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



        $item = $acceptance->checkoutable_type::find($acceptance->checkoutable_id);
        $display_model = '';
        $pdf_view_route = '';
        $pdf_filename = 'accepted-eula-'.date('Y-m-d-h-i-s').'.pdf';
        $sig_filename='';


        if ($request->input('asset_acceptance') == 'accepted') {

            /**
             * Check for the eula-pdfs directory
             */
            if (! Storage::exists('private_uploads/eula-pdfs')) {
                Storage::makeDirectory('private_uploads/eula-pdfs', 775);
            }

            if (Setting::getSettings()->require_accept_signature == '1') {
                
                // Check if the signature directory exists, if not create it
                if (!Storage::exists('private_uploads/signatures')) {
                    Storage::makeDirectory('private_uploads/signatures', 775);
                }

                // The item was accepted, check for a signature
                if ($request->filled('signature_output')) {
                    $sig_filename = 'siglog-' . Str::uuid() . '-' . date('Y-m-d-his') . '.png';
                    $data_uri = $request->input('signature_output');
                    $encoded_image = explode(',', $data_uri);
                    $decoded_image = base64_decode($encoded_image[1]);
                    Storage::put('private_uploads/signatures/' . $sig_filename, (string)$decoded_image);

                    // No image data is present, kick them back.
                    // This mostly only applies to users on super-duper crapola browsers *cough* IE *cough*
                } else {
                    return redirect()->back()->with('error', trans('general.shitty_browser'));
                }
            }


            // this is horrible
            switch($acceptance->checkoutable_type){
                case 'App\Models\Asset':
                        $pdf_view_route ='account.accept.accept-asset-eula';
                        $asset_model = AssetModel::find($item->model_id);
                        $display_model = $asset_model->name;
                        $assigned_to = User::find($acceptance->assigned_to_id)->present()->fullName;
                break;

                case 'App\Models\Accessory':
                        $pdf_view_route ='account.accept.accept-accessory-eula';
                        $accessory = Accessory::find($item->id);
                        $display_model = $accessory->name;
                        $assigned_to = User::find($item->assignedTo);
                break;

                case 'App\Models\LicenseSeat':
                        $pdf_view_route ='account.accept.accept-license-eula';
                        $license = License::find($item->license_id);
                        $display_model = $license->name;
                        $assigned_to = User::find($acceptance->assigned_to_id)->present()->fullName;
                break;

                case 'App\Models\Component':
                        $pdf_view_route ='account.accept.accept-component-eula';
                        $component = Component::find($item->id);
                        $display_model = $component->name;
                        $assigned_to = User::find($acceptance->assigned_to_id)->present()->fullName;
                break;

                case 'App\Models\Consumable':
                        $pdf_view_route ='account.accept.accept-consumable-eula';
                        $consumable = Consumable::find($item->id);
                        $display_model = $consumable->name;
                        $assigned_to = User::find($acceptance->assigned_to_id)->present()->fullName;
                break;
            }

            /**
             * Gather the data for the PDF. We fire this whether there is a signature required or not,
             * since we want the moment-in-time proof of what the EULA was when they accepted it.
             */
            $branding_settings = SettingsController::getPDFBranding();

            if (is_null($branding_settings->logo)){
                $path_logo = "";
            } else {
                $path_logo = public_path() . '/uploads/' . $branding_settings->logo;
            }
            
            $data = [
                'item_tag' => $item->asset_tag,
                'item_model' => $display_model,
                'item_serial' => $item->serial,
                'eula' => $item->getEula(),
                'check_out_date' => Carbon::parse($acceptance->created_at)->format($branding_settings->date_display_format),
                'accepted_date' => Carbon::parse($acceptance->accepted_at)->format($branding_settings->date_display_format),
                'assigned_to' => $assigned_to,
                'company_name' => $branding_settings->site_name,
                'signature' => ($sig_filename) ? storage_path() . '/private_uploads/signatures/' . $sig_filename : null,
                'logo' => $path_logo,
                'date_settings' => $branding_settings->date_display_format,
            ];

            if ($pdf_view_route!='') {
                \Log::debug($pdf_filename.' is the filename, and the route was specified.');
                $pdf = Pdf::loadView($pdf_view_route, $data);
                Storage::put('private_uploads/eula-pdfs/' .$pdf_filename, $pdf->output());
            }

            $acceptance->accept($sig_filename, $item->getEula(), $pdf_filename);
            event(new CheckoutAccepted($acceptance));

            $return_msg = trans('admin/users/message.accepted');

        } else {
            $acceptance->decline($sig_filename);
            event(new CheckoutDeclined($acceptance));
            $return_msg = trans('admin/users/message.declined');
        }


        return redirect()->to('account/accept')->with('success', $return_msg);

    }
    /**
     * returns the checkout Acceptance agreement to a pending state for user to resign the agreement.
     *
     * @param  int  $id
     * @return redirect
     */

    public function resignAcceptance($id){

        $acceptance = CheckoutAcceptance::where('checkoutable_id', $id)
                                        ->where('checkoutable_type','App\Models\Asset')
                                        ->latest('created_at')
                                        ->get()
                                        ->first();


            $acceptance->accepted_at = null;
            $acceptance->declined_at = null;

            $acceptance->save();

            return redirect()->to('/hardware')->with('success', trans('admin/users/general.resend_eula'));
    }
    /**
     * Finds the latest checkout of the asset and emails the user again to sign the EULA.
     *
     * @param  int  $id
     * @return redirect
     */
    public function remindToSignEula($id){
        $acceptance = CheckoutAcceptance::where('checkoutable_id', $id)
            ->where('checkoutable_type','App\Models\Asset')
            ->latest('created_at')
            ->get()
            ->first();


        if( ( !$acceptance->accepted_at== null || !$acceptance->declined_at==null)){
            return redirect()->to('/hardware')->with('error', trans('admin/users/general.eula_acceptance_status'));
        }
        $reminder= new ReportsController();
        $reminder->sentAssetAcceptanceReminder($acceptance->id);

        return redirect()->to('/hardware')->with('success', trans('admin/users/general.remind_eula'));
    }

}