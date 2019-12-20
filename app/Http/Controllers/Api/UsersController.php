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
use App\Http\Transformers\AccessoriesTransformer;
use App\Http\Transformers\LicensesTransformer;

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
            'users.activated',
            'users.address',
            'users.avatar',
            'users.city',
            'users.company_id',
            'users.country',
            'users.created_at',
            'users.deleted_at',
            'users.department_id',
            'users.email',
            'users.employee_num',
            'users.first_name',
            'users.id',
            'users.jobtitle',
            'users.last_login',
            'users.last_name',
            'users.location_id',
            'users.manager_id',
            'users.notes',
            'users.permissions',
            'users.phone',
            'users.state',
            'users.two_factor_enrolled',
            'users.two_factor_optin',
            'users.updated_at',
            'users.username',
            'users.zip',

        ])->with('manager', 'groups', 'userloc', 'company', 'department','assets','licenses','accessories','consumables')
            ->withCount('assets as assets_count','licenses as licenses_count','accessories as accessories_count','consumables as consumables_count');
        $users = Company::scopeCompanyables($users);


        if (($request->filled('deleted')) && ($request->input('deleted')=='true')) {
            $users = $users->GetDeleted();
        }

        if ($request->filled('company_id')) {
            $users = $users->where('users.company_id', '=', $request->input('company_id'));
        }

        if ($request->filled('location_id')) {
            $users = $users->where('users.location_id', '=', $request->input('location_id'));
        }

        if ($request->filled('group_id')) {
            $users = $users->ByGroup($request->get('group_id'));
        }

        if ($request->filled('department_id')) {
            $users = $users->where('users.department_id','=',$request->input('department_id'));
        }

        if ($request->filled('search')) {
            $users = $users->TextSearch($request->input('search'));
        }

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $offset = (($users) && (request('offset') > $users->count())) ? 0 : request('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');


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
            case 'company':
                $users = $users->OrderCompany($order);
                break;
            default:
                $allowed_columns =
                    [
                        'last_name','first_name','email','jobtitle','username','employee_num',
                        'assets','accessories', 'consumables','licenses','groups','activated','created_at',
                        'two_factor_enrolled','two_factor_optin','last_login', 'assets_count', 'licenses_count',
                        'consumables_count', 'accessories_count', 'phone', 'address', 'city', 'state',
                        'country', 'zip', 'id'
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
                'users.username',
                'users.employee_num',
                'users.first_name',
                'users.last_name',
                'users.gravatar',
                'users.avatar',
                'users.email',
            ]
            )->where('show_in_list', '=', '1');

        $users = Company::scopeCompanyables($users);

        if ($request->filled('search')) {
            $users = $users->SimpleNameSearch($request->get('search'))
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

            if ($user->username!='') {
                $name_str .= ' ('.e($user->username).')';
            }

            if ($user->employee_num!='') {
                $name_str .= ' - #'.e($user->employee_num);
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
        $this->authorize('create', User::class);

        $user = new User;
        $user->fill($request->all());

        $tmp_pass = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 20);
        $user->password = bcrypt($request->get('password', $tmp_pass));

        if ($user->save()) {
            if ($request->filled('groups')) {
                $user->groups()->sync($request->input('groups'));
            } else {
                $user->groups()->sync(array());
            }
            
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
        $user = User::withCount('assets as assets_count','licenses as licenses_count','accessories as accessories_count','consumables as consumables_count')->findOrFail($id);
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
        $this->authorize('update', User::class);

        $user = User::findOrFail($id);
        $user->fill($request->all());

        if ($user->id == $request->input('manager_id')) {
            return response()->json(Helper::formatStandardApiResponse('error', null, 'You cannot be your own manager'));
        }

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // Update the location of any assets checked out to this user
        Asset::where('assigned_type', User::class)
            ->where('assigned_to', $user->id)->update(['location_id' => $request->input('location_id', null)]);

        if ($user->save()) {

            // Sync group memberships:
            // This was changed in Snipe-IT v4.6.x to 4.7, since we upgraded to Laravel 5.5
            // which changes the behavior of has vs filled.
            // The $request->has method will now return true even if the input value is an empty string or null.
            // A new $request->filled method has was added that provides the previous behavior of the has method.

            // Check if the request has groups passed and has a value
            if ($request->filled('groups')) {
                $user->groups()->sync($request->input('groups'));
            // The groups field has been passed but it is null, so we should blank it out
            } elseif ($request->has('groups'))  {
                $user->groups()->sync(array());
            }


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


        if (($user->assets) && ($user->assets->count() > 0)) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/users/message.error.delete_has_assets')));
        }

        if (($user->licenses) && ($user->licenses->count() > 0)) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  'This user still has ' . $user->licenses->count() . ' license(s) associated with them and cannot be deleted.'));
        }

        if (($user->accessories) && ($user->accessories->count() > 0)) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  'This user still has ' . $user->accessories->count() . ' accessories associated with them.'));
        }

        if (($user->managedLocations()) && ($user->managedLocations()->count() > 0)) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  'This user still has ' . $user->managedLocations()->count() . ' locations that they manage.'));
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
        $this->authorize('view', Asset::class);
        $assets = Asset::where('assigned_to', '=', $id)->where('assigned_type', '=', User::class)->with('model')->get();
        return (new AssetsTransformer)->transformAssets($assets, $assets->count());
    }

    /**
     * Return JSON containing a list of accessories assigned to a user.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.6.14]
     * @param $userId
     * @return string JSON
     */
    public function accessories($id)
    {
        $this->authorize('view', User::class);
        $user = User::findOrFail($id);
        $this->authorize('view', Accessory::class);
        $accessories = $user->accessories;
        return (new AccessoriesTransformer)->transformAccessories($accessories, $accessories->count());
    }

    /**
     * Return JSON containing a list of licenses assigned to a user.
     *
     * @author [N. Mathar] [<snipe@snipe.net>]
     * @since [v5.0]
     * @param $userId
     * @return string JSON
     */
    public function licenses($id)
    {
        $this->authorize('view', User::class);
        $this->authorize('view', License::class);
        $user = User::where('id', $id)->withTrashed()->first();
        $licenses = $user->licenses()->get();
        return (new LicensesTransformer())->transformLicenses($licenses, $licenses->count());
    }

    /**
     * Reset the user's two-factor status
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @param $userId
     * @return string JSON
     */
    public function postTwoFactorReset(Request $request)
    {

        $this->authorize('update', User::class);

        if ($request->filled('id')) {
            try {
                $user = User::find($request->get('id'));
                $user->two_factor_secret = null;
                $user->two_factor_enrolled = 0;
                $user->save();
                return response()->json(['message' => trans('admin/settings/general.two_factor_reset_success')], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => trans('admin/settings/general.two_factor_reset_error')], 500);
            }
        }
        return response()->json(['message' => 'No ID provided'], 500);

    }

    /**
     * Get info on the current user.
     *
     * @author [Juan Font] [<juanfontalonso@gmail.com>]
     * @since [v4.4.2]
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCurrentUserInfo(Request $request)
    {
        return response()->json($request->user());
    }
}
