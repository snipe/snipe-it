<?php
namespace App\Http\Controllers\Kits;

use App\Models\PredefinedKit;
use App\Models\AssetModel;
use App\Models\PredefinedModel;
use App\Models\License;
use App\Models\PredefinedLicence;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\ImageUploadRequest;
use App\Models\Accessory;
use App\Models\SnipeItPivot;
use Illuminate\Http\Request;


/**
 * This controller handles all access kits management:
 * list, add/remove/change
 *
 * @version    v2.0
 */
class PredefinedKitsController extends Controller
{
    public function index()
    {
        //$this->authorize('index', PredefinedKit::class);
        return view('kits/index');
    }

    /**
     *  Returns a form view to create a new asset maintenance.
     *
     * @see AssetMaintenancesController::postCreate() method that stores the data
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     * @since [v1.8]
     * @return mixed
     */
    public function create()
    {
        $this->authorize('create', PredefinedKit::class);
        return view('kits/create')->with('item', new PredefinedKit);
    }

    /**
    * Validate and process the new Predefined Kit data.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return Redirect
    */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', PredefinedKit::class);
        // Create a new Predefined Kit
        $kit = new PredefinedKit;
        $kit->name                = $request->input('name');

        if(!$kit->save()) {
            return redirect()->back()->withInput()->withErrors($kit->getErrors());
        }
        // METODO: удалить
        $model_ids = $request->input('models');
        if (!is_array($model_ids)) {
            $model_ids = [];
        }
        $model_ids = array_filter($model_ids);
        
        $license_ids = $request->get('selected_licenses');
        if (!is_array($license_ids)) {
            $license_ids = [];
        }
        $license_ids = array_filter($license_ids);
        
        $success = DB::transaction(function() use($kit, $model_ids, $license_ids) {
            $ret = $kit->save();
            if($ret) {
                $kit->models()->attach($model_ids);             // MYTODO: проверить, что работает перед сохранением
                $kit->licenses()->attach($license_ids);
            }
            return $ret;
        });
        
