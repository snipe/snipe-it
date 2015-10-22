<?php namespace Controllers\Admin;

use AdminController;
use Image;
use Input;
use Lang;
use Model;
use Redirect;
use Setting;
use Sentry;
use DB;
use Depreciation;
use Manufacturer;
use Str;
use Validator;
use View;
use Datatable;

//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class ModelsController extends AdminController
{
    /**
     * Show a list of all the models.
     *
     * @return View
     */
    public function getIndex()
    {
        // Show the page
        return View::make('backend/models/index');
    }

/**
     * Model create.
     *
     * @return View
     */
    public function getCreate()
    {
        // Show the page
        $depreciation_list = depreciationList();
        $manufacturer_list = manufacturerList();
        $category_list = categoryList();
        $view = View::make('backend/models/edit');
        $view->with('category_list',$category_list);
        $view->with('depreciation_list',$depreciation_list);
        $view->with('manufacturer_list',$manufacturer_list);
        $view->with('model',new Model);
        return $view;
    }


    /**
     * Model create form processing.
     *
     * @return Redirect
     */
    public function postCreate()
    {

        // Create a new manufacturer
        $model = new Model;


        $validator = Validator::make(
            // Validator data goes here
            array(
                'unique_fields' => array(Input::get('name'), Input::get('modelno'), Input::get('manufacturer_id'))
            ),
            // Validator rules go here
            array(
                'unique_fields' => 'unique_multiple:models,name,modelno,manufacturer_id'
            )
        );

        // attempt validation
        if ($validator->fails())
        {
            // The given data did not pass validation
            return Redirect::back()->withInput()->with('error', Lang::get('admin/models/message.create.duplicate_set'));;
        }



        $validator = Validator::make(Input::all(), $model->validationRules());

        // attempt validation
        if ($validator->fails())
        {
            // The given data did not pass validation
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
        // attempt validation
        else {

            if ( e(Input::get('depreciation_id')) == '') {
                $model->depreciation_id =  0;
            } else {
                $model->depreciation_id = e(Input::get('depreciation_id'));
            }

            if ( e(Input::get('eol')) == '') {
                $model->eol =  0;
            } else {
                $model->eol = e(Input::get('eol'));
            }

            // Save the model data
            $model->name            	= e(Input::get('name'));
            $model->modelno            	= e(Input::get('modelno'));
            $model->manufacturer_id    	= e(Input::get('manufacturer_id'));
            $model->category_id    		= e(Input::get('category_id'));
            $model->user_id          	= Sentry::getId();
            $model->show_mac_address 	= e(Input::get('show_mac_address', '0'));


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

            // Was it created?
            if($model->save()) {
                // Redirect to the new model  page
                return Redirect::to("hardware/models")->with('success', Lang::get('admin/models/message.create.success'));
            }
        }

        // Redirect to the model create page
        return Redirect::to('hardware/models/create')->with('error', Lang::get('admin/models/message.create.error'));

    }

    public function store()
    {
      //COPYPASTA!!!! FIXME
      $model = new Model;

      $settings=Input::all();
      $settings['eol']=0;
      //

      $validator = Validator::make($settings, $model->validationRules());
      if ($validator->fails())
      {
          // The given data did not pass validation
          return JsonResponse::create(["error" => "Failed validation: ".print_r($validator->messages()->all('<li>:message</li>'),true)],500);
      } else {
        $model->name=e(Input::get('name'));
        $model->manufacturer_id = e(Input::get('manufacturer_id'));
        $model->category_id = e(Input::get('category_id'));
        $model->modelno = e(Input::get('modelno'));
        $model->user_id = Sentry::getUser()->id;
        $model->eol=0;

        if($model->save()) {
          return JsonResponse::create($model);
        } else {
          return JsonResponse::create(["error" => "Couldn't save Model"],500);
        }
      }
    }

    /**
     * Model update.
     *
     * @param  int  $modelId
     * @return View
     */
    public function getEdit($modelId = null)
    {
        // Check if the model exists
        if (is_null($model = Model::find($modelId))) {
            // Redirect to the model management page
            return Redirect::to('assets/models')->with('error', Lang::get('admin/models/message.does_not_exist'));
        }

        $depreciation_list = array('' => 'Do Not Depreciate') + Depreciation::lists('name', 'id');
        $manufacturer_list = array('' => 'Select One') + Manufacturer::lists('name', 'id');
        $category_list = array('' => '') + DB::table('categories')->whereNull('deleted_at')->lists('name', 'id');
        $view = View::make('backend/models/edit', compact('model'));
        $view->with('category_list',$category_list);
        $view->with('depreciation_list',$depreciation_list);
        $view->with('manufacturer_list',$manufacturer_list);
        return $view;
    }


    /**
     * Model update form processing page.
     *
     * @param  int  $modelId
     * @return Redirect
     */
    public function postEdit($modelId = null)
    {
        // Check if the model exists
        if (is_null($model = Model::find($modelId))) {
            // Redirect to the models management page
            return Redirect::to('admin/models')->with('error', Lang::get('admin/models/message.does_not_exist'));
        }

          //attempt to validate
        $validator = Validator::make(Input::all(), $model->validationRules($modelId));

        if ($validator->fails())
        {
            // The given data did not pass validation
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
        // attempt validation
        else {

            if ( e(Input::get('depreciation_id')) == '') {
                $model->depreciation_id =  0;
            } else {
                $model->depreciation_id = e(Input::get('depreciation_id'));
            }

             if ( e(Input::get('eol')) == '') {
                $model->eol =  0;
            } else {
                $model->eol = e(Input::get('eol'));
            }

            // Update the model data
            $model->name            	= e(Input::get('name'));
            $model->modelno            	= e(Input::get('modelno'));
            $model->manufacturer_id    	= e(Input::get('manufacturer_id'));
            $model->category_id    		= e(Input::get('category_id'));
            //$model->show_mac_address 	= e(Input::get('show_mac_address', '0'));
            $model->fieldset_id = e(Input::get('custom_fieldset'));

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
                $model->image = NULL;
            }

            // Was it created?
            if($model->save()) {
                // Redirect to the new model  page
                return Redirect::to("hardware/models")->with('success', Lang::get('admin/models/message.update.success'));
            }
        }

        // Redirect to the model create page
        return Redirect::to("hardware/models/$modelId/edit")->with('error', Lang::get('admin/models/message.update.error'));

    }

    /**
     * Delete the given model.
     *
     * @param  int  $modelId
     * @return Redirect
     */
    public function getDelete($modelId)
    {
        // Check if the model exists
        if (is_null($model = Model::find($modelId))) {
            // Redirect to the blogs management page
            return Redirect::to('hardware/models')->with('error', Lang::get('admin/models/message.not_found'));
        }

        if ($model->assets->count() > 0) {
            // Throw an error that this model is associated with assets
            return Redirect::to('hardware/models')->with('error', Lang::get('admin/models/message.assoc_users'));

        } else {
            // Delete the model
            $model->delete();

            // Redirect to the models management page
            return Redirect::to('hardware/models')->with('success', Lang::get('admin/models/message.delete.success'));
        }
    }

    public function getRestore($modelId = null)
    {

		// Get user information
		$model = Model::withTrashed()->find($modelId);

		 if (isset($model->id)) {

			// Restore the model
			$model->restore();

			// Prepare the success message
			$success = Lang::get('admin/models/message.restore.success');

			// Redirect back
			return Redirect::back()->with('success', $success);

		 } else {
			 return Redirect::back()->with('error', Lang::get('admin/models/message.not_found'));
		 }

    }


    /**
    *  Get the asset information to present to the model view page
    *
    * @param  int  $assetId
    * @return View
    **/
    public function getView($modelId = null)
    {
        $model = Model::withTrashed()->find($modelId);

        if (isset($model->id)) {
                return View::make('backend/models/view', compact('model'));
        } else {
            // Prepare the error message
            $error = Lang::get('admin/models/message.does_not_exist', compact('id'));

            // Redirect to the user management page
            return Redirect::route('models')->with('error', $error);
        }


    }

        public function getClone($modelId = null)
    {
        // Check if the model exists
        if (is_null($model_to_clone = Model::find($modelId))) {
            // Redirect to the model management page
            return Redirect::to('assets/models')->with('error', Lang::get('admin/models/message.does_not_exist'));
        }

        $model = clone $model_to_clone;
        $model->id = null;

        // Show the page
        $depreciation_list = array('' => 'Do Not Depreciate') + Depreciation::lists('name', 'id');
        $manufacturer_list = array('' => 'Select One') + Manufacturer::lists('name', 'id');
        $category_list = array('' => '') + DB::table('categories')->whereNull('deleted_at')->lists('name', 'id');
        $view = View::make('backend/models/edit');
        $view->with('category_list',$category_list);
        $view->with('depreciation_list',$depreciation_list);
        $view->with('manufacturer_list',$manufacturer_list);
        $view->with('model',$model);
        $view->with('clone_model',$model_to_clone);
        return $view;

    }

    public function getDatatable($status = null)
    {
        $models = Model::orderBy('created_at', 'DESC')->with('category','assets','depreciation');
        ($status != 'Deleted') ?: $models->withTrashed()->Deleted();;

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


        $allowed_columns = ['name'];
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array(Input::get('sort'), $allowed_columns) ? Input::get('sort') : 'created_at';

        $models = $models->orderBy($sort, $order);

        $modelCount = $models->count();
        $models = $models->skip($offset)->take($limit)->get();

        $rows = array();

        foreach ($models as $model) {
            if ($model->deleted_at == '') {
                $actions = '<a href="'.route('update/model', $model->id).'" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a><a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/model', $model->id).'" data-content="'.Lang::get('admin/models/message.delete.confirm').'" data-title="'.Lang::get('general.delete').' '.htmlspecialchars($model->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';
            } else {
                $actions = '<a href="'.route('restore/model', $model->id).'" class="btn btn-warning btn-sm"><i class="fa fa-recycle icon-white"></i></a>';
            }

            $rows[] = array(
                'manufacturer'      => $model->manufacturer->name,
                'name'              => link_to('/hardware/models/'.$model->id.'/view', $model->name),
                'modelnumber'       => $model->modelno,
                'numassets'         => $model->assets->count(),
                'depreciation'      => (($model->depreciation)&&($model->depreciation->id > 0)) ? $model->depreciation->name.' ('.$model->depreciation->months.')' : Lang::get('general.no_depreciation'),
                'category'          => ($model->category) ? $model->category->name : '',
                'eol'               => ($model->eol) ? $model->eol.' '.Lang::get('general.months') : '',
                'actions'           => $actions
                );
        }

        $data = array('total' => $modelCount, 'rows' => $rows);

        return $data;
    }


    public function getDataView($modelID)
    {
        $model = Model::withTrashed()->find($modelID);
        $modelassets = $model->assets;

        $modelassetsCount = $modelassets->Count();

        $rows = array();

        foreach ($modelassets as $asset) {
            if (($asset->assigned_to !='') && ($asset->assigned_to > 0)) {
                $actions = '<a href="'.route('checkin/hardware', $asset->id).'" class="btn btn-primary btn-sm">'.Lang::get('general.checkin').'</a>';
            } else {
                $actions = '<a href="'.route('checkout/hardware', $asset->id).'" class="btn btn-info btn-sm">'.Lang::get('general.checkout').'</a>';
            }

            $rows[] = array(
                'name'          => link_to('/hardware/'.$asset->id.'/view', $asset->showAssetName()),
                'asset_tag'     => link_to('hardware/'.$asset->id.'/view', $asset->asset_tag),
                'serial'        => $asset->serial,
                'assigned_to'   => ($asset->assigned_to) ? link_to('/admin/users/'.$asset->assigned_to.'/view', $asset->assigneduser->fullName()) : '',
                'actions'       => $actions
                );
        }

        $data = array('total' => $modelassetsCount, 'rows' => $rows);

        return $data;
    }

}
