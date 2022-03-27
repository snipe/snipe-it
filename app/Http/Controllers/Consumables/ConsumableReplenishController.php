<?php

namespace App\Http\Controllers\Consumables;

use App\Events\ConsumableCheckedOut;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ConsumablesController;
use App\Models\Consumable;
use App\Models\User;
use App\Models\Actionlog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Helpers\StorageHelper;

use DB;

class ConsumableReplenishController extends Controller
{
    /**
     * Return a view to replenish a consumable .
     *
     * @author [A. Rahardianto] [<veenone@gmail.com>]
     * @see ConsumableReplenishController::store() method that stores the data.
     * @since [v6.0]
     * @param int $consumableId
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create($consumableId)
    {
        if (is_null($consumable = Consumable::find($consumableId))) {
            return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.does_not_exist'));
        }
        $this->authorize('update', $consumable);

        return view('consumables/replenish', compact('consumable'));
    }

    /**
     * Saves the replenish information
     *
     * @author [A. Rahardianto] [<veenone@gmail.com>]
     * @see ConsumableReplenishCheckoutController::create() method that returns the form.
     * @since [v6.0]
     * @param int $consumableId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, $consumableId)
    {
        if (is_null($consumable = Consumable::find($consumableId))) {
            return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.not_found'));
        }

        $request->validate([
            "totalnum" => "required|regex:/^[0-9]*$/|gt:0"
          ],[            
            'totalnum.gt' =>  trans('admin/consumables/message.under'),
            'totalnum.required' => trans('admin/consumables/message.required'),
            'totalnum.regex' => trans('admin/consumables/message.numeric'),
          ]);

        $this->authorize('update', $consumable);

        $admin_user = Auth::user();

        //upload file

          
        $docfilepath = $request->file('file');
        Log::debug('doc file path: '. $request->input('file'));
        $uploadpath = public_path('uploads/consumables/replenish_doc');
        $formattedfilename = 'consumable_replenish_' . time() . $docfilepath->getClientOriginalName();
        $docfilepath->move($uploadpath, $formattedfilename);

        // Update the consumable data
        $consumable->assigned_to = e($request->input('assigned_to'));

        $consumable->replenishusers()->attach($consumable->id, [
            'consumable_id' => $consumable->id,            
            'user_id' => $admin_user->id,
            'initial_qty' => $consumable->qty,            
            'total_replenish' => e($request->input('totalnum')),
            'replenishnote' => e($request->input('replenishnote')),
            'order_number'  => e($request->input('order_number')),
            'file' => $formattedfilename
        ]);

        $addedquantity = $consumable->qty + e($request->input('totalnum'));
        
        // Storing value to database
        event(new ConsumableCheckedOut($consumable, Auth::user(), $consumable->qty, $request->input('note'), $request->input('totalnum')));

        // Updating quantity to consumable
        DB::table('consumables')
        ->where('id',$consumable->id)
        ->update(['qty'=> $addedquantity]);
        
        // Updating activity 
        $logAction = new Actionlog();
        $logAction->item_type = Consumable::class;
        $logAction->item_id = $consumable->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->user_id = Auth::id();        
        $logAction->logaction('replenish');

        // Redirect to the new consumable page
        return redirect()->route('consumables.index')->with('success', trans('admin/consumables/message.checkout.success'));
    }

    
    /**
     * Check for permissions and display the file.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param  int $assetId
     * @param  int $fileId
     * @since [v1.0]
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($consumableId,$file)
    {
        // if (is_null($consumable = Consumable::find($consumableId))) {
        //     return redirect()->route('consumables.index')->with('error', trans('admin/consumables/message.not_found'));
        // }
        // the asset is valid
        // if (isset($asset->id)) {
            // $this->authorize('view', $asset);

            // if (! $log = Actionlog::find($fileId)) {
            //     return response('No matching record for that asset/file', 500)
            //         ->header('Content-Type', 'text/plain');
            // }

            $docfile = public_path('uploads/consumables/replenish_doc/'.$file);
            // Log::debug('Checking for '.$docfile);
            Log::debug('id : ' . $consumableId);
            Log::debug('file : ' . $file);
            // Log::debug($consumable->replenishusers()->where('consumables_stock.id',$consumableId)->first());
            // Log::debug($consumable->replenishusers()->where('pivot.id',$consumableId)->first());

            // if ($log->action_type == 'audit') {
            //     $file = 'private_uploads/audits/'.$log->filename;
            // }

            if (! file_exists($docfile)) {
                Log::debug($docfile);
                return response('File '. $docfile.' not found on server' . $file . ' lalalala ' , 404)
                    ->header('Content-Type', 'text/plain');
            }

            // if ($download != 'true') {
                // if ($contents = file_get_contents(Storage::url($docfile))) {
                //     return Response::make(Storage::url($docfile)->header('Content-Type', mime_content_type($docfile)));
                // }

                // return JsonResponse::create(['error' => 'Failed validation: '], 500);
            // }

            // return StorageHelper::downloader($docfile);
            return response()->download($docfile);
        // }
        // Prepare the error message
        $error = trans('admin/consumable/message.does_not_exist', ['id' => $consumableId]);

        // Redirect to the hardware management page
        return redirect()->route('consumables.index')->with('error', $error);
    }
}
