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
use App\Http\Transformers\AssetsTransformer;
use App\Http\Transformers\SelectlistTransformer;

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
            'users.phone',
            'users.address',
            'users.city',
            'users.state',
            'users.country',
            'users.zip',
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
            'users.activated',
            'users.avatar',

        ])->with('manager', 'groups', 'userloc', 'company', 'department','assets','licenses','accessories','consumables')
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
            $users = $users->ByGroup($request->get('group_id'));
        }

        if ($request->has('department_id')) {
            $users = $users->where('users.department_id','=',$request->input('department_id'));
        }

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $offset = request('offset', 0);
        $limit = request('limit',  20);

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
                        'two_factor_enrolled','two_factor_optin','last_login', 'assets_count', 'licenses_count',
                        'consumables_count', 'accessories_count', 'phone', 'address', 'city', 'state',
                        'country', 'zip'
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
     * Gets a paginated collection for the select2 menus
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0.16]
     * @see \App\Http\Transformers\SelectlistTransformer
     *
     */
    public function selectlist(Request $request)
    {

        $users = User::select(
            [
                'users.id',
                'users.employee_num',
                'users.first_name',
                'users.last_name',
                'users.gravatar',
                'users.avatar',
                'users.email',
            ]
            );

        $users = Company::scopeCompanyables($users);

        if ($request->has('search')) {
            $users = $users->where('first_name', 'LIKE', '%'.$request->get('search').'%')
                ->orWhere('last_name', 'LIKE', '%'.$request->get('search').'%')
                ->orWhere('username', 'LIKE', '%'.$request->get('search').'%')
                ->orWhere('employee_num', 'LIKE', '%'.$request->get('search').'%');
        }

        $users = $users->orderBy('last_name', 'asc')->orderBy('first_name', 'asc');
        $users = $users->paginate(50);

        foreach ($users as $user) {
            $name_str = '';
            if ($user->last_name!='') {
                $name_str .= e($user->last_name).', ';
            }
            $name_str .= e($user->first_name);

            if ($user->employee_num!='') {
                $name_str .= ' (#'.e($user->employee_num).')';
            }

            $user->use_text = $name_str;
            $user->use_image = ($user->present()->gravatar) ? $user->present()->gravatar : null;
        }

        return (new SelectlistTransformer)->transformSelectlist($users);

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
            return response()->json(Helper::formatStandardApiResponse('success', (new UsersTransformer)->transformUser($user), trans('admin/users/message.success.create')));
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

        if ($user->id == $request->input('manager_id')) {
            return response()->json(Helper::formatStandardApiResponse('error', null, 'You cannot be your own manager'));
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // Update the location of any assets checked out to this user
        Asset::where('assigned_type', User::class)
            ->where('assigned_to', $user->id)->update(['location_id' => $request->input('location_id', null)]);

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
        return (new AssetsTransformer)->transformAssets($assets, $assets->count());
    }
}