        if(!$success) {
            return redirect()->back()->withInput()->withErrors($kit->getErrors());
        }
        return redirect()->route("kits.index")->with('success', 'Kit was successfully created.'); // TODO: trans()
    }

    /**
    * Returns a view containing the Predefined Kit edit form.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $kit_id
    * @return View
    */
    public function edit($kit_id = null)
    {
        $this->authorize('update', PredefinedKit::class);
        if ($kit = PredefinedKit::find($kit_id)) {
            return view('kits/edit')
            ->with('item', $kit)
            ->with('models', $kit->models)
            ->with('licenses', $kit->licenses);
        }
        return redirect()->route('kits.index')->with('error', 'Kit does not exist');        // TODO: trans
    }


    /**
    * Validates and processes form data from the edit
    * Predefined Kit form based on the kit ID passed.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $kit_id
    * @return Redirect
    */
    public function update(ImageUploadRequest $request, $kit_id = null)
    {
        $this->authorize('update', PredefinedKit::class);
        // Check if the kit exists
        if (is_null($kit = PredefinedKit::find($kit_id))) {
            // Redirect to the kits management page
            return redirect()->route('kits.index')->with('error','Kit does not exist');      // TODO: trans
        }

        $kit->name                = $request->input('name');
        
        if ($kit->save()) {
            return redirect()->route("kits.index")->with('success', 'Kit was successfully updated');        // TODO: trans
        }
        return redirect()->back()->withInput()->withErrors($kit->getErrors());
    }

    /**
    * Validate and delete the given Predefined Kit.
    * Also delete all contained helping items
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $kit_id
    * @return Redirect
    */
    public function destroy($kit_id)
    {
        $this->authorize('delete', PredefinedKit::class);
        // Check if the kit exists
        if (is_null($kit = PredefinedKit::find($kit_id))) {
            return redirect()->route('kits.index')->with('error', 'Kit not found');     // TODO: trans
        }

        // Delete childs
        $kit->models()->detach();
        $kit->licenses()->detach();
        $kit->consumables()->detach();
        $kit->accessories()->detach();
        // Delete the kit
        $kit->delete();

        // Redirect to the kit management page
        return redirect()->route('kits.index')->with('success', 'Kit was successfully deleted'); // TODO: trans
    }

    /**
    * Get the kit information to present to the kit view page
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $modelId
    * @return View
    */
    public function show($kit_id = null)
    {
        $this->authorize('view', PredefinedKit::class);
        $kit = PredefinedKit::find($kit_id);

        if (isset($kit->id)) {
            return view('kits/view', compact('kit'));
        }
        // Prepare the error message
        $error = 'Kit does not exist.';         // TODO: trans

        // Redirect to the user management page
        return redirect()->route('kits.index')->with('error', $error);
    }

    
    /**
    * Returns a view containing the Predefined Kit edit form.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $kit_id
    * @return View
    */
    public function editModel($kit_id, $model_id)
    {   
        $this->authorize('update', PredefinedKit::class);
        if (    ($kit = PredefinedKit::find($kit_id)) 
        &&      ($model = $kit->models()->find($model_id)) ) {
            // $item = $model->pivot;
            // $item->name1 = 'tesn1';
            // dd($item);
       //dd($model->pivot);
    //    $item = $model->pivot;
       
            return view('kits/model-edit', [
                'kit' => $kit,
                'model' => $model,
                'item' => $model->pivot
            ]);
        }
        return redirect()->route('kits.index')->with('error', 'Kit does not exist');        // TODO: trans
    }

    /**
    * Get the kit information to present to the kit view page
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $modelId
    * @return View
    */
    public function updateModel(Request $request, $kit_id, $model_id) {

        $this->authorize('update', PredefinedKit::class);
        if (is_null($kit = PredefinedKit::find($kit_id))) {
            // Redirect to the kits management page
            return redirect()->route('kits.index')->with('error','Kit does not exist');      // TODO: trans
        }

        $validator = \Validator::make($request->all(), $kit->makeModelRules($model_id));

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $pivot = $kit->models()->wherePivot('id', $request->input('pivot_id'))->first()->pivot;

        $pivot->model_id = $request->input('model_id');
        $pivot->quantity = $request->input('quantity');
        $pivot->save();
        
        return redirect()->route('kits.edit', $kit_id)->with('success', 'Model updated successfully.');     // TODO: trans
    }

    /**
    * Remove the model from set
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $modelId
    * @return View
    */
    public function detachModel($kit_id, $model_id) {
        $this->authorize('update', PredefinedKit::class);
        if (is_null($kit = PredefinedKit::find($kit_id))) {
            // Redirect to the kits management page
            return redirect()->route('kits.index')->with('error','Kit does not exist');      // TODO: trans
        }

        // Delete childs
        $kit->models()->detach($model_id);
        
        // Redirect to the kit management page
        return redirect()->route('kits.edit', $kit_id)->with('success', 'Model was successfully detached'); // TODO: trans
    }

    /**
    * Returns a view containing attached license edit form.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $kit_id
    * @param int $licenseId
    * @return View
    */
    public function editLicense($kit_id, $license_id)
    {   
        $this->authorize('update', PredefinedKit::class);
        if( !($kit = PredefinedKit::find($kit_id)) ) {
            return redirect()->route('kits.index')->with('error', 'Kit does not exist');        // TODO: trans
        }
        if( !($license = $kit->licenses()->find($license_id)) ) {
            return redirect()->route('kits.index')->with('error', 'License does not exist');        // TODO: trans
        }
         
        return view('kits/license-edit', [
            'kit' => $kit,
            'license' => $license,
            'item' => $license->pivot
        ]);
    }

    /**
    * Update attached licese
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $kit_id
    * @param int $licenseId
    * @return View
    */
    public function updateLicense(Request $request, $kit_id, $license_id) {

        $this->authorize('update', PredefinedKit::class);
        if (is_null($kit = PredefinedKit::find($kit_id))) {
            // Redirect to the kits management page
            return redirect()->route('kits.index')->with('error','Kit does not exist');      // TODO: trans
        }

        $validator = \Validator::make($request->all(), $kit->makeLicenseRules($license_id));

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $pivot = $kit->licenses()->wherePivot('id', $request->input('pivot_id'))->first()->pivot;

        $pivot->license_id = $request->input('license_id');
        $pivot->quantity = $request->input('quantity');
        $pivot->save();
        
        return redirect()->route('kits.edit', $kit_id)->with('success', 'License updated successfully.');     // TODO: trans
    }

    /**
    * 
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $licenseId
    * @return View
    */
    public function detachLicense($kit_id, $license_id) {
        $this->authorize('update', PredefinedKit::class);
        if (is_null($kit = PredefinedKit::find($kit_id))) {
            // Redirect to the kits management page
            return redirect()->route('kits.index')->with('error','Kit does not exist');      // TODO: trans
        }

        // Delete childs
        $kit->licenses()->detach($license_id);
        
        // Redirect to the kit management page
        return redirect()->route('kits.edit', $kit_id)->with('success', 'License was successfully detached'); // TODO: trans
    }

    
    /**
    * Returns a view containing attached accessory edit form.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $kit_id
    * @param int $accessoryId
    * @return View
    */
    public function editAccessory($kit_id, $accessory_id)
    {   
        $this->authorize('update', PredefinedKit::class);
        if( !($kit = PredefinedKit::find($kit_id)) ) {
            return redirect()->route('kits.index')->with('error', 'Kit does not exist');        // TODO: trans
        }
        if( !($accessory = $kit->accessories()->find($accessory_id)) ) {
            return redirect()->route('kits.index')->with('error', 'Accessory does not exist');        // TODO: trans
        }
         
        return view('kits/accessory-edit', [
            'kit' => $kit,
            'accessory' => $accessory,
            'item' => $accessory->pivot
        ]);
    }

    /**
    * Update attached accessory
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $kit_id
    * @param int $accessoryId
    * @return View
    */
    public function updateAccessory(Request $request, $kit_id, $accessory_id) {

        $this->authorize('update', PredefinedKit::class);
        if (is_null($kit = PredefinedKit::find($kit_id))) {
            // Redirect to the kits management page
            return redirect()->route('kits.index')->with('error','Kit does not exist');      // TODO: trans
        }

        $validator = \Validator::make($request->all(), $kit->makeAccessoryRules($accessory_id));

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $pivot = $kit->accessories()->wherePivot('id', $request->input('pivot_id'))->first()->pivot;

        $pivot->accessory_id = $request->input('accessory_id');
        $pivot->quantity = $request->input('quantity');
        $pivot->save();
        
        return redirect()->route('kits.edit', $kit_id)->with('success', 'Accessory updated successfully.');     // TODO: trans
    }

    /**
    * 
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $accessoryId
    * @return View
    */
    public function detachAccessory($kit_id, $accessory_id) {
        $this->authorize('update', PredefinedKit::class);
        if (is_null($kit = PredefinedKit::find($kit_id))) {
            // Redirect to the kits management page
            return redirect()->route('kits.index')->with('error','Kit does not exist');      // TODO: trans
        }

        // Delete childs
        $kit->accessories()->detach($accessory_id);
        
        // Redirect to the kit management page
        return redirect()->route('kits.edit', $kit_id)->with('success', 'Accessory was successfully detached'); // TODO: trans
    }

    /**
    * Returns a view containing attached consumable edit form.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $kit_id
    * @param int $consumableId
    * @return View
    */
    public function editConsumable($kit_id, $consumable_id)
    {   
        $this->authorize('update', PredefinedKit::class);
        if( !($kit = PredefinedKit::find($kit_id)) ) {
            return redirect()->route('kits.index')->with('error', 'Kit does not exist');        // TODO: trans
        }
        if( !($consumable = $kit->consumables()->find($consumable_id)) ) {
            return redirect()->route('kits.index')->with('error', 'Consumable does not exist');        // TODO: trans
        }
         
        return view('kits/consumable-edit', [
            'kit' => $kit,
            'consumable' => $consumable,
            'item' => $consumable->pivot
        ]);
    }

    /**
    * Update attached consumable
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $kit_id
    * @param int $consumableId
    * @return View
    */
    public function updateConsumable(Request $request, $kit_id, $consumable_id) {

        $this->authorize('update', PredefinedKit::class);
        if (is_null($kit = PredefinedKit::find($kit_id))) {
            // Redirect to the kits management page
            return redirect()->route('kits.index')->with('error','Kit does not exist');      // TODO: trans
        }

        $validator = \Validator::make($request->all(), $kit->makeConsumableRules($consumable_id));

        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $pivot = $kit->consumables()->wherePivot('id', $request->input('pivot_id'))->first()->pivot;

        $pivot->consumable_id = $request->input('consumable_id');
        $pivot->quantity = $request->input('quantity');
        $pivot->save();
        
        return redirect()->route('kits.edit', $kit_id)->with('success', 'Consumable updated successfully.');     // TODO: trans
    }

    /**
    * 
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $consumableId
    * @return View
    */
    public function detachConsumable($kit_id, $consumable_id) {
        $this->authorize('update', PredefinedKit::class);
        if (is_null($kit = PredefinedKit::find($kit_id))) {
            // Redirect to the kits management page
            return redirect()->route('kits.index')->with('error','Kit does not exist');      // TODO: trans
        }

        // Delete childs
        $kit->consumables()->detach($consumable_id);
        
        // Redirect to the kit management page
        return redirect()->route('kits.edit', $kit_id)->with('success', 'Consumable was successfully detached'); // TODO: trans
    }

    /**
     * Returns true if a fieldset is set, 'add default values' is ticked and if
     * any default values were entered into the form.
     *
     * @param  array  $input
     * @return boolean
     */
    private function shouldAddDefaultValues(array $input)
    {
        return !empty($input['add_default_values'])
            && !empty($input['default_values'])
            && !empty($input['custom_fieldset']);
    }

    /**
     * Adds default values to a accessory (as long as they are truthy)
     *
     * @param  AssetModel $model
     * @param  array      $defaultValues
     * @return void
     */
    private function assignCustomFieldsDefaultValues(AssetModel $model, array $defaultValues)
    {
        foreach ($defaultValues as $customFieldId => $defaultValue) {
            if ($defaultValue) {
                $model->defaultValues()->attach($customFieldId, ['default_value' => $defaultValue]);
            }
        }
    }

    /**
     * Removes all default values
     *
     * @return void
     */
    private function removeCustomFieldsDefaultValues(AssetModel $model)
    {
        $model->defaultValues()->detach();
    }
}
