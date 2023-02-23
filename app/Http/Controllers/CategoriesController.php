<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\ImageUploadRequest;
use App\Models\Category as Category;
use Auth;
use Illuminate\Support\Facades\Storage;
use Str;

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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        // Show the page
        $this->authorize('view', Category::class);

        return view('categories/index');
    }

    /**
     * Returns a form view to create a new category.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see CategoriesController::store() method that stores the data
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        // Show the page
        $this->authorize('create', Category::class);

        return view('categories/edit')->with('item', new Category)
            ->with('category_types', Helper::categoryTypeList());
    }

    /**
     * Validates and stores the new category data.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see CategoriesController::create() method that makes the form.
     * @since [v1.0]
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', Category::class);
        $category = new Category();
        $category->name = $request->input('name');
        $category->category_type = $request->input('category_type');
        $category->eula_text = $request->input('eula_text');
        $category->use_default_eula = $request->input('use_default_eula', '0');
        $category->require_acceptance = $request->input('require_acceptance', '0');
        $category->checkin_email = $request->input('checkin_email', '0');
        $category->user_id = Auth::id();

        $category = $request->handleImages($category);
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($categoryId = null)
    {
        $this->authorize('update', Category::class);
        if (is_null($item = Category::find($categoryId))) {
            return redirect()->route('categories.index')->with('error', trans('admin/categories/message.does_not_exist'));
        }

        return view('categories/edit', compact('item'))
        ->with('category_types', Helper::categoryTypeList());
    }

    /**
     * Validates and stores the updated category data.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see CategoriesController::getEdit() method that makes the form.
     * @param ImageUploadRequest $request
     * @param int $categoryId
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @since [v1.0]
     */
    public function update(ImageUploadRequest $request, $categoryId = null)
    {
        $this->authorize('update', Category::class);
        if (is_null($category = Category::find($categoryId))) {
            // Redirect to the categories management page
            return redirect()->to('admin/categories')->with('error', trans('admin/categories/message.does_not_exist'));
        }

        // Update the category data
        $category->name = $request->input('name');
        // If the item count is > 0, we disable the category type in the edit. Disabled items
        // don't POST, so if the category_type is blank we just set it to the default.
        $category->category_type = $request->input('category_type', $category->category_type);
        $category->eula_text = $request->input('eula_text');
        $category->use_default_eula = $request->input('use_default_eula', '0');
        $category->require_acceptance = $request->input('require_acceptance', '0');
        $category->checkin_email = $request->input('checkin_email', '0');

        $category = $request->handleImages($category);

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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($categoryId)
    {
        $this->authorize('delete', Category::class);
        // Check if the category exists
        if (is_null($category = Category::findOrFail($categoryId))) {
            return redirect()->route('categories.index')->with('error', trans('admin/categories/message.not_found'));
        }

        if (! $category->isDeletable()) {
            return redirect()->route('categories.index')->with('error', trans('admin/categories/message.assoc_items', ['asset_type'=> $category->category_type]));
        }

        Storage::disk('public')->delete('categories'.'/'.$category->image);
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
     * @param $id
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @since [v1.8]
     */
    public function show($id)
    {
        $this->authorize('view', Category::class);
        if ($category = Category::find($id)) {
            if ($category->category_type == 'asset') {
                $category_type = 'hardware';
                $category_type_route = 'assets';
            } elseif ($category->category_type == 'accessory') {
                $category_type = 'accessories';
                $category_type_route = 'accessories';
            } else {
                $category_type = $category->category_type;
                $category_type_route = $category->category_type.'s';
            }

            return view('categories/view', compact('category'))
                ->with('category_type', $category_type)
                ->with('category_type_route', $category_type_route);
        }

        return redirect()->route('categories.index')->with('error', trans('admin/categories/message.does_not_exist'));
    }
}
