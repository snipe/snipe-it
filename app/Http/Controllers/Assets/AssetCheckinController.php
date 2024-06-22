<?php

namespace App\Http\Controllers\Assets;

use App\Events\CheckoutableCheckedIn;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssetCheckinRequest;
use App\Http\Traits\DocumentGeneratorTrait;
use App\Models\Asset;
use Illuminate\Support\Facades\DB;
use App\Models\CheckoutAcceptance;
use App\Models\LicenseSeat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class AssetCheckinController extends Controller
{

    use DocumentGeneratorTrait;

    /**
     * Returns a view that presents a form to check an asset back into inventory.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $assetId
     * @param string $backto
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @since [v1.0]
     */
    public function create($assetId, $backto = null)
    {
        // Check if the asset exists
        if (is_null($asset = Asset::find($assetId))) {
            // Redirect to the asset management page with error
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        $this->authorize('checkin', $asset);

        // This asset is already checked in, redirect
        
        if (is_null($asset->assignedTo)) {
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.checkin.already_checked_in'));
        }

        if (!$asset->model) {
            return redirect()->route('hardware.show', $asset->id)->with('error', trans('admin/hardware/general.model_invalid_fix'));
        }

        return view('hardware/checkin', compact('asset'))->with('statusLabel_list', Helper::statusLabelList())->with('backto', $backto)->with('table_name', 'Assets');
    }

    /**
     * Validate and process the form data to check an asset back into inventory.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param AssetCheckinRequest $request
     * @param int $assetId
     * @param null $backto
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @since [v1.0]
     */
    public function store(AssetCheckinRequest $request, $assetId = null, $backto = null)
    {
        // Check if the asset exists
        if (is_null($asset = Asset::find($assetId))) {
            // Redirect to the asset management page with error
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
        }

        if (is_null($target = $asset->assignedTo)) {
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.checkin.already_checked_in'));
        }

        if (!$asset->model) {
            return redirect()->route('hardware.show', $asset->id)->with('error', trans('admin/hardware/general.model_invalid_fix'));
        }

        $this->authorize('checkin', $asset);

        if ($asset->assignedType() == Asset::USER) {
            $user = $asset->assignedTo;
        }

        $asset->expected_checkin = null;
        //$asset->last_checkout = null;
        $asset->last_checkin = now();
        $asset->assignedTo()->disassociate($asset);
        $asset->accepted = null;
        $asset->name = $request->get('name');

        if ($request->filled('status_id')) {
            $asset->status_id = e($request->get('status_id'));
        }

        // This is just meant to correct legacy issues where some user data would have 0
        // as a location ID, which isn't valid. Later versions of Snipe-IT have stricter validation
        // rules, so it's necessary to fix this for long-time users. It's kinda gross, but will help
        // people (and their data) in the long run

        if ($asset->rtd_location_id == '0') {
            \Log::debug('Manually override the RTD location IDs');
            \Log::debug('Original RTD Location ID: '.$asset->rtd_location_id);
            $asset->rtd_location_id = '';
            \Log::debug('New RTD Location ID: '.$asset->rtd_location_id);
        }

        if ($asset->location_id == '0') {
            \Log::debug('Manually override the location IDs');
            \Log::debug('Original Location ID: '.$asset->location_id);
            $asset->location_id = '';
            \Log::debug('New RTD Location ID: '.$asset->location_id);
        }

        $asset->location_id = $asset->rtd_location_id;

        if ($request->filled('location_id')) {
            \Log::debug('NEW Location ID: '.$request->get('location_id'));
            $asset->location_id = e($request->get('location_id'));
        }

        $checkin_at = date('Y-m-d H:i:s');
        if (($request->filled('checkin_at')) && ($request->get('checkin_at') != date('Y-m-d'))) {
            $checkin_at = $request->get('checkin_at');
        }

        if(!empty($asset->licenseseats->all())){
            foreach ($asset->licenseseats as $seat){
                $seat->assigned_to = null;
                $seat->save();
            }
        }

        // Get all pending Acceptances for this asset and delete them
        $acceptances = CheckoutAcceptance::pending()->whereHasMorph('checkoutable',
            [Asset::class],
            function (Builder $query) use ($asset) {
                $query->where('id', $asset->id);
            })->get();
        $acceptances->map(function($acceptance) {
            $acceptance->delete();
        });

        // generate file
        $asset_ids = [$asset->id];
        $file_name = $this->generate_checkout_checkin($asset_ids,$target,$checkin_at,'Reversement');
        Session::flash('downloadfile', $file_name);

        # add responsable name and matricule in note
        $note = $request->get("responsable") . " - " . $request->get('responsable_matricule').' ('.$request->get('note').' )';


            if ($asset->save()) {
                $note = $request->get("responsable") . " - " . $request->get('responsable_matricule').' ('.$request->note[$key].' )';
                event(new CheckoutableCheckedIn($asset, $target, Auth::user(), e($note), $checkin_at));

            }

        }
        // end modify assets

        // start generate file
        
        $file_name = $this->generate_checkout_checkin($request->assets_id,$target,$checkin_at,'Reversement');
        Session::flash('downloadfile', $file_name);

        return redirect()->route('hardware.index')->with('success', trans('admin/hardware/message.checkin.success'));
    }

    /**
     * Validate and process the form data to replace multiple assets back into inventory.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param AssetCheckinRequest $request
     * @return Redirect
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @since [v1.0]
     */
    public function bulkreplace(AssetCheckinRequest $request)
    {   
        //dd($request);
        // test if same number of assets
        if(count($request->selected_assets)!=count($request->assets_id)){
            return redirect()->back()->with('error', "please select assets to replace with");
        }

        // test if selected_asset (remplacer par) are unique
        $unique = count(array_unique($request->selected_assets));
        if($unique!=count($request->selected_assets)){
            return redirect()->back()->with('error', "please select differents assets to replace with");
        }

        
        // test if each asset have the same model as the remplaced by asset
        foreach($request->assets_id as $key => $oldasset){
            
            $oldmodel = Asset::find($oldasset)->model_id;
            
            $newmodel = Asset::find($request->selected_assets[$key])->model_id;
            
            if($oldmodel!=$newmodel){
                return redirect()->route('hardware.index')->with('error', "please select assets with same model");
            }
        }

        // test if we can checkin foreach asset
        foreach($request->assets_id as $assetId){
            // Check if the asset exists
            if (is_null($asset = Asset::find($assetId))) {
                // Redirect to the asset management page with error
                return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
            }

            if (is_null($target = $asset->assignedTo)) {
                return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.checkin.already_checked_in'));
            }
            $this->authorize('checkin', $asset);
        }

        // test if we can checkout foreach asset
        $this->authorize('checkout', Asset::class);
        if (! is_array($request->get('selected_assets'))) {
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.checkout.no_assets_selected'));
        }

        // start to checkin each asset
        foreach($request->assets_id as $key => $assetId){
            $asset = Asset::find($assetId);
            if ($asset->assignedType() == Asset::USER) {
                $user = $asset->assignedTo;
            }
    
            $asset->expected_checkin = null;
            $asset->last_checkout = null;
            $asset->assigned_to = null;
            $asset->assignedTo()->disassociate($asset);
            $asset->assigned_type = null;
            $asset->accepted = null;
            $asset->name = $request->get('name');
    
            if ($request->filled('status_id')) {
                if($request->status_id[$key] != null){
                    $asset->status_id = $request->status_id[$key];
                }                
            }
    
            // This is just meant to correct legacy issues where some user data would have 0
            // as a location ID, which isn't valid. Later versions of Snipe-IT have stricter validation
            // rules, so it's necessary to fix this for long-time users. It's kinda gross, but will help
            // people (and their data) in the long run
    
            if ($asset->rtd_location_id == '0') {
                \Log::debug('Manually override the RTD location IDs');
                \Log::debug('Original RTD Location ID: '.$asset->rtd_location_id);
                $asset->rtd_location_id = '';
                \Log::debug('New RTD Location ID: '.$asset->rtd_location_id);
            }
    
            if ($asset->location_id == '0') {
                \Log::debug('Manually override the location IDs');
                \Log::debug('Original Location ID: '.$asset->location_id);
                $asset->location_id = '';
                \Log::debug('New RTD Location ID: '.$asset->location_id);
            }
    
            $asset->location_id = $asset->rtd_location_id;
    
            if ($request->filled('location_id')) {
                \Log::debug('NEW Location ID: '.$request->get('location_id'));
                $asset->location_id = e($request->get('location_id'));
            }
    
            $checkin_at = date('Y-m-d H:i:s');
            if (($request->filled('checkin_at')) && ($request->get('checkin_at') != date('Y-m-d'))) {
                $checkin_at = $request->get('checkin_at');
            }
    
            if(!empty($asset->licenseseats->all())){
                foreach ($asset->licenseseats as $seat){
                    $seat->assigned_to = null;
                    $seat->save();
                }
            }
    
            // Get all pending Acceptances for this asset and delete them
            $acceptances = CheckoutAcceptance::pending()->whereHasMorph('checkoutable',
                [Asset::class],
                function (Builder $query) use ($asset) {
                    $query->where('id', $asset->id);
                })->get();
            $acceptances->map(function($acceptance) {
                $acceptance->delete();
            });

            if ($asset->save()) {
                $note = $request->get("responsable") . " - " . $request->get('responsable_matricule').' ('.$request->note[$key].' )'. " - remplacer par " . Asset::find($request->selected_assets[$key])->serial;
                event(new CheckoutableCheckedIn($asset, $target, Auth::user(), e($note), $checkin_at));

            }

        }

        // start to checkout each asset

        $admin = Auth::user();
        //$target = $this->determineCheckoutTarget();

        $asset_ids = array_filter($request->get('selected_assets'));

        $checkout_at = date('Y-m-d H:i:s');
        if (($request->filled('checkin_at')) && ($request->get('checkin_at') != date('Y-m-d'))) {
            $checkout_at = e($request->get('checkin_at'));
        }

        $expected_checkin = '';
        if ($request->filled('expected_checkin')) {
            $expected_checkin = e($request->get('expected_checkin'));
        }

        $errors = []; 
        DB::transaction(function () use ($target, $admin, $checkout_at, $expected_checkin, $errors, $asset_ids, $request) {
                
                foreach ($asset_ids as $key => $asset_id) {
                    $asset = Asset::findOrFail($asset_id);
                    $this->authorize('checkout', $asset);
                    $note = $request->get("responsable") . " - " . $request->get('responsable_matricule').' ('.$request->note[$key].' )'. " - remplacement de " . Asset::find($request->assets_id[$key])->serial;
                    $error = $asset->checkOut($target, $admin, $checkout_at, $expected_checkin, e($note), null);
                    

                    if ($target->id != '') {
                        
                        $asset->location_id = $target->id;
                        $asset->unsetEventDispatcher();
                        $asset->save();
                    }

                    if ($error) {
                        array_merge_recursive($errors, $asset->getErrors()->toArray());
                    }
                }
        });
        // generate file
        $file_name = $this->generate_replace($request->selected_assets,$target,$checkin_at,'Remplacement',$request->assets_id);
        Session::flash('downloadfile', $file_name);

        return redirect()->route('hardware.index')->with('success', trans('admin/hardware/message.checkin.success'));

    }

    /**
     * Validate and process the form data to check multiple assets back into inventory.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param AssetCheckinRequest $request
     * @param int $assetId
     * @param null $backto
     * @return Redirect
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @since [v1.0]
     */
    public function bulkcheckin(AssetCheckinRequest $request)
    {   
        
        // test if we can checkin foreach asset
        foreach($request->assets_id as $assetId){
            // Check if the asset exists
            if (is_null($asset = Asset::find($assetId))) {
                // Redirect to the asset management page with error
                return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
            }

            if (is_null($target = $asset->assignedTo)) {
                return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.checkin.already_checked_in'));
            }
            $this->authorize('checkin', $asset);
        }

        // start to modify each asset
        foreach($request->assets_id as $key => $assetId){
            $asset = Asset::find($assetId);
            if ($asset->assignedType() == Asset::USER) {
                $user = $asset->assignedTo;
            }
    
            $asset->expected_checkin = null;
            $asset->last_checkout = null;
            $asset->assigned_to = null;
            $asset->assignedTo()->disassociate($asset);
            $asset->assigned_type = null;
            $asset->accepted = null;
            $asset->name = $request->get('name');
    
            if ($request->filled('status_id')) {
                if($request->status_id[$key] != null){
                    $asset->status_id = $request->status_id[$key];
                }                
            }
    
            // This is just meant to correct legacy issues where some user data would have 0
            // as a location ID, which isn't valid. Later versions of Snipe-IT have stricter validation
            // rules, so it's necessary to fix this for long-time users. It's kinda gross, but will help
            // people (and their data) in the long run
    
            if ($asset->rtd_location_id == '0') {
                \Log::debug('Manually override the RTD location IDs');
                \Log::debug('Original RTD Location ID: '.$asset->rtd_location_id);
                $asset->rtd_location_id = '';
                \Log::debug('New RTD Location ID: '.$asset->rtd_location_id);
            }
    
            if ($asset->location_id == '0') {
                \Log::debug('Manually override the location IDs');
                \Log::debug('Original Location ID: '.$asset->location_id);
                $asset->location_id = '';
                \Log::debug('New RTD Location ID: '.$asset->location_id);
            }
    
            $asset->location_id = $asset->rtd_location_id;
    
            if ($request->filled('location_id')) {
                \Log::debug('NEW Location ID: '.$request->get('location_id'));
                $asset->location_id = e($request->get('location_id'));
            }
    
            $checkin_at = date('Y-m-d H:i:s');
            if (($request->filled('checkin_at')) && ($request->get('checkin_at') != date('Y-m-d'))) {
                $checkin_at = $request->get('checkin_at');
            }
    
            if(!empty($asset->licenseseats->all())){
                foreach ($asset->licenseseats as $seat){
                    $seat->assigned_to = null;
                    $seat->save();
                }
            }
    
            // Get all pending Acceptances for this asset and delete them
            $acceptances = CheckoutAcceptance::pending()->whereHasMorph('checkoutable',
                [Asset::class],
                function (Builder $query) use ($asset) {
                    $query->where('id', $asset->id);
                })->get();
            $acceptances->map(function($acceptance) {
                $acceptance->delete();
            });

            if ($asset->save()) {
                $note = $request->get("responsable") . " - " . $request->get('responsable_matricule').' ('.$request->note[$key].' )';
                event(new CheckoutableCheckedIn($asset, $target, Auth::user(), e($note), $checkin_at));

            }

        }
        // end modify assets

        // start generate file
        
        $file_name = $this->generate_checkout_checkin($request->assets_id,$target,$checkin_at,'Reversement');
        Session::flash('downloadfile', $file_name);

        return redirect()->route('hardware.index')->with('success', trans('admin/hardware/message.checkin.success'));
    }

    /**
     * Validate and process the form data to replace multiple assets back into inventory.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param AssetCheckinRequest $request
     * @return Redirect
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @since [v1.0]
     */
    public function bulkreplace(AssetCheckinRequest $request)
    {   
        //dd($request);
        // test if same number of assets
        if(count($request->selected_assets)!=count($request->assets_id)){
            return redirect()->back()->with('error', "please select assets to replace with");
        }

        // test if selected_asset (remplacer par) are unique
        $unique = count(array_unique($request->selected_assets));
        if($unique!=count($request->selected_assets)){
            return redirect()->back()->with('error', "please select differents assets to replace with");
        }

        
        // test if each asset have the same model as the remplaced by asset
        foreach($request->assets_id as $key => $oldasset){
            
            $oldmodel = Asset::find($oldasset)->model_id;
            
            $newmodel = Asset::find($request->selected_assets[$key])->model_id;
            
            if($oldmodel!=$newmodel){
                return redirect()->route('hardware.index')->with('error', "please select assets with same model");
            }
        }

        // test if we can checkin foreach asset
        foreach($request->assets_id as $assetId){
            // Check if the asset exists
            if (is_null($asset = Asset::find($assetId))) {
                // Redirect to the asset management page with error
                return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.does_not_exist'));
            }

            if (is_null($target = $asset->assignedTo)) {
                return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.checkin.already_checked_in'));
            }
            $this->authorize('checkin', $asset);
        }

        // test if we can checkout foreach asset
        $this->authorize('checkout', Asset::class);
        if (! is_array($request->get('selected_assets'))) {
            return redirect()->route('hardware.index')->with('error', trans('admin/hardware/message.checkout.no_assets_selected'));
        }

        // start to checkin each asset
        foreach($request->assets_id as $key => $assetId){
            $asset = Asset::find($assetId);
            if ($asset->assignedType() == Asset::USER) {
                $user = $asset->assignedTo;
            }
    
            $asset->expected_checkin = null;
            $asset->last_checkout = null;
            $asset->assigned_to = null;
            $asset->assignedTo()->disassociate($asset);
            $asset->assigned_type = null;
            $asset->accepted = null;
            $asset->name = $request->get('name');
    
            if ($request->filled('status_id')) {
                if($request->status_id[$key] != null){
                    $asset->status_id = $request->status_id[$key];
                }                
            }
    
            // This is just meant to correct legacy issues where some user data would have 0
            // as a location ID, which isn't valid. Later versions of Snipe-IT have stricter validation
            // rules, so it's necessary to fix this for long-time users. It's kinda gross, but will help
            // people (and their data) in the long run
    
            if ($asset->rtd_location_id == '0') {
                \Log::debug('Manually override the RTD location IDs');
                \Log::debug('Original RTD Location ID: '.$asset->rtd_location_id);
                $asset->rtd_location_id = '';
                \Log::debug('New RTD Location ID: '.$asset->rtd_location_id);
            }
    
            if ($asset->location_id == '0') {
                \Log::debug('Manually override the location IDs');
                \Log::debug('Original Location ID: '.$asset->location_id);
                $asset->location_id = '';
                \Log::debug('New RTD Location ID: '.$asset->location_id);
            }
    
            $asset->location_id = $asset->rtd_location_id;
    
            if ($request->filled('location_id')) {
                \Log::debug('NEW Location ID: '.$request->get('location_id'));
                $asset->location_id = e($request->get('location_id'));
            }
    
            $checkin_at = date('Y-m-d H:i:s');
            if (($request->filled('checkin_at')) && ($request->get('checkin_at') != date('Y-m-d'))) {
                $checkin_at = $request->get('checkin_at');
            }
    
            if(!empty($asset->licenseseats->all())){
                foreach ($asset->licenseseats as $seat){
                    $seat->assigned_to = null;
                    $seat->save();
                }
            }
    
            // Get all pending Acceptances for this asset and delete them
            $acceptances = CheckoutAcceptance::pending()->whereHasMorph('checkoutable',
                [Asset::class],
                function (Builder $query) use ($asset) {
                    $query->where('id', $asset->id);
                })->get();
            $acceptances->map(function($acceptance) {
                $acceptance->delete();
            });

            if ($asset->save()) {
                $note = $request->get("responsable") . " - " . $request->get('responsable_matricule').' ('.$request->note[$key].' )'. " - remplacer par " . Asset::find($request->selected_assets[$key])->serial;
                event(new CheckoutableCheckedIn($asset, $target, Auth::user(), e($note), $checkin_at));

            }

        }

        // start to checkout each asset

        $admin = Auth::user();
        //$target = $this->determineCheckoutTarget();

        $asset_ids = array_filter($request->get('selected_assets'));

        $checkout_at = date('Y-m-d H:i:s');
        if (($request->filled('checkin_at')) && ($request->get('checkin_at') != date('Y-m-d'))) {
            $checkout_at = e($request->get('checkin_at'));
        }

        $expected_checkin = '';
        if ($request->filled('expected_checkin')) {
            $expected_checkin = e($request->get('expected_checkin'));
        }

        $errors = []; 
        DB::transaction(function () use ($target, $admin, $checkout_at, $expected_checkin, $errors, $asset_ids, $request) {
                
                foreach ($asset_ids as $key => $asset_id) {
                    $asset = Asset::findOrFail($asset_id);
                    $this->authorize('checkout', $asset);
                    $note = $request->get("responsable") . " - " . $request->get('responsable_matricule').' ('.$request->note[$key].' )'. " - remplacement de " . Asset::find($request->assets_id[$key])->serial;
                    $error = $asset->checkOut($target, $admin, $checkout_at, $expected_checkin, e($note), null);
                    

                    if ($target->id != '') {
                        
                        $asset->location_id = $target->id;
                        $asset->unsetEventDispatcher();
                        $asset->save();
                    }

                    if ($error) {
                        array_merge_recursive($errors, $asset->getErrors()->toArray());
                    }
                }
        });
        // generate file
        $file_name = $this->generate_replace($request->selected_assets,$target,$checkin_at,'Remplacement',$request->assets_id);
        Session::flash('downloadfile', $file_name);

        return redirect()->route('hardware.index')->with('success', trans('admin/hardware/message.checkin.success'));

    }
}
