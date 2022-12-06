<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Http\Requests\SaveUserRequest;
use App\Http\Transformers\AccessoriesTransformer;
use App\Http\Transformers\AssetsTransformer;
use App\Http\Transformers\ConsumablesTransformer;
use App\Http\Transformers\LicensesTransformer;
use App\Http\Transformers\SelectlistTransformer;
use App\Http\Transformers\UsersTransformer;
use App\Models\Asset;
use App\Models\Company;
use App\Models\License;
use App\Models\User;
use App\Notifications\CurrentInventory;
use Auth;
use Illuminate\Http\Request;
use App\Http\Requests\ImageUploadRequest;
use Illuminate\Support\Facades\Storage;

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
            'users.created_by',
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
            'users.locale',
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
            'users.remote',
            'users.ldap_import',
            'users.start_date',
            'users.end_date',

        ])->with('manager', 'groups', 'userloc', 'company', 'department', 'assets', 'licenses', 'accessories', 'consumables', 'createdBy',)
            ->withCount('assets as assets_count', 'licenses as licenses_count', 'accessories as accessories_count', 'consumables as consumables_count');
        $users = Company::scopeCompanyables($users);


        if (($request->filled('deleted')) && ($request->input('deleted') == 'true')) {
            $users = $users->onlyTrashed();
        } elseif (($request->filled('all')) && ($request->input('all') == 'true')) {
            $users = $users->withTrashed();
        }

        if ($request->filled('activated')) {
            $users = $users->where('users.activated', '=', $request->input('activated'));
        }

        if ($request->filled('company_id')) {
            $users = $users->where('users.company_id', '=', $request->input('company_id'));
        }

        if ($request->filled('location_id')) {
            $users = $users->where('users.location_id', '=', $request->input('location_id'));
        }

        if ($request->filled('created_by')) {
            $users = $users->where('users.created_by', '=', $request->input('created_by'));
        }

        if ($request->filled('email')) {
            $users = $users->where('users.email', '=', $request->input('email'));
        }

        if ($request->filled('username')) {
            $users = $users->where('users.username', '=', $request->input('username'));
        }

        if ($request->filled('first_name')) {
            $users = $users->where('users.first_name', '=', $request->input('first_name'));
        }

        if ($request->filled('last_name')) {
            $users = $users->where('users.last_name', '=', $request->input('last_name'));
        }

        if ($request->filled('employee_num')) {
            $users = $users->where('users.employee_num', '=', $request->input('employee_num'));
        }

        if ($request->filled('state')) {
            $users = $users->where('users.state', '=', $request->input('state'));
        }

        if ($request->filled('country')) {
            $users = $users->where('users.country', '=', $request->input('country'));
        }

        if ($request->filled('zip')) {
            $users = $users->where('users.zip', '=', $request->input('zip'));
        }

        if ($request->filled('group_id')) {
            $users = $users->ByGroup($request->get('group_id'));
        }

        if ($request->filled('department_id')) {
            $users = $users->where('users.department_id', '=', $request->input('department_id'));
        }

        if ($request->filled('manager_id')) {
            $users = $users->where('users.manager_id','=',$request->input('manager_id'));
        }

        if ($request->filled('ldap_import')) {
            $users = $users->where('ldap_import', '=', $request->input('ldap_import'));
        }

        if ($request->filled('remote')) {
            $users = $users->where('remote', '=', $request->input('remote'));
        }

        if ($request->filled('start_date')) {
            $users = $users->where('users.start_date', '=', $request->input('start_date'));
        }

        if ($request->filled('end_date')) {
            $users = $users->where('users.end_date', '=', $request->input('end_date'));
        }


        if ($request->filled('assets_count')) {
           $users->has('assets', '=', $request->input('assets_count'));
        }

        if ($request->filled('consumables_count')) {
            $users->has('consumables', '=', $request->input('consumables_count'));
        }

        if ($request->filled('licenses_count')) {
            $users->has('licenses', '=', $request->input('licenses_count'));
        }

        if ($request->filled('accessories_count')) {
            $users->has('accessories', '=', $request->input('accessories_count'));
        }

        if ($request->filled('search')) {
            $users = $users->TextSearch($request->input('search'));
        }

        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $offset = (($users) && (request('offset') > $users->count())) ? 0 : request('offset', 0);

        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($users) && ($request->get('offset') > $users->count())) ? $users->count() : $request->get('offset', 0);

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
            case 'created_by':
                $users = $users->OrderByCreatedBy($order);
                break;
            case 'company':
                $users = $users->OrderCompany($order);
                break;
            default:
                $allowed_columns =
                    [
                        'last_name', 'first_name', 'email', 'jobtitle', 'username', 'employee_num',
                        'assets', 'accessories', 'consumables', 'licenses', 'groups', 'activated', 'created_at',
                        'two_factor_enrolled', 'two_factor_optin', 'last_login', 'assets_count', 'licenses_count',
                        'consumables_count', 'accessories_count', 'phone', 'address', 'city', 'state',
                        'country', 'zip', 'id', 'ldap_import', 'remote', 'start_date', 'end_date',
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
            if ($user->last_name != '') {
                $name_str .= $user->last_name.', ';
            }
            $name_str .= $user->first_name;

            if ($user->username != '') {
                $name_str .= ' ('.$user->username.')';
            }

            if ($user->employee_num != '') {
                $name_str .= ' - #'.$user->employee_num;
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

        if ($request->has('permissions')) {
            $permissions_array = $request->input('permissions');

            // Strip out the superuser permission if the API user isn't a superadmin
            if (! Auth::user()->isSuperUser()) {
                unset($permissions_array['superuser']);
            }
            $user->permissions = $permissions_array;
        }

        $tmp_pass = substr(str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 20);
        $user->password = bcrypt($request->get('password', $tmp_pass));

        app('App\Http\Requests\ImageUploadRequest')->handleImages($user, 600, 'image', 'avatars', 'avatar');
        
        if ($user->save()) {
            if ($request->filled('groups')) {
                $user->groups()->sync($request->input('groups'));
            } else {
                $user->groups()->sync([]);
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
        $user = User::withCount('assets as assets_count', 'licenses as licenses_count', 'accessories as accessories_count', 'consumables as consumables_count')->findOrFail($id);

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

        /**
         * This is a janky hack to prevent people from changing admin demo user data on the public demo.
         * 
         * The $ids 1 and 2 are special since they are seeded as superadmins in the demo seeder.
         * 
         *  Thanks, jerks. You are why we can't have nice things. - snipe
         * 
         */ 


        if ((($id == 1) || ($id == 2)) && (config('app.lock_passwords'))) {
            return response()->json(Helper::formatStandardApiResponse('error', null, 'Permission denied. You cannot update user information via API on the demo.'));
        }


        $user->fill($request->all());
        
        if ($user->id == $request->input('manager_id')) {
            return response()->json(Helper::formatStandardApiResponse('error', null, 'You cannot be your own manager'));
        }

        if ($request->filled('password')) {
            $user->password = bcrypt($request->input('password'));
        }

        // We need to use has()  instead of filled()
        // here because we need to overwrite permissions
        // if someone needs to null them out
        if ($request->has('permissions')) {
            $permissions_array = $request->input('permissions');

            // Strip out the superuser permission if the API user isn't a superadmin
            if (! Auth::user()->isSuperUser()) {
                unset($permissions_array['superuser']);
            }
            $user->permissions = $permissions_array;
        }



        // Update the location of any assets checked out to this user
        Asset::where('assigned_type', User::class)
            ->where('assigned_to', $user->id)->update(['location_id' => $request->input('location_id', null)]);

        
        app('App\Http\Requests\ImageUploadRequest')->handleImages($user, 600, 'image', 'avatars', 'avatar');
          
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
            } elseif ($request->has('groups')) {
                $user->groups()->sync([]);
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
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/users/message.error.delete_has_assets')));
        }

        if (($user->licenses) && ($user->licenses->count() > 0)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, 'This user still has '.$user->licenses->count().' license(s) associated with them and cannot be deleted.'));
        }

        if (($user->accessories) && ($user->accessories->count() > 0)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, 'This user still has '.$user->accessories->count().' accessories associated with them.'));
        }

        if (($user->managedLocations()) && ($user->managedLocations()->count() > 0)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, 'This user still has '.$user->managedLocations()->count().' locations that they manage.'));
        }

        if ($user->delete()) {

            // Remove the user's avatar if they have one
            if (Storage::disk('public')->exists('avatars/'.$user->avatar)) {
                try {
                    Storage::disk('public')->delete('avatars/'.$user->avatar);
                } catch (\Exception $e) {
                    \Log::debug($e);
                }
            }

            return response()->json(Helper::formatStandardApiResponse('success', null, trans('admin/users/message.success.delete')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/users/message.error.delete')));
    }

    /**
     * Return JSON containing a list of assets assigned to a user.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @param $userId
     * @return string JSON
     */
    public function assets(Request $request, $id)
    {
        $this->authorize('view', User::class);
        $this->authorize('view', Asset::class);
        $assets = Asset::where('assigned_to', '=', $id)->where('assigned_type', '=', User::class)->with('model')->get();

        return (new AssetsTransformer)->transformAssets($assets, $assets->count(), $request);
    }

    /**
     * Notify a specific user via email with all of their assigned assets.
     *
     * @author [Lukas Fehling] [<lukas.fehling@adabay.rocks>]
     * @since [v6.0.13]
     * @param Request $request
     * @param $id
     * @return string JSON
     */
    public function emailAssetList(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if (empty($user->email)) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/users/message.inventorynotification.error')));
        }
 
        return response()->Helper::formatStandardApiResponse('success', null, trans('admin/users/message.inventorynotification.success'));
 
    }

    /**
     * Return JSON containing a list of consumables assigned to a user.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v3.0]
     * @param $userId
     * @return string JSON
     */
    public function consumables(Request $request, $id)
    {
        $this->authorize('view', User::class);
        $this->authorize('view', Consumable::class);
        $user = User::findOrFail($id);
        $consumables = $user->consumables;
        return (new ConsumablesTransformer)->transformConsumables($consumables, $consumables->count(), $request);
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
        
        if ($user = User::where('id', $id)->withTrashed()->first()) {
            $licenses = $user->licenses()->get();
            return (new LicensesTransformer())->transformLicenses($licenses, $licenses->count());
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/users/message.user_not_found', compact('id'))));

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
        return (new UsersTransformer)->transformUser($request->user());
    }

    /**
     * Restore a soft-deleted user.
     *
     * @author [E. Taylor] [<dev@evantaylor.name>]
     * @param int $userId
     * @since [v6.0.0]
     * @return JsonResponse
     */
    public function restore($userId = null)
    {
        // Get asset information
        $user = User::withTrashed()->find($userId);
        $this->authorize('delete', $user);
        if (isset($user->id)) {
            // Restore the user
            User::withTrashed()->where('id', $userId)->restore();

            return response()->json(Helper::formatStandardApiResponse('success', null, trans('admin/users/message.success.restored')));
        }
        
        $id = $userId;
        return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/users/message.user_not_found', compact('id'))), 200);
    }
}
