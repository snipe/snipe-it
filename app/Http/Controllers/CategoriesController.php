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
use Image;
use App\Http\Requests\ImageUploadRequest;

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
        return view('categories/index');
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
        return view('categories/edit')->with('item', new Category)
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
    public function store(ImageUploadRequest $request)
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

        if ($request->file('image')) {
            $image = $request->file('image');
            $file_name = str_random(25).".".$image->getClientOriginalExtension();
            $path = public_path('uploads/categories/'.$file_name);
            Image::make($image->getRealPath())->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path);
            $category->image = $file_name;
        }


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
        if (is_null($item = Category::find($categoryId))) {
            return redirect()->route('categories.index')->with('error', trans('admin/categories/message.does_not_exist'));
        }
        $category_types= Helper::categoryTypeList();

        return view('categories/edit', compact('item'))
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
    public function update(ImageUploadRequest $request, $categoryId = null)
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

        if ($request->file('image')) {
            $image = $request->file('image');
            $file_name = str_random(25).".".$image->getClientOriginalExtension();
            $path = public_path('uploads/categories/'.$file_name);
            Image::make($image->getRealPath())->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path);
            $category->image = $file_name;
        } elseif ($request->input('image_delete')=='1') {
            $category->image = null;
        }


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
            return redirect()->route('categories.index')->with('error', trans('admin/categories/message.not_found'));
        }

        if ($category->has_models() > 0) {
            return redirect()->route('categories.index')->with('error', trans('admin/categories/message.assoc_items', ['asset_type'=>'model']));
        } elseif ($category->accessories()->count() > 0) {
                return redirect()->route('categories.index')->with('error', trans('admin/categories/message.assoc_items', ['asset_type'=>'accessory']));
        } elseif ($category->consumables()->count() > 0) {
                return redirect()->route('categories.index')->with('error', trans('admin/categories/message.assoc_items', ['asset_type'=>'consumable']));
        } elseif ($category->components()->count() > 0) {
                return redirect()->route('categories.index')->with('error', trans('admin/categories/message.assoc_items', ['asset_type'=>'component']));
        }

        $category->delete();
        // Redirect to the locations management page
        return redirect()->route('categories.index')->with('success', trans('admin/categories/message.delete.success'));
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
    public function show($id)
    {
        if ($category = Category::find($id)) {

            if ($category->category_type=='asset') {
                $category_type = 'hardware';
                $category_type_route = 'assets';
            } elseif ($category->category_type=='accessory') {
                $category_type = 'accessories';
                $category_type_route = 'accessories';
            } else {
                $category_type = $category->category_type;
                $category_type_route = $category->category_type.'s';
            }
            return view('categories/view', compact('category'))
                ->with('category_type',$category_type)
                ->with('category_type_route',$category_type_route);
        }

        // Prepare the error message
        $error = trans('admin/categories/message.does_not_exist', compact('id'));
        // Redirect to the user management page
        return redirect()->route('categories.index')->with('error', $error);
    }


}
