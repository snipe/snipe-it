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
        $depreciation_list = array('' => 'Do Not Depreciate') + Depreciation::lists('name', 'id');
        $manufacturer_list = array('' => 'Select One') + Manufacturer::lists('name', 'id');
        $category_list = array('' => '') + DB::table('categories')->whereNull('deleted_at')->lists('name', 'id');
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

        // get the POST data
        $new = Input::all();

        // Create a new manufacturer
        $model = new Model;

        // attempt validation
        if ($model->validate($new)) {

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
        } else {
            // failure
            $errors = $model->errors();
            return Redirect::back()->withInput()->withErrors($errors);
        }

        // Redirect to the model create page
        return Redirect::to('hardware/models/create')->with('error', Lang::get('admin/models/message.create.error'));

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
        $category_list = array('' => '') + DB::table('categories')->lists('name', 'id');
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
        $models = $models->get();

        $actions = new \Chumper\Datatable\Columns\FunctionColumn('actions', function($models) {
            if($models->deleted_at=='') {
                return '<a href="'.route('update/model', $models->id).'" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a><a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/model', $models->id).'" data-content="'.Lang::get('admin/models/message.delete.confirm').'" data-title="'.Lang::get('general.delete').' '.htmlspecialchars($models->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';
            } else {
                return '<a href="'.route('restore/model', $models->id).'" class="btn btn-warning btn-sm"><i class="fa fa-recycle icon-white"></i></a>';
            }
        });

        return Datatable::collection($models)
        ->addColumn('name', function ($models) {
            return link_to('/hardware/models/'.$models->id.'/view', $models->name);
        })
        ->showColumns('modelno')
        ->addColumn('asset_count', function($models) {
            return $models->assets->count();
        })
        ->addColumn('depreciation', function($models) {
            return (($models->depreciation)&&($models->depreciation->id > 0)) ? $models->depreciation->name.' ('.$models->depreciation->months.')' : Lang::get('general.no_depreciation');
        })
        ->addColumn('category', function($models) {
            return ($models->category) ? $models->category->name : '';
        })
        ->addColumn('eol', function($models) {
            return ($models->eol) ? $models->eol.' '.Lang::get('general.months') : '';
        })
        ->addColumn($actions)
        ->searchColumns('name','modelno','asset_count','depreciation','category','eol','actions')
        ->orderColumns('name','modelno','asset_count','depreciation','category','eol','actions')
        ->make();
    }
    
    
    public function getDataView($modelID)
    {
        $model = Model::withTrashed()->find($modelID);
        $modelassets = $model->assets;

        $actions = new \Chumper\Datatable\Columns\FunctionColumn('actions', function ($modelassets) 
            { 
                if (($modelassets->assigned_to !='') && ($modelassets->assigned_to > 0)) {
                    return '<a href="'.route('checkin/hardware', $modelassets->id).'" class="btn btn-primary btn-sm">'.Lang::get('general.checkin').'</a>';
                } else {
                    return '<a href="'.route('checkout/hardware', $modelassets->id).'" class="btn btn-info btn-sm">'.Lang::get('general.checkout').'</a>';
                }
            });

        return Datatable::collection($modelassets)
        ->addColumn('name', function ($modelassets) {
            return link_to('/hardware/'.$modelassets->id.'/view', $modelassets->name);
        })
        ->addColumn('asset_tag', function ($modelassets) {
            return link_to('/hardware/'.$modelassets->id.'/view', $modelassets->asset_tag);
        })
        ->showColumns('serial')
        ->addColumn('assigned_to', function ($modelassets) {
            if ($modelassets->assigned_to) {
                return link_to('/admin/users/'.$modelassets->assigned_to.'/view', $modelassets->assigneduser->fullName());
            }
        })
        ->addColumn($actions)
        ->searchColumns('name','asset_tag','serial','assigned_to','actions')
        ->orderColumns('name','asset_tag','serial','assigned_to','actions')
        ->make();
    }

}
