<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Transformers\UsersTransformer;
use App\Models\Company;
use App\Models\User;
use App\Helpers\Helper;
use App\Http\Requests\SaveUserRequest;
use App\Models\Asset;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', User::class);

        $users = User::select([
            'users.id',
            'users.employee_num',
            'users.two_factor_enrolled',
            'users.jobtitle',
            'users.email',
            'users.username',
            'users.location_id',
            'users.manager_id',
            'users.first_name',
            'users.last_name',
            'users.created_at',
            'users.notes',
            'users.company_id',
            'users.last_login',
            'users.deleted_at',
            'users.department_id',
            'users.activated'
        ])->with('manager', 'groups', 'userloc', 'company', 'department','throttle','assets','licenses','accessories','consumables')
            ->withCount('assets','licenses','accessories','consumables');
        $users = Company::scopeCompanyables($users);


        if ($request->has('search')) {
            $users = $users->TextSearch($request->input('search'));
        }


        if (($request->has('deleted')) && ($request->input('deleted')=='true')) {
            $users = $users->GetDeleted();
        }

        if ($request->has('company_id')) {
            $users = $users->where('company_id', '=', $request->input('company_id'));
        }

        if ($request->has('location_id')) {
            $users = $users->where('location_id', '=', $request->input('location_id'));
        }
        
        if ($request->has('group_id')) {
            $users = $users->ByGroup($request->has('group_id'));
        }

        if ($request->has('department_id')) {
            $users = $users->where('department_id','=',$request->input('department_id'));
        }

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $offset = request('offset', 0);
        $limit = request('limit', 50);

        switch ($request->input('sort')) {
            case 'manager':
                $users = $users->OrderManager($order);
                break;
            case 'location':
                $users = $users->OrderLocation($order);
                break;
            case 'department':
                $users = $users->OrderDepartment($order);
                break;
            default:
                $allowed_columns =
                    [
                        'last_name','first_name','email','jobtitle','username','employee_num',
                        'assets','accessories', 'consumables','licenses','groups','activated','created_at',
                        'two_factor_enrolled','two_factor_optin','last_login'
                    ];

                $sort = in_array($request->get('sort'), $allowed_columns) ? $request->get('sort') : 'first_name';
                $users = $users->orderBy($sort, $order);
                break;
        }
        $total = $users->count();
        $users = $users->skip($offset)->take($limit)->get();
        return (new UsersTransformer)->transformUsers($users, $total);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SaveUserRequest $request)
    {
        $this->authorize('view', User::class);
        $user = new User;
        $user->fill($request->all());
        $user->password = bcrypt($request->input('password'));

        if ($user->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', (new UsersTransformer)->transformUser($user), trans('admin/users/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $user->getErrors()));
    }

    /**
     * Display the specified resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('view', User::class);
        $user = User::findOrFail($id);
        return (new UsersTransformer)->transformUser($user);
    }


    /**
     * Update the specified resource in storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SaveUserRequest $request, $id)
    {
        $this->authorize('edit', User::class);
        $user = User::findOrFail($id);
        $user->fill($request->all());

        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }


        if ($user->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', (new UsersTransformer)->transformUser($user), trans('admin/users/message.success.update')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $user->getErrors()));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete', User::class);
        $user = User::findOrFail($id);
        $this->authorize('delete', $user);


        if ($user->assets()->count() > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/users/message.error.delete_has_assets')));
        }

        if ($user->delete()) {
            return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/users/message.success.delete')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/users/message.error.delete')));
    }

    /**
     * Return JSON containing a list of assets assigned to a user.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @param $userId
     * @return string JSON
     */
    public function assets($id)
    {
        $this->authorize('view', User::class);
        $assets = Asset::where('assigned_to', '=', $id)->with('model')->get();
        return response()->json($assets);
    }
}
