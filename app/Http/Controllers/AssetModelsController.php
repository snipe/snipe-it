<?php
namespace App\Http\Controllers;

use App\Models\CustomField;
use Image;
use Input;
use Lang;
use App\Models\AssetModel;
use Redirect;
use Auth;
use DB;
use Str;
use Validator;
use View;
use App\Models\Asset;
use App\Models\Company;
use Config;
use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Http\Requests\ImageUploadRequest;

use Symfony\Component\HttpFoundation\JsonResponse;

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
    */
    public function index()
    {
        return view('models/index');
    }

    /**
    * Returns a view containing the asset model creation form.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return View
    */
    public function create()
    {
        $category_type = 'asset';
        return view('models/edit')->with('category_type',$category_type)
        ->with('depreciation_list', Helper::depreciationList())
        ->with('item', new AssetModel);
    }


    /**
    * Validate and process the new Asset Model data.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return Redirect
    */
    public function store(ImageUploadRequest $request)
    {

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

        if (Input::file('image')) {

            $image = Input::file('image');
            $file_name = str_slug($image->getClientOriginalName()) . "." . $image->getClientOriginalExtension();
            $path = app('models_upload_path');

            if ($image->getClientOriginalExtension()!='svg') {
                Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save($path.'/'.$file_name);
            } else {
                $image->move($path, $file_name);
            }
            $model->image = $file_name;

        }

            // Was it created?
        if ($model->save()) {
            // Redirect to the new model  page
            return redirect()->route("models.index")->with('success', trans('admin/models/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($model->getErrors());
    }

    /**
     * Validates and stores new Asset Model data created from the
     * modal form on the Asset Creation view.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v2.0]
     * @param Request $request
     * @return String JSON
     */
    public function apiStore(Request $request)
    {
      //COPYPASTA!!!! FIXME
        $model = new AssetModel;

        $settings=Input::all();
        $settings['eol']= null;

        $model->name=$request->input('name');
        $model->manufacturer_id = $request->input('manufacturer_id');
        $model->category_id = $request->input('category_id');
        $model->model_number = $request->input('model_number');
        $model->user_id = Auth::id();
        $model->notes            = $request->input('notes');
        $model->eol= null;

        if ($request->input('fieldset_id')=='') {
            $model->fieldset_id = null;
        } else {
            $model->fieldset_id = e($request->input('fieldset_id'));
        }

        if ($model->save()) {
            return JsonResponse::create($model);
        } else {
            return JsonResponse::create(["error" => "Failed validation: ".print_r($model->getErrors()->all('<li>:message</li>'), true)], 500);
        }
    }


    /**
    * Returns a view containing the asset model edit form.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $modelId
    * @return View
    */
    public function edit($modelId = null)
    {
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
    * @param int $modelId
    * @return Redirect
    */
    public function update(ImageUploadRequest $request, $modelId = null)
    {
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

        if ($request->input('custom_fieldset')=='') {
            $model->fieldset_id = null;
        } else {
            $model->fieldset_id = $request->input('custom_fieldset');
        }

        $old_image = $model->image;

        // Set the model's image property to null if the image is being deleted
        if ($request->input('image_delete') == 1) {
            $model->image = null;
        }

        if ($request->file('image')) {
            $image = $request->file('image');
            $file_name = $model->id.'-'.str_slug($image->getClientOriginalName()) . "." . $image->getClientOriginalExtension();

            if ($image->getClientOriginalExtension()!='svg') {
                Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(app('models_upload_path').$file_name);
            } else {
                $image->move(app('models_upload_path'), $file_name);
            }
            $model->image = $file_name;

        }

        if ((($request->file('image')) && (isset($old_image)) && ($old_image!='')) || ($request->input('image_delete') == 1)) {
            try  {
                unlink(app('models_upload_path').$old_image);
            } catch (\Exception $e) {
                \Log::error($e);
            }
        }


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
    */
    public function destroy($modelId)
    {
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
    */
    public function getRestore($modelId = null)
    {

        // Get user information
        $model = AssetModel::withTrashed()->find($modelId);

        if (isset($model->id)) {

            // Restore the model
            $model->restore();

            // Prepare the success message
            $success = trans('admin/models/message.restore.success');

            // Redirect back
            return redirect()->route('models.index')->with('success', $success);

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
    */
    public function show($modelId = null)
    {
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
        $view = View::make('models/edit');
        $view->with('category_list', Helper::categoryList('asset'));
        $view->with('depreciation_list', Helper::depreciationList());
        $view->with('manufacturer_list', Helper::manufacturerList());
        $view->with('item', $model);
        $view->with('clone_model', $model_to_clone);
        return $view;

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
        $model = AssetModel::find($modelId);
        return view("models.custom_fields_form")->with("model", $model);
    }




    /**
     * Returns a view that allows the user to bulk edit model attrbutes
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.7]
     * @return \Illuminate\Contracts\View\View
     */
    public function postBulkEdit(Request $request)
    {
        
        $models_raw_array = Input::get('ids');

        if (is_array($models_raw_array)) {
            $models = AssetModel::whereIn('id', $models_raw_array)->get();
            $nochange = ['NC' => 'No Change'];
            $fieldset_list = $nochange + Helper::customFieldsetList();
            $depreciation_list = $nochange + Helper::depreciationList();
            $category_list = $nochange + Helper::categoryList('asset');
            $manufacturer_list = $nochange + Helper::manufacturerList();

        
             return view('models/bulk-edit', compact('models'))
                ->with('manufacturer_list', $manufacturer_list)
                ->with('category_list', $category_list)
                ->with('fieldset_list', $fieldset_list)
                ->with('depreciation_list', $depreciation_list);
        }

        return redirect()->route('models.index')
            ->with('error', 'You must select at least one model to edit.');

    }



    /**
     * Returns a view that allows the user to bulk edit model attrbutes
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v1.7]
     * @return \Illuminate\Contracts\View\View
     */
    public function postBulkEditSave(Request $request)
    {

        $models_raw_array = Input::get('ids');
        $update_array = array();

        if (($request->has('manufacturer_id') && ($request->input('manufacturer_id')!='NC'))) {
            $update_array['manufacturer_id'] = $request->input('manufacturer_id');
        }
        if (($request->has('category_id') && ($request->input('category_id')!='NC'))) {
            $update_array['category_id'] = $request->input('category_id');
        }
        if ($request->input('fieldset_id')!='NC') {
            $update_array['fieldset_id'] = $request->input('fieldset_id');
        }
        if ($request->input('depreciation_id')!='NC') {
            $update_array['depreciation_id'] = $request->input('depreciation_id');
        }


        
        if (count($update_array) > 0) {
            AssetModel::whereIn('id', $models_raw_array)->update($update_array);
            return redirect()->route('models.index')
                ->with('success', trans('admin/models/message.bulkedit.success'));
        }

        return redirect()->route('models.index')
            ->with('warning', trans('admin/models/message.bulkedit.error'));

    }

}
