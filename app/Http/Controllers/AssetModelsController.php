<?php
namespace App\Http\Controllers;

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
    * @see AssetModelsController::getDatatable() method that generates the JSON response
    * @since [v1.0]
    * @return View
    */
    public function getIndex()
    {
        // Show the page
        return View::make('models/index');
    }

    /**
    * Returns a view containing the asset model creation form.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return View
    */
    public function getCreate()
    {
        // Show the page
        $depreciation_list = Helper::depreciationList();
        $manufacturer_list = Helper::manufacturerList();
        $category_list = Helper::categoryList('asset');
        return View::make('models/edit')
        ->with('category_list', $category_list)
        ->with('depreciation_list', $depreciation_list)
        ->with('manufacturer_list', $manufacturer_list)
        ->with('item', new AssetModel);
    }


    /**
    * Validate and process the new Asset Model data.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @return Redirect
    */
    public function postCreate()
    {

        // Create a new asset model
        $model = new AssetModel;


        if (e(Input::get('depreciation_id')) == '') {
            $model->depreciation_id =  0;
        } else {
            $model->depreciation_id = e(Input::get('depreciation_id'));
        }

        if (e(Input::get('eol')) == '') {
            $model->eol =  0;
        } else {
            $model->eol = e(Input::get('eol'));
        }

        // Save the model data
        $model->name                = e(Input::get('name'));
        $model->model_number             = e(Input::get('model_number'));
        $model->manufacturer_id     = e(Input::get('manufacturer_id'));
        $model->category_id         = e(Input::get('category_id'));
        $model->notes               = e(Input::get('notes'));
        $model->user_id             = Auth::user()->id;
        $model->requestable         = Input::has('requestable');

        if (Input::get('custom_fieldset')!='') {
            $model->fieldset_id = e(Input::get('custom_fieldset'));
        }


        if (Input::file('image')) {
            $image = Input::file('image');
            $file_name = str_random(25).".".$image->getClientOriginalExtension();
            $path = public_path('uploads/models/'.$file_name);
            Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path);
            $model->image = $file_name;
        }

            // Was it created?
        if ($model->save()) {
            // Redirect to the new model  page
            return redirect()->to("hardware/models")->with('success', trans('admin/models/message.create.success'));
        }

            return redirect()->back()->withInput()->withErrors($model->getErrors());

    }

    /**
    * Validates and stores new Asset Model data created from the
    * modal form on the Asset Creation view.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v2.0]
    * @return String JSON
    */
    public function store()
    {
      //COPYPASTA!!!! FIXME
        $model = new AssetModel;

        $settings=Input::all();
        $settings['eol']= null;

        $model->name=e(Input::get('name'));
        $model->manufacturer_id = e(Input::get('manufacturer_id'));
        $model->category_id = e(Input::get('category_id'));
        $model->model_number = e(Input::get('model_number'));
        $model->user_id = Auth::user()->id;
        $model->notes            = e(Input::get('notes'));
        $model->eol= null;

        if (Input::get('fieldset_id')=='') {
            $model->fieldset_id = null;
        } else {
            $model->fieldset_id = e(Input::get('fieldset_id'));
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
    public function getEdit($modelId = null)
    {
        // Check if the model exists
        if (is_null($item = AssetModel::find($modelId))) {
            // Redirect to the model management page
            return redirect()->to('assets/models')->with('error', trans('admin/models/message.does_not_exist'));
        }

        $depreciation_list = Helper::depreciationList();
        $manufacturer_list = Helper::manufacturerList();
        $category_list = Helper::categoryList('asset');

        $view = View::make('models/edit', compact('item'));
        $view->with('category_list', $category_list);
        $view->with('depreciation_list', $depreciation_list);
        $view->with('manufacturer_list', $manufacturer_list);
        return $view;
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
    public function postEdit($modelId = null)
    {
        // Check if the model exists
        if (is_null($model = AssetModel::find($modelId))) {
            // Redirect to the models management page
            return redirect()->to('admin/models')->with('error', trans('admin/models/message.does_not_exist'));
        }


        if (e(Input::get('depreciation_id')) == '') {
            $model->depreciation_id =  0;
        } else {
            $model->depreciation_id = e(Input::get('depreciation_id'));
        }

        if (e(Input::get('eol')) == '') {
            $model->eol =  null;
        } else {
            $model->eol = e(Input::get('eol'));
        }
        // Update the model data
        $model->name                = e(Input::get('name'));
        $model->model_number        = e(Input::get('model_number'));
        $model->manufacturer_id     = e(Input::get('manufacturer_id'));
        $model->category_id         = e(Input::get('category_id'));
        $model->notes               = e(Input::get('notes'));

        $model->requestable = Input::has('requestable');

        if (Input::get('custom_fieldset')=='') {
            $model->fieldset_id = null;
        } else {
            $model->fieldset_id = e(Input::get('custom_fieldset'));
        }

        if (Input::file('image')) {
            $image = Input::file('image');
            $file_name = str_random(25).".".$image->getClientOriginalExtension();
            $path = public_path('uploads/models/'.$file_name);
            Image::make($image->getRealPath())->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path);
            $model->image = $file_name;
        }

        if (Input::get('image_delete') == 1 && Input::file('image') == "") {
            $model->image = null;
        }

        // Was it created?
        if ($model->save()) {
            // Redirect to the new model  page
            return redirect()->to("hardware/models")->with('success', trans('admin/models/message.update.success'));
        } else {
            return redirect()->back()->withInput()->withErrors($model->getErrors());
        }


        // Redirect to the model create page
        return redirect()->to("hardware/models/$modelId/edit")->with('error', trans('admin/models/message.update.error'));

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
    public function getDelete($modelId)
    {
        // Check if the model exists
        if (is_null($model = AssetModel::find($modelId))) {
            // Redirect to the blogs management page
            return redirect()->to('hardware/models')->with('error', trans('admin/models/message.not_found'));
        }

        if ($model->assets->count() > 0) {
            // Throw an error that this model is associated with assets
            return redirect()->to('hardware/models')->with('error', trans('admin/models/message.assoc_users'));

        } else {
            // Delete the model
            $model->delete();

            // Redirect to the models management page
            return redirect()->to('hardware/models')->with('success', trans('admin/models/message.delete.success'));
        }
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
            return redirect()->back()->with('success', $success);

        } else {
            return redirect()->back()->with('error', trans('admin/models/message.not_found'));
        }

    }


    /**
    * Get the model information to present to the model view page
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $modelId
    * @return View
    */
    public function getView($modelId = null)
    {
        $model = AssetModel::withTrashed()->find($modelId);

        if (isset($model->id)) {
                return View::make('models/view', compact('model'));
        } else {
            // Prepare the error message
            $error = trans('admin/models/message.does_not_exist', compact('id'));

            // Redirect to the user management page
            return redirect()->route('models')->with('error', $error);
        }


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
            // Redirect to the model management page
            return redirect()->to('assets/models')->with('error', trans('admin/models/message.does_not_exist'));
        }

        $model = clone $model_to_clone;
        $model->id = null;

        // Show the page
        $depreciation_list = Helper::depreciationList();
        $manufacturer_list = Helper::manufacturerList();
        $category_list = Helper::categoryList('asset');
        $view = View::make('models/edit');
        $view->with('category_list', $category_list);
        $view->with('depreciation_list', $depreciation_list);
        $view->with('manufacturer_list', $manufacturer_list);
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
        return View::make("models.custom_fields_form")->with("model", $model);
    }



    /**
    * Get the JSON response to populate the data tables on the
    * Asset Model listing page.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v2.0]
    * @param string $status
    * @return String JSON
    */

    public function getDatatable($status = null)
    {
        $models = AssetModel::with('category', 'assets', 'depreciation', 'manufacturer');

        switch ($status) {
            case 'Deleted':
                $models->withTrashed()->Deleted();
                break;
        }


        if (Input::has('search')) {
            $models = $models->TextSearch(Input::get('search'));
        }

        if (Input::has('offset')) {
            $offset = e(Input::get('offset'));
        } else {
            $offset = 0;
        }

        if (Input::has('limit')) {
            $limit = e(Input::get('limit'));
        } else {
            $limit = 50;
        }


        $allowed_columns = ['id','name','model_number'];
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array(Input::get('sort'), $allowed_columns) ? e(Input::get('sort')) : 'created_at';

        $models = $models->orderBy($sort, $order);

        $modelCount = $models->count();
        $models = $models->skip($offset)->take($limit)->get();

        $rows = array();

        foreach ($models as $model) {
            if ($model->deleted_at == '') {
                $actions = '<div style=" white-space: nowrap;"><a href="'.route('clone/model', $model->id).'" class="btn btn-info btn-sm" title="Clone Model" data-toggle="tooltip"><i class="fa fa-clone"></i></a> <a href="'.route('update/model', $model->id).'" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a><a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/model', $model->id).'" data-content="'.trans('admin/models/message.delete.confirm').'" data-title="'.trans('general.delete').' '.htmlspecialchars($model->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a></div>';
            } else {
                $actions = '<a href="'.route('restore/model', $model->id).'" class="btn btn-warning btn-sm"><i class="fa fa-recycle icon-white"></i></a>';
            }

            $rows[] = array(
                'id'      => $model->id,
                'manufacturer'      => (string)link_to('/admin/settings/manufacturers/'.$model->manufacturer->id.'/view', $model->manufacturer->name),
                'name'              => (string)link_to('/hardware/models/'.$model->id.'/view', $model->name),
                'image' => ($model->image!='') ? '<img src="'.config('app.url').'/uploads/models/'.$model->image.'" height=50 width=50>' : '',
                'modelnumber'       => $model->model_number,
                'numassets'         => $model->assets->count(),
                'depreciation'      => (($model->depreciation) && ($model->depreciation->id > 0)) ? $model->depreciation->name.' ('.$model->depreciation->months.')' : trans('general.no_depreciation'),
                'category'          => ($model->category) ? (string)link_to('admin/settings/categories/'.$model->category->id.'/view', $model->category->name) : '',
                'eol'               => ($model->eol) ? $model->eol.' '.trans('general.months') : '',
                'note'              => $model->getNote(),
                'fieldset'          => ($model->fieldset) ? (string)link_to('admin/custom_fields/'.$model->fieldset->id, $model->fieldset->name) : '',
                'actions'           => $actions
                );
        }

        $data = array('total' => $modelCount, 'rows' => $rows);

        return $data;
    }


    /**
    * Get the asset information to present to the model view detail page
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v2.0]
    * @param int $modelId
    * @return String JSON
    */
    public function getDataView($modelID)
    {
        $assets = Asset::where('model_id', '=', $modelID)->with('company', 'assetstatus');

        if (Input::has('search')) {
            $assets = $assets->TextSearch(e(Input::get('search')));
        }

        if (Input::has('offset')) {
            $offset = e(Input::get('offset'));
        } else {
            $offset = 0;
        }

        if (Input::has('limit')) {
            $limit = e(Input::get('limit'));
        } else {
            $limit = 50;
        }


        $allowed_columns = ['name', 'serial','asset_tag'];
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array(Input::get('sort'), $allowed_columns) ? e(Input::get('sort')) : 'created_at';

        $assets = $assets->orderBy($sort, $order);

        $assetsCount = $assets->count();
        $assets = $assets->skip($offset)->take($limit)->get();

        $rows = array();


        foreach ($assets as $asset) {
            $actions = '';

            if ($asset->assetstatus) {
                if ($asset->assetstatus->deployable != 0) {
                    if (($asset->assigned_to !='') && ($asset->assigned_to > 0)) {
                        $actions = '<a href="'.route('checkin/hardware', $asset->id).'" class="btn btn-primary btn-sm">'.trans('general.checkin').'</a>';
                    } else {
                        $actions = '<a href="'.route('checkout/hardware', $asset->id).'" class="btn btn-info btn-sm">'.trans('general.checkout').'</a>';
                    }
                }
            }

            $rows[] = array(
                'id'            => $asset->id,
                'name'          => (string)link_to('/hardware/'.$asset->id.'/view', $asset->showAssetName()),
                'asset_tag'     => (string)link_to('hardware/'.$asset->id.'/view', $asset->asset_tag),
                'serial'        => $asset->serial,
                'assigned_to'   => ($asset->assigned_to) ? (string)link_to('/admin/users/'.$asset->assigned_to.'/view', $asset->assigneduser->fullName()) : '',
                'actions'       => $actions,
                'companyName'   => Company::getName($asset)
            );
        }

        $data = array('total' => $assetsCount, 'rows' => $rows);

        return $data;
    }
}
