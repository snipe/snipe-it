<?php

namespace App\Http\Controllers\Components;

use App\Events\ComponentCheckedOut;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ComponentsController;
use App\Http\Requests\ImageUploadRequest;
use App\Models\Company;
use App\Models\Component;
use App\Models\User;
use App\Helpers\Helper;
use App\Models\Actionlog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use App\Helpers\StorageHelper;

use DB;

/**
 * This class controls all actions related to Components for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class ComponentReplenishController extends Controller
{

    /**
     * Returns a form to create a new component.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see ComponentsController::postCreate() method that stores the data
     * @since [v6W.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create($componentId)
    {
        if (is_null($component = Component::find($componentId))) {
            return redirect()->route('component.index')->with('error', trans('admin/component/message.does_not_exist'));
        }
        $this->authorize('update', $component);

        return view('components/replenish', compact('component'));
    }

   /**
     * Saves the replenish information
     *
     * @author [A. Rahardianto] [<veenone@gmail.com>]
     * @see ComponentReplenishCheckoutController::create() method that returns the form.
     * @since [v6.0.7]
     * @param Request $request
     * @param int $componentId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, $componentId)
    {
        if (is_null($component = Component::find($componentId))) {
            return redirect()->route('component.index')->with('error', trans('admin/component/message.not_found'));
        }

        $request->validate([
            "checkout_qty" => "required|regex:/^[0-9]*$/|gt:0"
          ],[            
            'checkout_qty.gt' =>  trans('admin/component/message.under'),
            'checkout_qty.required' => trans('admin/component/message.required'),
            'checkout_qty.regex' => trans('admin/component/message.numeric'),
          ]);

        $this->authorize('update', $component);

        $admin_user = Auth::user();

        if ($request->hasFile('file')) {
            if (! Storage::exists('private_uploads/components/docs')) {
                Storage::makeDirectory('private_uploads/components/docs', 775);
            }

            $file = $request->file('file');
            $extension =  $request->file('file')->getClientOriginalExtension();
            $file_name = 'component_replenish-'.$component->id.'-'.str_random(8).'-'.str_slug(basename($file->getClientOriginalName(), '.'.$extension)).'.'.$extension;

            if ($extension=='svg') {
                Log::debug('This is an SVG');

                    $sanitizer = new Sanitizer();
                    $dirtySVG = file_get_contents($file->getRealPath());
                    $cleanSVG = $sanitizer->sanitize($dirtySVG);

                    try {
                        Storage::put('private_uploads/componenet/docs/'.$file_name, $cleanSVG);
                    } catch (\Exception $e) {
                        Log::debug('Upload no workie :( ');
                        Log::debug($e);
                    }
            } else {
            Storage::put('private_uploads/components/docs/'.$file_name, file_get_contents($file));
            }
            $component->logUpload($file_name, e($request->get('notes')));
        } 


        // Update the consumable data
        $component->assigned_to = e($request->input('assigned_to'));

        isset($file_name) ? $file_name : $file_name = ''; 

        $component->replenishusers()->attach($component->id, [
            'component_id' => $component->id,            
            'user_id' => $admin_user->id,
            'initial_qty' => $component->qty,            
            'total_replenish' => e($request->input('checkout_qty')),
            'replenish_note' => e($request->input('replenish_note')),
            'order_number'  => e($request->input('order_number')),
            'file' => $file_name
        ]);

        $added_quantity = $component->qty + e($request->input('checkout_qty'));

        // Storing value to database
        event(new ComponentCheckedOut($component, Auth::user(), $component->qty, $request->input('note'), $request->input('checkout_qty')));

        // Updating quantity to consumable
        DB::table('components')
        ->where('id',$component->id)
        ->update(['qty'=> $added_quantity]);

        // Updating activity 
        $logAction = new Actionlog();
        $logAction->item_type = Component::class;
        $logAction->item_id = $component->id;
        $logAction->created_at = date('Y-m-d H:i:s');
        $logAction->user_id = Auth::id();        
        $logAction->logaction('replenish');

        // Redirect to the new consumable page
        return redirect()->route('components.index')->with('success', trans('admin/components/message.checkout.success'));
    }


    /**
     * Check for permissions and display the file.
     *
     * @author [A. Rahardianto] [<veenone@gmail.com>]
     * @param  int $componentId
     * @param  string $file
     * @since [v6.0.7]
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($componentId,$file)
    {
        $docfile = ('private_uploads/components/docs/'.$file);
        Log::debug('file : ' . $docfile);

        if (! Storage::exists($docfile)) {
            return response('File '.$docfile.' not found on server' , 404)
                ->header('Content-Type', 'text/plain');
        }

        return StorageHelper::downloader($docfile);

    }
}
