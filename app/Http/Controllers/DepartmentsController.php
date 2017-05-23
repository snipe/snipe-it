<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;

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
     * @since [v1.0]
     * @return View
     */
    public function index(Request $request)
    {
        $this->authorize('index', Department::class);
        if ($request->has('company_id')) {
            $company = Company::find($request->input('company_id'));
        } else {
            $company = null;
        }
        return view('departments/index')->with('company',$company);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Department::class);
        $department = new Department;
        $department->fill($request->all());

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

        if (isset($department->id)) {
            return view('departments/view', compact('department'));
        }
        return redirect()->route('departments.index')->with('error', trans('admin/departments/message.does_not_exist', compact('id')));
    }
}
