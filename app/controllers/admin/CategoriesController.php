<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Category;
use Redirect;
use Setting;
use DB;
use Sentry;
use Str;
use Validator;
use View;
use Datatable;

class CategoriesController extends AdminController
{
    /**
     * Show a list of all the categories.
     *
     * @return View
     */

    public function getIndex()
    {
        // Show the page
        return View::make('backend/categories/index');
    }


    /**
     * Category create.
     *
     * @return View
     */
    public function getCreate()
    {
        // Show the page
         $category_types= categoryTypeList();
        return View::make('backend/categories/edit')->with('category',new Category)
        ->with('category_types',$category_types);
    }


    /**
     * Category create form processing.
     *
     * @return Redirect
     */
    public function postCreate()
    {

        // create a new model instance
        $category = new Category();

        $validator = Validator::make(Input::all(), $category->rules);

        if ($validator->fails())
        {
            // The given data did not pass validation
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
        else{

            // Update the category data
            $category->name            		= e(Input::get('name'));
            $category->category_type        = e(Input::get('category_type'));
            $category->eula_text            = e(Input::get('eula_text'));
            $category->use_default_eula     = e(Input::get('use_default_eula', '0'));
            $category->require_acceptance   = e(Input::get('require_acceptance', '0'));
            $category->checkin_email        = e(Input::get('checkin_email', '0'));
            $category->user_id          	= Sentry::getId();

            // Was the asset created?
            if($category->save()) {
                // Redirect to the new category  page
                return Redirect::to("admin/settings/categories")->with('success', Lang::get('admin/categories/message.create.success'));
            }
        }

        // Redirect to the category create page
        return Redirect::to('admin/settings/categories/create')->with('error', Lang::get('admin/categories/message.create.error'));


    }

    /**
     * Category update.
     *
     * @param  int  $categoryId
     * @return View
     */
    public function getEdit($categoryId = null)
    {
        // Check if the category exists
        if (is_null($category = Category::find($categoryId))) {
            // Redirect to the blogs management page
            return Redirect::to('admin/settings/categories')->with('error', Lang::get('admin/categories/message.does_not_exist'));
        }

        // Show the page
        //$category_options = array('' => 'Top Level') + Category::lists('name', 'id');

        $category_options = array('' => 'Top Level') + DB::table('categories')->where('id', '!=', $categoryId)->lists('name', 'id');
        $category_types= array('' => '', 'asset' => 'Asset', 'accessory' => 'Accessory', 'consumable' => 'Consumable');

        return View::make('backend/categories/edit', compact('category'))
        ->with('category_options',$category_options)
        ->with('category_types',$category_types);
    }


    /**
     * Category update form processing page.
     *
     * @param  int  $categoryId
     * @return Redirect
     */
    public function postEdit($categoryId = null)
    {
        // Check if the blog post exists
        if (is_null($category = Category::find($categoryId))) {
            // Redirect to the blogs management page
            return Redirect::to('admin/categories')->with('error', Lang::get('admin/categories/message.does_not_exist'));
        }


        // get the POST data
        $new = Input::all();

        // attempt validation
        $validator = Validator::make(Input::all(), $category->validationRules($categoryId));


        if ($validator->fails())
        {
            // The given data did not pass validation
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
        // attempt validation
        else {

            // Update the category data
            $category->name            = e(Input::get('name'));
            $category->category_type        = e(Input::get('category_type'));
            $category->eula_text            = e(Input::get('eula_text'));
            $category->use_default_eula     = e(Input::get('use_default_eula', '0'));
            $category->require_acceptance   = e(Input::get('require_acceptance', '0'));
            $category->checkin_email        = e(Input::get('checkin_email', '0'));

            // Was the asset created?
            if($category->save()) {
                // Redirect to the new category page
                return Redirect::to("admin/settings/categories")->with('success', Lang::get('admin/categories/message.update.success'));
            }
        }

        // Redirect to the category management page
        return Redirect::to("admin/settings/categories/$categoryID/edit")->with('error', Lang::get('admin/categories/message.update.error'));

    }

    /**
     * Delete the given category.
     *
     * @param  int  $categoryId
     * @return Redirect
     */
    public function getDelete($categoryId)
    {
        // Check if the category exists
        if (is_null($category = Category::find($categoryId))) {
            // Redirect to the blogs management page
            return Redirect::to('admin/settings/categories')->with('error', Lang::get('admin/categories/message.not_found'));
        }


        if ($category->has_models() > 0) {

            // Redirect to the asset management page
            return Redirect::to('admin/settings/categories')->with('error', Lang::get('admin/categories/message.assoc_users'));
        } else {

            $category->delete();

            // Redirect to the locations management page
            return Redirect::to('admin/settings/categories')->with('success', Lang::get('admin/categories/message.delete.success'));
        }


    }



    /**
    *  Get the asset information to present to the category view page
    *
    * @param  int  $assetId
    * @return View
    **/
    public function getView($categoryID = null)
    {
        $category = Category::find($categoryID);

        if (isset($category->id)) {
                return View::make('backend/categories/view', compact('category'));
        } else {
            // Prepare the error message
            $error = Lang::get('admin/categories/message.does_not_exist', compact('id'));

            // Redirect to the user management page
            return Redirect::route('categories')->with('error', $error);
        }


    }

    public function getDatatable()
    {
        // Grab all the categories
        $categories = Category::with('assets', 'accessories');

        if (Input::has('search')) {
            $categories = $categories->TextSearch(e(Input::get('search')));
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


        $actions = new \Chumper\Datatable\Columns\FunctionColumn('actions', function($categories) {
            return '<a href="'.route('update/category', $categories->id).'" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a><a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/category', $categories->id).'" data-content="'.Lang::get('admin/categories/message.delete.confirm').'" data-title="'.Lang::get('general.delete').' '.htmlspecialchars($categories->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';
        });

        $allowed_columns = ['id','name','category_type'];
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array(Input::get('sort'), $allowed_columns) ? Input::get('sort') : 'created_at';

        $categories = $categories->orderBy($sort, $order);

        $catCount = $categories->count();
        $categories = $categories->skip($offset)->take($limit)->get();

        $rows = array();

        foreach ($categories as $category) {
            $actions = '<a href="'.route('update/category', $category->id).'" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a><a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/category', $category->id).'" data-content="'.Lang::get('admin/categories/message.delete.confirm').'" data-title="'.Lang::get('general.delete').' '.htmlspecialchars($category->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';

            $rows[] = array(
                'id'      => $category->id,
                'name'  => $category->name,
                'category_type' => ucwords($category->category_type),
                'count'         => ($category->category_type=='asset') ? link_to('/admin/settings/categories/'.$category->id.'/view', $category->assetscount()) : $category->accessoriescount(),
                'acceptance'    => ($category->require_acceptance=='1') ? '<i class="fa fa-check"></i>' : '',
                //EULA is still not working correctly
                'eula'          => ($category->getEula()) ? '<i class="fa fa-check"></i>' : '',
                'actions'       => $actions
            );
        }

        $data = array('total' => $catCount, 'rows' => $rows);

        return $data;
    }

    public function getDataView($categoryID) {
        $category = Category::find($categoryID);
        $categoryassets = $category->assets;

        $actions = new \Chumper\Datatable\Columns\FunctionColumn('actions', function ($categoryassets)
            {
                if (($categoryassets->assigned_to !='') && ($categoryassets->assigned_to > 0)) {
                    return '<a href="'.route('checkin/hardware', $categoryassets->id).'" class="btn btn-primary btn-sm">'.Lang::get('general.checkin').'</a>';
                } else {
                    return '<a href="'.route('checkout/hardware', $categoryassets->id).'" class="btn btn-info btn-sm">'.Lang::get('general.checkout').'</a>';
                }
            });

        return Datatable::collection($categoryassets)
        ->addColumn('name', function ($categoryassets) {
            return link_to('/hardware/'.$categoryassets->id.'/view', $categoryassets->name);
        })
        ->addColumn('asset_tag', function ($categoryassets) {
            return link_to('/hardware/'.$categoryassets->id.'/view', $categoryassets->asset_tag);
        })
        ->addColumn('assigned_to', function ($categoryassets) {
            if ($categoryassets->assigned_to) {
                return link_to('/admin/users/'.$categoryassets->assigned_to.'/view', $categoryassets->assigneduser->fullName());
            }
        })
        ->addColumn($actions)
        ->searchColumns('name','asset_tag','assigned_to','actions')
        ->orderColumns('name','asset_tag','assigned_to','actions')
        ->make();
    }


}
