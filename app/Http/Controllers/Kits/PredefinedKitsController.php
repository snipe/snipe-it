<?php
namespace App\Http\Controllers;

use App\Models\PredefinedKit;
use App\Models\AssetModel;
use App\Models\PredefinedModel;
use App\Models\License;
use App\Models\PredefinedLicence;
use Illuminate\Support\Facades\DB;


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
        //$this->authorize('create', PredefinedKit::class);

        return view('kits/edit')->with('item', new PredefinedKit);
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
        //$this->authorize('create', AssetModel::class);
        // Create a new Predefined Kit
        $kit = new PredefinedKit;

        // Save the model data
        $kit->name                = $request->input('name');

        if(!$kit->save()) {
            return redirect()->back()->withInput()->withErrors($kit->getErrors());
        }

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
        return redirect()->route("models.index")->with('success', 'Kit was successfully created.'); // TODO: trans()
    }

    /**
    * Returns a view containing the Predefined Kit edit form.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $kitId
    * @return View
    */
    public function edit($kitId = null)
    {
        $this->authorize('update', PredefinedKit::class);
        if ($kit = PredefinedKit::find($kitId)) {
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
    * @param int $kitId
    * @return Redirect
    */
    public function update(ImageUploadRequest $request, $kitId = null)
    {
        $this->authorize('update', PredefinedKit::class);
        // Check if the kit exists
        if (is_null($kit = PredefinedKit::find($kitId))) {
            // Redirect to the kits management page
            return redirect()->route('kits.index')->with('error','Kit does not exist');      // TODO: trans
        }

        $kit->name                = $request->input('name');

        // update models
        $new_model_ids = $request->input('models');
        $old_model_ids = $kit->models()->pluck('id');      // METODO: проверить
        // для получения ид надо что-то такое https://stackoverflow.com/questions/34308169/eloquent-orm-laravel-5-get-array-of-ids
        // project built on Laravel 5.4
        list($add_model_ids, $remove_model_ids) = $this->getAddingDeletingElements($new_model_ids, $old_model_ids);     // METODO: тут ошибка, надо именно ид-шки получать, а не сами модели

        $new_licence_ids = $request->input('licences');
        $old_licence_ids = $kit->licences()->pluck('id');      // METODO: проверить
        list($add_licence_ids, $remove_licence_ids) = $this->getAddingDeletingElements($new_licence_ids, $old_licence_ids);

        $success = DB::transaction(function() use($kit, $add_models, $remove_models, $add_licences, $remove_licences) {
            $kit->models()->detach($remove_models);
            $kit->models()->attach($add_models);
            $kit->licenses()->detach($remove_licenses);
            $kit->licenses()->attach($add_licenses);
            return $kit->save();
        });

        if ($success) {
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
    * @param int $kitId
    * @return Redirect
    */
    public function destroy($kitId)
    {
        $this->authorize('delete', PredefinedKit::class);
        // Check if the kit exists
        if (is_null($kit = PredefinedKit::find($kitId))) {
            return redirect()->route('kits.index')->with('error', 'Kit not found');     // TODO: trans
        }

        // Delete childs
        $kit->models()->delete();
        $kit->licenses()->delete();
        // Delete the kit
        $kit->delete();

        // Redirect to the kit management page
        return redirect()->route('kits.index')->with('success', 'Kit was successfully deleted'); // TODO: trans
    }

    /**
    * Get the model information to present to the model view page
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $modelId
    * @return View
    */
    public function show($modelId = null)
    {
        $this->authorize('view', AssetModel::class);
        $model = AssetModel::withTrashed()->find($modelId);

        if (isset($model->id)) {
            return view('models/view', compact('model'));
        }
        // Prepare the error message
        $error = trans('admin/models/message.does_not_exist', compact('id'));

        // Redirect to the user management page
        return redirect()->route('models.index')->with('error', $error);
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
     * Adds default values to a model (as long as they are truthy)
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
