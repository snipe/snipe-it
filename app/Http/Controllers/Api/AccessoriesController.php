<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Models\Accessory;
use App\Http\Transformers\AccessoriesTransformer;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Auth;
use DB;

class AccessoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('view', Accessory::class);
        $allowed_columns = ['id','name','model_number','eol','notes','created_at','min_amt','company_id'];

        $accessories = Accessory::with('category', 'company', 'manufacturer', 'users', 'location');

        if ($request->filled('search')) {
            $accessories = $accessories->TextSearch($request->input('search'));
        }

        if ($request->filled('company_id')) {
            $accessories->where('company_id','=',$request->input('company_id'));
        }

        if ($request->filled('category_id')) {
            $accessories->where('category_id','=',$request->input('category_id'));
        }

        if ($request->filled('manufacturer_id')) {
            $accessories->where('manufacturer_id','=',$request->input('manufacturer_id'));
        }

        if ($request->filled('supplier_id')) {
            $accessories->where('supplier_id','=',$request->input('supplier_id'));
        }

        // Set the offset to the API call's offset, unless the offset is higher than the actual count of items in which
        // case we override with the actual count, so we should return 0 items.
        $offset = (($accessories) && ($request->get('offset') > $accessories->count())) ? $accessories->count() : $request->get('offset', 0);

        // Check to make sure the limit is not higher than the max allowed
        ((config('app.max_results') >= $request->input('limit')) && ($request->filled('limit'))) ? $limit = $request->input('limit') : $limit = config('app.max_results');


        $order = $request->input('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array($request->input('sort'), $allowed_columns) ? $request->input('sort') : 'created_at';

        switch ($sort) {
            case 'category':
                $accessories = $accessories->OrderCategory($order);
                break;
            case 'company':
                $accessories = $accessories->OrderCompany($order);
                break;
            default:
                $accessories = $accessories->orderBy($sort, $order);
                break;
        }

        $accessories->orderBy($sort, $order);

        $total = $accessories->count();
        $accessories = $accessories->skip($offset)->take($limit)->get();
        return (new AccessoriesTransformer)->transformAccessories($accessories, $total);
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
        $this->authorize('create', Accessory::class);
        $accessory = new Accessory;
        $accessory->fill($request->all());

        if ($accessory->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $accessory, trans('admin/accessories/message.create.success')));
        }
        return response()->json(Helper::formatStandardApiResponse('error', null, $accessory->getErrors()));

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
        $this->authorize('view', Accessory::class);
        $accessory = Accessory::findOrFail($id);
        return (new AccessoriesTransformer)->transformAccessory($accessory);
    }


    /**
     * Display the specified resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function accessory_detail($id)
    {
        $this->authorize('view', Accessory::class);
        $accessory = Accessory::findOrFail($id);
        return (new AccessoriesTransformer)->transformAccessory($accessory);
    }


    /**
     * Display the specified resource.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @since [v4.0]
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function checkedout($id)
    {
        $this->authorize('view', Accessory::class);

        $accessory = Accessory::findOrFail($id);
        if (!Company::isCurrentUserHasAccess($accessory)) {
            return ['total' => 0, 'rows' => []];
        }
        $accessory_users = $accessory->users;
        $total = $accessory_users->count();

        return (new AccessoriesTransformer)->transformCheckedoutAccessory($accessory_users, $total);
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
    public function update(Request $request, $id)
    {
        $this->authorize('edit', Accessory::class);
        $accessory = Accessory::findOrFail($id);
        $accessory->fill($request->all());

        if ($accessory->save()) {
            return response()->json(Helper::formatStandardApiResponse('success', $accessory, trans('admin/accessories/message.update.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, $accessory->getErrors()));
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
        $this->authorize('delete', Accessory::class);
        $accessory = Accessory::findOrFail($id);
        $this->authorize($accessory);

        if ($accessory->hasUsers() > 0) {
            return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/accessories/message.assoc_users', array('count'=> $accessory->hasUsers()))));
        }

        $accessory->delete();
        return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/accessories/message.delete.success')));

    }


    /**
     * Save the Accessory checkout information.
     *
     * If Slack is enabled and/or asset acceptance is enabled, it will also
     * trigger a Slack message and send an email.
     *
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param  int  $accessoryId
     * @return Redirect
     */
    public function checkout(Request $request, $accessoryId)
    {
        // Check if the accessory exists
        if (is_null($accessory = Accessory::find($accessoryId))) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/accessories/message.does_not_exist')));
        }

        $this->authorize('checkout', $accessory);


        if ($accessory->numRemaining() > 0) {

            if (!$user = User::find($request->input('assigned_to'))) {
                return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/accessories/message.checkout.user_does_not_exist')));
            }

            // Update the accessory data
            $accessory->assigned_to = $request->input('assigned_to');

            $accessory->users()->attach($accessory->id, [
                'accessory_id' => $accessory->id,
                'created_at' => Carbon::now(),
                'user_id' => Auth::id(),
                'assigned_to' => $request->get('assigned_to')
            ]);

            $accessory->logCheckout($request->input('note'), $user);

            return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/accessories/message.checkout.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null, 'No accessories remaining'));

    }

    /**
     * Check in the item so that it can be checked out again to someone else
     *
     * @uses Accessory::checkin_email() to determine if an email can and should be sent
     * @author [A. Gianotto] [<snipe@snipe.net>]
     * @param Request $request
     * @param integer $accessoryUserId
     * @param string $backto
     * @return Redirect
     * @internal param int $accessoryId
     */
    public function checkin(Request $request, $accessoryUserId = null)
    {
        if (is_null($accessory_user = DB::table('accessories_users')->find($accessoryUserId))) {
            return response()->json(Helper::formatStandardApiResponse('error', null, trans('admin/accessories/message.does_not_exist')));
        }

        $accessory = Accessory::find($accessory_user->accessory_id);
        $this->authorize('checkin', $accessory);

        $logaction = $accessory->logCheckin(User::find($accessoryUserId), $request->input('note'));

        // Was the accessory updated?
        if (DB::table('accessories_users')->where('id', '=', $accessory_user->id)->delete()) {
            if (!is_null($accessory_user->assigned_to)) {
                $user = User::find($accessory_user->assigned_to);
            }

            $data['log_id'] = $logaction->id;
            $data['first_name'] = $user->first_name;
            $data['last_name'] = $user->last_name;
            $data['item_name'] = $accessory->name;
            $data['checkin_date'] = $logaction->created_at;
            $data['item_tag'] = '';
            $data['note'] = $logaction->note;

            return response()->json(Helper::formatStandardApiResponse('success', null,  trans('admin/accessories/message.checkin.success')));
        }

        return response()->json(Helper::formatStandardApiResponse('error', null,  trans('admin/accessories/message.checkin.error')));

    }

}
