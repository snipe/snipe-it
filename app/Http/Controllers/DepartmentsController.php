<?php

namespace App\Http\Controllers;

use App\Http\Requests\ImageUploadRequest;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
     * @param Request $request
     * @return \Illuminate\Support\Facades\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('index', Department::class);
        $company = null;
        if ($request->filled('company_id')) {
            $company = Company::find($request->input('company_id'));
        }

        return view('departments/index')->with('company', $company);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param ImageUploadRequest $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', Department::class);
        $department = new Department;
        $department->fill($request->all());
        $department->user_id = Auth::user()->id;
        $department->manager_id = ($request->filled('manager_id') ? $request->input('manager_id') : null);
        $department->location_id = ($request->filled('location_id') ? $request->input('location_id') : null);
        $department->company_id = ($request->filled('company_id') ? $request->input('company_id') : null);
        $department = $request->handleImages($department);

        if ($department->save()) {
            return redirect()->route('departments.index')->with('success', trans('admin/departments/message.create.success'));
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show($id)
    {
        $department = Department::find($id);

        $this->authorize('view', $department);

        if (isset($department->id)) {
            return view('departments/view', compact('department'));
        }

        return redirect()->route('departments.index')->with('error', trans('admin/departments/message.does_not_exist'));
    }

    /**
     * Returns a form view used to create a new department.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see DepartmentsController::postCreate() method that validates and stores the data
     * @since [v4.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
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
     * @throws \Illuminate\Auth\Access\AuthorizationException
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

        if ($department->image) {
            try {
                Storage::disk('public')->delete('departments'.'/'.$department->image);
            } catch (\Exception $e) {
                \Log::debug($e);
            }
        }
        $department->delete();

        return redirect()->back()->with('success', trans('admin/departments/message.delete.success'));
    }

    /**
     * Makes a form view to edit Department information.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @see LocationsController::postCreate() method that validates and stores
     * @param int $departmentId
     * @since [v1.0]
     * @return \Illuminate\Contracts\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit($departmentId = null)
    {
        if (is_null($item = Department::find($departmentId))) {
            return redirect()->back()->with('error', trans('admin/locations/message.does_not_exist'));
        }

        $this->authorize('update', $item);

        return view('departments/edit', compact('item'));
    }

    public function update(ImageUploadRequest $request, $id)
    {
        if (is_null($department = Department::find($id))) {
            return redirect()->route('departments.index')->with('error', trans('admin/departments/message.does_not_exist'));
        }

        $this->authorize('update', $department);

        $department->fill($request->all());
        $department->manager_id = ($request->filled('manager_id') ? $request->input('manager_id') : null);
        $department->location_id = ($request->filled('location_id') ? $request->input('location_id') : null);
        $department->company_id = ($request->filled('company_id') ? $request->input('company_id') : null);
        $department->phone = $request->input('phone');
        $department->fax = $request->input('fax');

        $department = $request->handleImages($department);

        if ($department->save()) {
            return redirect()->route('departments.index')->with('success', trans('admin/departments/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($department->getErrors());
    }
}
