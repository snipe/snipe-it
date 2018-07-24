<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;
use App\Models\AssetModel;
use Redirect;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Requests\ImageUploadRequest;

/**
 * This class controls all actions related to asset models for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 * @author [A. Gianotto] [<snipe@snipe.net>]
 */
class AssetModelsController extends Controller
{
    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the accessories listing, which is generated in getDatatable.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        $this->authorize('index', AssetModel::class);
        return view('models/index');
    }

    /**
     * Returns a view containing the asset model creation form.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('create', AssetModel::class);
        return view('models/edit')->with('category_type', 'asset')
            ->with('depreciation_list', Helper::depreciationList())
            ->with('item', new AssetModel);
    }


    /**
     * Validate and process the new Asset Model data.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param ImageUploadRequest $request
     * @return Redirect
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ImageUploadRequest $request)
    {

        $this->authorize('create', AssetModel::class);
        // Create a new asset model
        $model = new AssetModel;

        // Save the model data
        $model->eol = $request->input('eol');
        $model->depreciation_id = $request->input('depreciation_id');
        $model->name                = $request->input('name');
        $model->model_number        = $request->input('model_number');
        $model->manufacturer_id     = $request->input('manufacturer_id');
        $model->category_id         = $request->input('category_id');
        $model->notes               = $request->input('notes');
        $model->user_id             = Auth::id();
        $model->requestable         = Input::has('requestable');

        if ($request->input('custom_fieldset')!='') {
            $model->fieldset_id = e($request->input('custom_fieldset'));
        }

        $model = $request->handleImages($model, app('models_upload_path'));

            // Was it created?
        if ($model->save()) {
            if ($this->shouldAddDefaultValues($request->input())) {
                $this->assignCustomFieldsDefaultValues($model, $request->input('default_values'));
            }

            // Redirect to the new model  page
            return redirect()->route("models.index")->with('success', trans('admin/models/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($model->getErrors());
    }

    /**
     * Returns a view containing the asset model edit form.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param int $modelId
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($modelId = null)
    {
        $this->authorize('update', AssetModel::class);
        if ($item = AssetModel::find($modelId)) {
            $category_type = 'asset';
            $view = View::make('models/edit', compact('item','category_type'));
            $view->with('depreciation_list', Helper::depreciationList());
            return $view;
        }

        return redirect()->route('models.index')->with('error', trans('admin/models/message.does_not_exist'));

    }


    /**
     * Validates and processes form data from the edit
     * Asset Model form based on the model ID passed.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param ImageUploadRequest $request
     * @param int $modelId
     * @return Redirect
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(ImageUploadRequest $request, $modelId = null)
    {
        $this->authorize('update', AssetModel::class);
        // Check if the model exists
        if (is_null($model = AssetModel::find($modelId))) {
            // Redirect to the models management page
            return redirect()->route('models.index')->with('error', trans('admin/models/message.does_not_exist'));
        }

        $model->depreciation_id     = $request->input('depreciation_id');
        $model->eol                 = $request->input('eol');
        $model->name                = $request->input('name');
        $model->model_number        = $request->input('model_number');
        $model->manufacturer_id     = $request->input('manufacturer_id');
        $model->category_id         = $request->input('category_id');
        $model->notes               = $request->input('notes');
        $model->requestable         = $request->input('requestable', '0');

        $this->removeCustomFieldsDefaultValues($model);

        if ($request->input('custom_fieldset')=='') {
            $model->fieldset_id = null;
        } else {
            $model->fieldset_id = $request->input('custom_fieldset');

            if ($this->shouldAddDefaultValues($request->input())) {
                $this->assignCustomFieldsDefaultValues($model, $request->input('default_values'));
            }
        }

        $model = $request->handleImages($model, app('models_upload_path'));

        if ($model->save()) {
            return redirect()->route("models.index")->with('success', trans('admin/models/message.update.success'));
        }
        return redirect()->back()->withInput()->withErrors($model->getErrors());
    }

    /**
     * Validate and delete the given Asset Model. An Asset Model
     * cannot be deleted if there are associated assets.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param int $modelId
     * @return Redirect
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($modelId)
    {
        $this->authorize('delete', AssetModel::class);
        // Check if the model exists
        if (is_null($model = AssetModel::find($modelId))) {
            return redirect()->route('models.index')->with('error', trans('admin/models/message.not_found'));
        }

        if ($model->assets()->count() > 0) {
            // Throw an error that this model is associated with assets
            return redirect()->route('models.index')->with('error', trans('admin/models/message.assoc_users'));
        }

        if ($model->image) {
            try  {
                unlink(public_path().'/uploads/models/'.$model->image);
            } catch (\Exception $e) {
                \Log::error($e);
            }
        }

        // Delete the model
        $model->delete();

        // Redirect to the models management page
        return redirect()->route('models.index')->with('success', trans('admin/models/message.delete.success'));
    }


    /**
     * Restore a given Asset Model (mark as un-deleted)
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param int $modelId
     * @return Redirect
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function getRestore($modelId = null)
    {
        $this->authorize('create', AssetModel::class);
        // Get user information
        $model = AssetModel::withTrashed()->find($modelId);

        if (isset($model->id)) {
            $model->restore();
            return redirect()->route('models.index')->with('success', trans('admin/models/message.restore.success'));
        }
        return redirect()->back()->with('error', trans('admin/models/message.not_found'));

    }


    /**
     * Get the model information to present to the model view page
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.0]
     * @param int $modelId
     * @return View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($modelId = null)
    {
        $this->authorize('view', AssetModel::class);
        $model = AssetModel::withTrashed()->find($modelId);

        if (isset($model->id)) {
            return view('models/view', compact('model'));
        }
        // Redirect to the user management page
        return redirect()->route('models.index')->with('error', trans('admin/models/message.does_not_exist'));
    }

    /**
    * Get the clone page to clone a model
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $modelId
    * @return View
    */
    public function getClone($modelId = null)
    {
        // Check if the model exists
        if (is_null($model_to_clone = AssetModel::find($modelId))) {
            return redirect()->route('models.index')->with('error', trans('admin/models/message.does_not_exist'));
        }

        $model = clone $model_to_clone;
        $model->id = null;

        // Show the page
        return view('models/edit')
            ->with('depreciation_list', Helper::depreciationList())
            ->with('item', $model)
            ->with('clone_model', $model_to_clone);
    }


    /**
    * Get the custom fields form
    *
    * @author [B. Wetherington] [<uberbrady@gmail.com>]
    * @since [v2.0]
    * @param int $modelId
    * @return View
    */
    public function getCustomFields($modelId)
    {
        return view("models.custom_fields_form")->with("model", AssetModel::find($modelId));
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
