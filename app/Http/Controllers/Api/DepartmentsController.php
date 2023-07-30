<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Transformers\DepartmentsTransformer;
use App\Http\Transformers\SelectlistTransformer;
use App\Models\Company;
use App\Models\Department;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\ImageUploadRequest;
use Illuminate\Support\Facades\Storage;

class DepartmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @author [Godfrey Martinez] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Department::class);
        $allowed_columns = ['id', 'name', 'image', 'users_count'];

        $departments = Company::scopeCompanyables(Department::select(
            'departments.id',
            'departments.name',
            'departments.phone',
            'departments.fax',
            'departments.location_id',
            'departments.company_id',
            'departments.manager_id',
            'departments.created_at',
            'departments.updated_at',
            'departments.image'),
             "company_id", "departments")->with('users')->with('location')->with('manager')->with('company')->withCount('users as users_count');

        if ($request->filled('search')) {
            $departments = $departments->TextSearch($request->input('search'));
        }

        if ($request->filled('name')) {
            $departments->where('name', '=', $request->input('name'));
        }

        if ($request->filled('company_id')) {
            $departments->where('company_id', '=', $request->input('company_id'));
        }

        if ($request->filled('manager_id')) {
            $departments->where('manager_id', '=', $request->input('manager_id'));
        }

        if ($request->filled('location_id')) {
            $departments->where('location_id', '=', $request->input('location_id'));
        }

        // Make sure the offset and limit are actually integers and do not exceed system limits
        $offset = ($request->input('offset') > $departments->count()) ? $departments->count() : abs($request->input('offset'));
        $limit = app('api_limit_value');

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';

        switch ($request->input('sort')) {
            case 'location':
                $departments->OrderLocation($order);
                break;
            case 'manager':
                $departments->OrderManager($order);
                break;
            default:
                $departments->orderBy($sort, $order);
                break;
        }

        $total = $departments->count();
        $departments = $departments->skip($offset)->take($limit)->get();
        return (new DepartmentsTransformer)->transformDepartments($departments, $total);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \App\Http\Requests\ImageUploadRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ImageUploadRequest $request)
    {
        $this->authorize('create', Department::class);
        $department = new Department;
        $department->fill($request->all());
        $department = $request->handleImages($department);

        $department->user_id = Auth::user()->id;
        $department->manager_id = ($request->filled('manager_id') ? $request->input('manager_id') : null);

        if ($department->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $department, trans('admin/departments/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $department->getErrors()));

    }

    /**
     * Display the specified resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', Department::class);
        $department = Department::findOrFail($id);

        return (new DepartmentsTransformer)->transformDepartment($department);
    }

    /**
     * Update the specified resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v5.0]
     * @param  \App\Http\Requests\ImageUploadRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ImageUploadRequest $request, $id)
    {
        $this->authorize('update', Department::class);
        $department = Department::findOrFail($id);
        $department->fill($request->all());
        $department = $request->handleImages($department);

        if ($department->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $department, trans('admin/departments/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $department->getErrors()));
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
        $department = Department::findOrFail($id);

        $this->authorize('delete', $department);

        if ($department->users->count() > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/departments/message.assoc_users')));
        }

        $department->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null, trans('admin/departments/message.delete.success')));

    }

    /**
     * Gets a paginated collection for the select2 menus
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0.16]
     * @see \App\Http\Transformers\SelectlistTransformer
     */
    public function selectlist(Request $request)
    {

        $this->authorize('view.selectlists');
        $departments = Department::select([
            'id',
            'name',
            'image',
        ]);

        if ($request->filled('search')) {
            $departments = $departments->where('name', 'LIKE', '%'.$request->get('search').'%');
        }

        $departments = $departments->orderBy('name', 'ASC')->paginate(50);

        // Loop through and set some custom properties for the transformer to use.
        // This lets us have more flexibility in special cases like assets, where
        // they may not have a ->name value but we want to display something anyway
        foreach ($departments as $department) {
            $department->use_image = ($department->image) ? Storage::disk('public')->url('departments/'.$department->image, $department->image) : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($departments);
    }
}
