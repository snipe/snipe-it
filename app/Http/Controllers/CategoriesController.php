<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Category as Category;
use App\Models\Company;
use App\Models\Setting;
use Auth;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Input;
use Lang;
use Redirect;
use Str;
use View;

/**
 * This class controls all actions related to Categories for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 * @author [A. Gianotto] [<snipe@snipe.net>]
 */
class CategoriesController extends Controller
{

    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the categories listing, which is generated in getDatatable.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see CategoriesController::getDatatable() method that generates the JSON response
    * @since [v1.0]
    * @return View
    */
    public function getIndex()
    {
        // Show the page
        return View::make('categories/index');
    }


    /**
    * Returns a form view to create a new category.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see CategoriesController::postCreate() method that stores the data
    * @since [v1.0]
    * @return View
    */
    public function getCreate()
    {
        // Show the page
         $category_types= Helper::categoryTypeList();
        return View::make('categories/edit')->with('item', new Category)
        ->with('category_types', $category_types);
    }


    /**
    * Validates and stores the new category data.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see CategoriesController::getCreate() method that makes the form.
    * @since [v1.0]
    * @return Redirect
    */
    public function postCreate()
    {

        // create a new model instance
        $category = new Category();

        // Update the category data
        $category->name                 = e(Input::get('name'));
        $category->category_type        = e(Input::get('category_type'));
        $category->eula_text            = e(Input::get('eula_text'));
        $category->use_default_eula     = e(Input::get('use_default_eula', '0'));
        $category->require_acceptance   = e(Input::get('require_acceptance', '0'));
        $category->checkin_email        = e(Input::get('checkin_email', '0'));
        $category->user_id              = Auth::user()->id;

        if ($category->save()) {
        // Redirect to the new category  page
            return redirect()->to("admin/settings/categories")->with('success', trans('admin/categories/message.create.success'));
        } else {

          // The given data did not pass validation
            return redirect()->back()->withInput()->withErrors($category->getErrors());

        }

        // Redirect to the category create page
        return redirect()->to('admin/settings/categories/create')->with('error', trans('admin/categories/message.create.error'));


    }

