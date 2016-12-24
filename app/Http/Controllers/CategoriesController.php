<?php
namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Category as Category;
use App\Models\Company;
use App\Models\CustomField;
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
    * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        // Show the page
        return View::make('categories/index');
    }


    /**
    * Returns a form view to create a new category.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see CategoriesController::store() method that stores the data
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function create()
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
    * @see CategoriesController::create() method that makes the form.
    * @since [v1.0]
    * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // create a new model instance
        $category = new Category();
        // Update the category data
        $category->name                 = $request->input('name');
        $category->category_type        = $request->input('category_type');
        $category->eula_text            = $request->input('eula_text');
        $category->use_default_eula     = $request->input('use_default_eula', '0');
        $category->require_acceptance   = $request->input('require_acceptance', '0');
        $category->checkin_email        = $request->input('checkin_email', '0');
        $category->user_id              = Auth::id();

        if ($category->save()) {
            return redirect()->route('categories.index')->with('success', trans('admin/categories/message.create.success'));
        }

        return redirect()->back()->withInput()->withErrors($category->getErrors());
    }

    /**
    * Returns a view that makes a form to update a category.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see CategoriesController::postEdit() method saves the data
    * @param int $categoryId
    * @since [v1.0]
    * @return \Illuminate\Contracts\View\View
     */
    public function edit($categoryId = null)
    {
        // Check if the category exists
        if (is_null($item = Category::find($categoryId))) {
            // Redirect to the blogs management page
            return redirect()->to('admin/settings/categories')->with('error', trans('admin/categories/message.does_not_exist'));
        }

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
     * @param Request $request
     * @param int $categoryId
     * @return \Illuminate\Http\RedirectResponse
     * @since [v1.0]
     */
    public function update(Request $request, $categoryId = null)
    {
        // Check if the blog post exists
        if (is_null($category = Category::find($categoryId))) {
            // Redirect to the categories management page
            return redirect()->to('admin/categories')->with('error', trans('admin/categories/message.does_not_exist'));
        }

        // Update the category data
        $category->name                 = $request->input('name');
        // If the item count is > 0, we disable the category type in the edit. Disabled items
        // don't POST, so if the category_type is blank we just set it to the default.
        $category->category_type        = $request->input('category_type', $category->category_type);
        $category->eula_text            = $request->input('eula_text');
        $category->use_default_eula     = $request->input('use_default_eula', '0');
        $category->require_acceptance   = $request->input('require_acceptance', '0');
        $category->checkin_email        = $request->input('checkin_email', '0');

        if ($category->save()) {
            // Redirect to the new category page
            return redirect()->route('categories.index')->with('success', trans('admin/categories/message.update.success'));
        }
        // The given data did not pass validation
        return redirect()->back()->withInput()->withErrors($category->getErrors());
    }

    /**
    * Validates and marks a category as deleted.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @since [v1.0]
    * @param int $categoryId
    * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($categoryId)
    {
        // Check if the category exists
        if (is_null($category = Category::find($categoryId))) {
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
        }

        $category->delete();
        // Redirect to the locations management page
        return redirect()->to('admin/settings/categories')->with('success', trans('admin/categories/message.delete.success'));
    }


    /**
    * Returns a view that invokes the ajax tables which actually contains
    * the content for the categories detail view, which is generated in getDataView.
    *
    * @author [A. Gianotto] [<snipe@snipe.net>]
    * @see CategoriesController::getDataView() method that generates the JSON response
    * @param int $categoryId
    * @since [v1.8]
    * @return \Illuminate\Contracts\View\View
     */
    public function show($categoryId = null)
    {
        $category = Category::find($categoryId);

        if (isset($category->id)) {
                return View::make('categories/view', compact('category'));
        }

        // Prepare the error message
        $error = trans('admin/categories/message.does_not_exist', compact('id'));
        // Redirect to the user management page
        return redirect()->route('categories.index')->with('error', $error);
    }

    /**
     * Returns a JSON response with the data to populate the bootstrap table on the
     * category listing page.
     *
     * @todo Refactor this nastiness. Assets do not behave the same as accessories, etc.
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see CategoriesController::getIndex() method that generates the view
     * @since [v1.8]
     * @param Request $request
     * @return String JSON
     */
    public function getDatatable(Request $request)
    {
        // Grab all the categories
        $categories = Category::with('assets', 'accessories', 'consumables', 'components');

        if (Input::has('search')) {
            $categories = $categories->TextSearch(e($request->input('search')));
        }

        $offset = request('offset', 0);
        $limit = request('limit', 50);

        $allowed_columns = ['id','name','category_type'];
        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? e($request->input('sort')) : 'created_at';

        $categories = $categories->orderBy($sort, $order);

        $catCount = $categories->count();
        $categories = $categories->skip($offset)->take($limit)->get();

        $rows = array();

        foreach ($categories as $category) {
            $rows[] = $category->present()->forDataTable();
        }

        $data = array('total' => $catCount, 'rows' => $rows);

        return $data;
    }

    public function getDataViewAssets(Request $request, $categoryID)
    {
        $category = Category::find($categoryID);
        $category = $category->load('assets.company', 'assets.model', 'assets.assetstatus', 'assets.assigneduser');
        $category_assets = $category->assets();
        if (Input::has('search')) {
            $category_assets = $category_assets->TextSearch(e($request->input('search')));
        }

        $offset = request('offset', 0);
        $limit = request('limit', 50);

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';

        $allowed_columns = ['id','name','serial','asset_tag'];
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $count = $category_assets->count();
        $category_assets = $category_assets->skip($offset)->take($limit)->get();
        $rows = array();
        $all_custom_fields = CustomField::all();
        foreach ($category_assets as $asset) {

            $rows[] = $asset->present()->forDataTable($all_custom_fields);
        }

        $data = array('total' => $count, 'rows' => $rows);
        return $data;
    }


    /**
     * @param $categoryID
     * @return array
     */
    public function getDataViewAccessories(Request $request, $categoryID)
    {

        $category = Category::with('accessories.company')->find($categoryID);
        $category_accessories = $category->accessories();

        if (Input::has('search')) {
            $category_accessories = $category_accessories->TextSearch(e($request->input('search')));
        }

        $offset = request('offset', 0);
        $limit = request('limit', 50);

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';

        $allowed_columns = ['id','name','serial','asset_tag'];
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $count = $category_accessories->count();
        $category_accessories = $category_accessories->skip($offset)->take($limit)->get();

        $rows = array();

        foreach ($category_accessories as $accessory) {
            $rows[] = $accessory->present()->forDataTable();
        }

        $data = array('total' => $count, 'rows' => $rows);
        return $data;
    }


    /**
     * @param $categoryID
     * @param Request $request
     * @return array
     */
    public function getDataViewConsumables($categoryID, Request $request)
    {

        $category = Category::with('accessories.company')->find($categoryID);
        $category_consumables = $category->consumables();

        if (Input::has('search')) {
            $category_consumables = $category_consumables->TextSearch(e($request->input('search')));
        }
        $offset = request('offset', 0);
        $limit = request('limit', 50);

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';

        $allowed_columns = ['id','name','serial','asset_tag'];
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $count = $category_consumables->count();
        $category_consumables = $category_consumables->skip($offset)->take($limit)->get();

        $rows = array();

        foreach ($category_consumables as $consumable) {
            $rows[] = $consumable->present()->forDataTable();
        }

        $data = array('total' => $count, 'rows' => $rows);
        return $data;
    }

    public function getDataViewComponent(Request $request, $categoryID)
    {

        $category = Category::with('accessories.company')->find($categoryID);
        $category_components = $category->components();

        if (Input::has('search')) {
            $category_components = $category_components->TextSearch(e($request->input('search')));
        }

        $offset = request('offset', 0);
        $limit = request('limit', 50);

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';

        $allowed_columns = ['id','name','serial','asset_tag'];
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';
        $count = $category_components->count();
        $category_components = $category_components->skip($offset)->take($limit)->get();

        $rows = array();
        foreach ($category_components as $component) {
            $rows[] = $component->present()->forDataTable();
        }

        $data = array('total' => $count, 'rows' => $rows);
        return $data;
    }
}
