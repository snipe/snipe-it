<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Helpers\Helper;
use Auth;
use Image;
use App\Http\Requests\ImageUploadRequest;

class DepartmentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        parent::__construct();
    }

    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the assets listing, which is generated in getDatatable.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see AssetController::getDatatable() method that generates the JSON response
     * @since [v4.0]
     * @return View
     */
    public function index(Request $request)
    {
        $this->authorize('index', Department::class);
        $company = null;
        if ($request->has('company_id')) {
            $company = Company::find($request->input('company_id'));
        }
        return view('departments/index')->with('company', $company);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', Department::class);
        $department = new Department;
        $department->fill($request->all());
        $department->user_id = Auth::user()->id;
        $department->manager_id = ($request->has('manager_id' ) ? $request->input('manager_id') : null);

        if ($request->file('image')) {
            $image = $request->file('image');
            $file_name = str_random(25).".".$image->getClientOriginalExtension();
            $path = public_path('uploads/departments/'.$file_name);
            Image::make($image->getRealPath())->resize(200, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path);
            $department->image = $file_name;
        }

        if ($department->save()) {
            return redirect()->route("departments.index")->with('success', trans('admin/departments/message.create.success'));
        }
        return redirect()->back()->withInput()->withErrors($department->getErrors());
    }

    /**
     * Returns a view that invokes the ajax tables which actually contains
     * the content for the department detail page.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $id
     * @since [v4.0]
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $department = Department::find($id);

        $this->authorize('view', $department);

        if (isset($department->id)) {
            return view('departments/view', compact('department'));
        }
        return redirect()->route('departments.index')->with('error', trans('admin/departments/message.does_not_exist', compact('id')));
    }


    /**
     * Returns a form view used to create a new department.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see DepartmentsController::postCreate() method that validates and stores the data
     * @since [v4.0]
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $this->authorize('create', Department::class);

        return view('departments/edit')->with('item', new Department);
    }


    /**
     * Validates and deletes selected department.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param int $locationId
     * @since [v4.0]
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if (is_null($department = Department::find($id))) {
            return redirect()->to(route('departments.index'))->with('error', trans('admin/departments/message.not_found'));
        }

        $this->authorize('delete', $department);

        if ($department->users->count() > 0) {
            return redirect()->to(route('departments.index'))->with('error', trans('admin/departments/message.assoc_users'));
        }

        $department->delete();
        return redirect()->back()->with('success', trans('admin/departments/message.delete.success'));

    }

    /**
     * Makes a form view to edit location information.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see LocationsController::postCreate() method that validates and stores
     * @param int $locationId
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id = null)
    {
        if (is_null($item = Department::find($id))) {
            return redirect()->back()->with('error', trans('admin/locations/message.does_not_exist'));
        }

        $this->authorize('update', $item);

        return view('departments/edit', compact('item'));
    }

    public function update(ImageUploadRequest $request, $id) {

        if (is_null($department = Department::find($id))) {
            return redirect()->route('departments.index')->with('error', trans('admin/departments/message.does_not_exist'));
        }

        $this->authorize('update', $department);

        $department->fill($request->all());
        $department->manager_id = ($request->has('manager_id' ) ? $request->input('manager_id') : null);

        $old_image = $department->image;

        // Set the model's image property to null if the image is being deleted
        if ($request->input('image_delete') == 1) {
            $department->image = null;
        }

        if ($request->file('image')) {
            $image = $request->file('image');
            $file_name = $department->id.'-'.str_slug($image->getClientOriginalName()) . "." . $image->getClientOriginalExtension();

            if ($image->getClientOriginalExtension()!='svg') {
                Image::make($image->getRealPath())->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                })->save(app('departments_upload_path').$file_name);
            } else {
                $image->move(app('departments_upload_path'), $file_name);
            }
            $department->image = $file_name;

        }

        if ((($request->file('image')) && (isset($old_image)) && ($old_image!='')) || ($request->input('image_delete') == 1)) {
            try  {
                unlink(app('departments_upload_path').$old_image);
            } catch (\Exception $e) {
                \Log::error($e);
            }
        }

        if ($department->save()) {
            return redirect()->route("departments.index")->with('success', trans('admin/departments/message.update.success'));
        }
        return redirect()->back()->withInput()->withErrors($department->getErrors());
    }
}