    /**
    * Returns a view that makes a form to update a category.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see CategoriesController::postEdit() method saves the data
    * @param int $categoryId
    * @since [v1.0]
    * @return View
    */
    public function getEdit($categoryId = null)
    {
        // Check if the category exists
        if (is_null($item = Category::find($categoryId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/settings/categories')->with('error', trans('admin/categories/message.does_not_exist'));
        }

        // Show the page
        //$category_options = array('' => 'Top Level') + Category::lists('name', 'id');

        $category_options = array('' => 'Top Level') + DB::table('categories')->where('id', '!=', $categoryId)->lists('name', 'id');
        $category_types= Helper::categoryTypeList();

        return View::make('categories/edit', compact('item'))
        ->with('category_options', $category_options)
        ->with('category_types', $category_types);
    }


    /**
    * Validates and stores the updated category data.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see CategoriesController::getEdit() method that makes the form.
    * @param int $categoryId
    * @since [v1.0]
    * @return Redirect
    */
    public function postEdit(Request $request, $categoryId = null)
    {
        // Check if the blog post exists
        if (is_null($category = Category::find($categoryId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/categories')->with('error', trans('admin/categories/message.does_not_exist'));
        }

        // Update the category data
        $category->name            = e($request->input('name'));
        // If the item count is > 0, we disable the category type in the edit. Disabled items
        // don't POST, so if the category_type is blank we just set it to the default.
        $category->category_type        = e($request->input('category_type', $category->category_type));
        $category->eula_text            = e($request->input('eula_text'));
        $category->use_default_eula     = e($request->input('use_default_eula', '0'));
        $category->require_acceptance   = e($request->input('require_acceptance', '0'));
        $category->checkin_email        = e($request->input('checkin_email', '0'));

        if ($category->save()) {
        // Redirect to the new category page
            return redirect()->to("admin/settings/categories")->with('success', trans('admin/categories/message.update.success'));
        } // attempt validation
        else {
          // The given data did not pass validation
            return redirect()->back()->withInput()->withErrors($category->getErrors());
        }

        // Redirect to the category management page
        return redirect()->back()->with('error', trans('admin/categories/message.update.error'));

    }

    /**
    * Validates and marks a category as deleted.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $categoryId
    * @return Redirect
    */
    public function getDelete($categoryId)
    {
        // Check if the category exists
        if (is_null($category = Category::find($categoryId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/settings/categories')->with('error', trans('admin/categories/message.not_found'));
        }


        if ($category->has_models() > 0) {
            return redirect()->to('admin/settings/categories')->with('error', trans('admin/categories/message.assoc_items', ['asset_type'=>'model']));

        } elseif ($category->accessories()->count() > 0) {
                return redirect()->to('admin/settings/categories')->with('error', trans('admin/categories/message.assoc_items', ['asset_type'=>'accessory']));

        } elseif ($category->consumables()->count() > 0) {
                return redirect()->to('admin/settings/categories')->with('error', trans('admin/categories/message.assoc_items', ['asset_type'=>'consumable']));

        } elseif ($category->components()->count() > 0) {
                return redirect()->to('admin/settings/categories')->with('error', trans('admin/categories/message.assoc_items', ['asset_type'=>'component']));
        } else {

            $category->delete();

            // Redirect to the locations management page
            return redirect()->to('admin/settings/categories')->with('success', trans('admin/categories/message.delete.success'));
        }


    }



    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the categories detail view, which is generated in getDataView.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see CategoriesController::getDataView() method that generates the JSON response
    * @param int $categoryId
    * @since [v1.8]
    * @return View
    */
    public function getView($categoryId = null)
    {
        $category = Category::find($categoryId);

        if (isset($category->id)) {
                return View::make('categories/view', compact('category'));
        } else {
            // Prepare the error message
            $error = trans('admin/categories/message.does_not_exist', compact('id'));

            // Redirect to the user management page
            return redirect()->route('categories')->with('error', $error);
        }


    }

    /**
    * Returns a JSON response with the data to populate the bootstrap table on the
    * cateory listing page.
    *
    * @todo Refactor this nastiness. Assets do not behave the same as accessories, etc.
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see CategoriesController::getIndex() method that generates the view
    * @since [v1.8]
    * @return String JSON
    */
    public function getDatatable()
    {
        // Grab all the categories
        $categories = Category::with('assets', 'accessories', 'consumables', 'components');

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


        $allowed_columns = ['id','name','category_type'];
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array(Input::get('sort'), $allowed_columns) ? e(Input::get('sort')) : 'created_at';

        $categories = $categories->orderBy($sort, $order);

        $catCount = $categories->count();
        $categories = $categories->skip($offset)->take($limit)->get();

        $rows = array();

        foreach ($categories as $category) {

            $actions = '<a href="'.route('update/category', $category->id).'" class="btn btn-warning btn-sm" style="margin-right:5px;">';
            $actions .='<i class="fa fa-pencil icon-white"></i></a>';
            $actions .='<a data-html="false" class="btn delete-asset btn-danger btn-sm';
            if ($category->itemCount() > 0) {
                $actions .=' disabled';
            }
            $actions .=' data-toggle="modal" href="'.route('delete/category', $category->id).'" data-content="'.trans('admin/categories/message.delete.confirm').'" data-title="'.trans('general.delete').' '.htmlspecialchars($category->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';
            $rows[] = array(
                'id'      => $category->id,
                'name'  => (string)link_to('/admin/settings/categories/'.$category->id.'/view', $category->name) ,
                'category_type' => ucwords($category->category_type),
                'count'         => $category->itemCount(),
                'acceptance'    => ($category->require_acceptance=='1') ? '<i class="fa fa-check"></i>' : '',
                'eula'          => ($category->getEula()) ? '<i class="fa fa-check"></i>' : '',
                'actions'       => $actions
            );
        }

        $data = array('total' => $catCount, 'rows' => $rows);

        return $data;
    }

    public function getDataViewAssets($categoryID)
    {

        $category = Category::find($categoryID);
        $category = $category->load('assets.company', 'assets.model', 'assets.assetstatus', 'assets.assigneduser');
        $category_assets = $category->assets();
        if (Input::has('search')) {
            $category_assets = $category_assets->TextSearch(e(Input::get('search')));
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

        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';

        $allowed_columns = ['id','name','serial','asset_tag'];
        $sort = in_array(Input::get('sort'), $allowed_columns) ? Input::get('sort') : 'created_at';
        $count = $category_assets->count();
        $category_assets = $category_assets->skip($offset)->take($limit)->get();
        $rows = array();
        foreach ($category_assets as $asset) {

            $actions = '';
            $inout='';

            if ($asset->deleted_at=='') {
                $actions = '<div style=" white-space: nowrap;"><a href="'.route('clone/hardware', $asset->id).'" class="btn btn-info btn-sm" title="Clone asset"><i class="fa fa-files-o"></i></a> <a href="'.route('update/hardware', $asset->id).'" class="btn btn-warning btn-sm"><i class="fa fa-pencil icon-white"></i></a> <a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/hardware', $asset->id).'" data-content="'.trans('admin/hardware/message.delete.confirm').'" data-title="'.trans('general.delete').' '.htmlspecialchars($asset->asset_tag).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a></div>';
            } elseif ($asset->deleted_at!='') {
                $actions = '<a href="'.route('restore/hardware', $asset->id).'" class="btn btn-warning btn-sm"><i class="fa fa-recycle icon-white"></i></a>';
            }

            if ($asset->availableForCheckout()) {
                if (Gate::allows('assets.checkout')) {
                    $inout = '<a href="'.route('checkout/hardware', $asset->id).'" class="btn btn-info btn-sm">'.trans('general.checkout').'</a>';
                }
            } else {
                if (Gate::allows('assets.checkin')) {
                    $inout = '<a href="'.route('checkin/hardware', $asset->id).'" class="btn btn-primary btn-sm">'.trans('general.checkin').'</a>';
                }
            }

            $rows[] = array(
                'id' => $asset->id,
                'name' => (string)link_to('/hardware/'.$asset->id.'/view', $asset->showAssetName()),
                'model' => ($asset->model) ? (string)link_to('hardware/models/'.$asset->model->id.'/view', $asset->model->name) : '',
                'asset_tag' => $asset->asset_tag,
                'serial' => $asset->serial,
                'assigned_to' => ($asset->assigneduser) ? (string)link_to('/admin/users/'.$asset->assigneduser->id.'/view', $asset->assigneduser->fullName()): '',
                'change' => $inout,
                'actions' => $actions,
                'companyName'   => is_null($asset->company) ? '' : e($asset->company->name)
            );
        }

        $data = array('total' => $count, 'rows' => $rows);
        return $data;
    }



    public function getDataViewAccessories($categoryID)
    {

        $category = Category::with('accessories.company')->find($categoryID);
        $category_assets = $category->accessories;

        if (Input::has('search')) {
            $category_assets = $category_assets->TextSearch(e(Input::get('search')));
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

        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';

        $allowed_columns = ['id','name','serial','asset_tag'];
        $sort = in_array(Input::get('sort'), $allowed_columns) ? Input::get('sort') : 'created_at';
        $count = $category_assets->count();

        $rows = array();

        foreach ($category_assets as $asset) {

            $actions = '';
            $inout='';

            if ($asset->deleted_at=='') {
                $actions = '<div style=" white-space: nowrap;"><a href="'.route('update/accessory', $asset->id).'" class="btn btn-warning btn-sm"><i class="fa fa-pencil icon-white"></i></a> <a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/accessory', $asset->id).'" data-content="'.trans('admin/hardware/message.delete.confirm').'" data-title="'.trans('general.delete').' '.htmlspecialchars($asset->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a></div>';
            }



            $rows[] = array(
                'id' => $asset->id,
                'name' => (string)link_to_route('view/accessory', $asset->name, [$asset->id]),
                'actions' => $actions,
                'companyName' => Company::getName($asset),
            );
        }

        $data = array('total' => $count, 'rows' => $rows);
        return $data;
    }


    public function getDataViewConsumables($categoryID)
    {

        $category = Category::with('accessories.company')->find($categoryID);
        $category_assets = $category->consumables;

        if (Input::has('search')) {
            $category_assets = $category_assets->TextSearch(e(Input::get('search')));
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

        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';

        $allowed_columns = ['id','name','serial','asset_tag'];
        $sort = in_array(Input::get('sort'), $allowed_columns) ? Input::get('sort') : 'created_at';
        $count = $category_assets->count();

        $rows = array();

        foreach ($category_assets as $asset) {

            $actions = '';
            $inout='';

            if ($asset->deleted_at=='') {
                $actions = '<div style=" white-space: nowrap;"><a href="'.route('update/consumable', $asset->id).'" class="btn btn-warning btn-sm"><i class="fa fa-pencil icon-white"></i></a> <a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/consumable', $asset->id).'" data-content="'.trans('admin/hardware/message.delete.confirm').'" data-title="'.trans('general.delete').' '.htmlspecialchars($asset->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a></div>';
            }



            $rows[] = array(
                'id' => $asset->id,
                'name' => (string) link_to_route('view/consumable', $asset->name, [$asset->id]),
                'actions' => $actions,
                'companyName' => Company::getName($asset),
            );
        }

        $data = array('total' => $count, 'rows' => $rows);
        return $data;
    }

    public function getDataViewComponent($categoryID)
    {

        $category = Category::with('accessories.company')->find($categoryID);
        $category_assets = $category->components;

        if (Input::has('search')) {
            $category_assets = $category_assets->TextSearch(e(Input::get('search')));
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

        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';

        $allowed_columns = ['id','name','serial','asset_tag'];
        $sort = in_array(Input::get('sort'), $allowed_columns) ? Input::get('sort') : 'created_at';
        $count = $category_assets->count();

        $rows = array();

        foreach ($category_assets as $asset) {

            $actions = '';
            $inout='';

            if ($asset->deleted_at=='') {
                $actions = '<div style=" white-space: nowrap;"><a href="'.route('update/component', $asset->id).'" class="btn btn-warning btn-sm"><i class="fa fa-pencil icon-white"></i></a> <a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/component', $asset->id).'" data-content="'.trans('admin/hardware/message.delete.confirm').'" data-title="'.trans('general.delete').' '.htmlspecialchars($asset->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a></div>';
            }



            $rows[] = array(
                'id' => $asset->id,
                'name' => (string)link_to_route('view/accessory', $asset->name, [$asset->id]),
                'actions' => $actions,
                'companyName' => Company::getName($asset),
            );
        }

        $data = array('total' => $count, 'rows' => $rows);
        return $data;
    }
}
