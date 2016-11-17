<?php
namespace App\Http\Controllers;

use Image;
use App\Models\AssetMaintenance;
use Input;
use Lang;
use App\Models\Supplier;
use Redirect;
use App\Models\Setting;
use Str;
use View;
use Auth;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * This controller handles all actions related to Suppliers for
 * the Snipe-IT Asset Management application.
 *
 * @version    v1.0
 */
class SuppliersController extends Controller
{
    /**
     * Show a list of all suppliers
     *
     * @return View
     */
    public function getIndex()
    {
        // Grab all the suppliers
        $suppliers = Supplier::orderBy('created_at', 'DESC')->get();

        // Show the page
        return View::make('suppliers/index', compact('suppliers'));
    }


    /**
     * Supplier create.
     *
     * @return View
     */
    public function getCreate()
    {
        return View::make('suppliers/edit')->with('item', new Supplier);
    }


    /**
     * Supplier create form processing.
     *
     * @return Redirect
     */
    public function postCreate()
    {

        // get the POST data
        $new = Input::all();

        // Create a new supplier
        $supplier = new Supplier;
        // Save the location data
        $supplier->name                 = e(Input::get('name'));
        $supplier->address              = e(Input::get('address'));
        $supplier->address2             = e(Input::get('address2'));
        $supplier->city                 = e(Input::get('city'));
        $supplier->state                = e(Input::get('state'));
        $supplier->country              = e(Input::get('country'));
        $supplier->zip                  = e(Input::get('zip'));
        $supplier->contact              = e(Input::get('contact'));
        $supplier->phone                = e(Input::get('phone'));
        $supplier->fax                  = e(Input::get('fax'));
        $supplier->email                = e(Input::get('email'));
        $supplier->notes                = e(Input::get('notes'));
        $supplier->url                  = $supplier->addhttp(e(Input::get('url')));
        $supplier->user_id              = Auth::user()->id;




        if (Input::file('image')) {
            $image = Input::file('image');
            $file_name = str_random(25).".".$image->getClientOriginalExtension();
            $path = public_path('uploads/suppliers/'.$file_name);
            Image::make($image->getRealPath())->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path);
                $supplier->image = $file_name;
        }

            // Was it created?
        if ($supplier->save()) {
          // Redirect to the new supplier  page
            return redirect()->to("admin/settings/suppliers")->with('success', trans('admin/suppliers/message.create.success'));
        }


        return redirect()->back()->withInput()->withErrors($supplier->getErrors());

    }

    public function store(Request $request)
    {
        $supplier = new Supplier;
        $supplier->name =  e($request->input('name'));
        $supplier->user_id              = Auth::user()->id;

        if ($supplier->save()) {
            return JsonResponse::create($supplier);
        }
        return JsonResponse::create(["error" => "Failed validation: ".print_r($supplier->getErrors(), true)], 500);
        return JsonResponse::create(["error" => "Couldn't save Supplier"]);
    }

    /**
     * Supplier update.
     *
     * @param  int  $supplierId
     * @return View
     */
    public function getEdit($supplierId = null)
    {
        // Check if the supplier exists
        if (is_null($item = Supplier::find($supplierId))) {
            // Redirect to the supplier  page
            return redirect()->to('admin/settings/suppliers')->with('error', trans('admin/suppliers/message.does_not_exist'));
        }

        // Show the page
        return View::make('suppliers/edit', compact('item'));
    }


    /**
     * Supplier update form processing page.
     *
     * @param  int  $supplierId
     * @return Redirect
     */
    public function postEdit($supplierId = null)
    {
        // Check if the supplier exists
        if (is_null($supplier = Supplier::find($supplierId))) {
            // Redirect to the supplier  page
            return redirect()->to('admin/settings/suppliers')->with('error', trans('admin/suppliers/message.does_not_exist'));
        }

        // Save the  data
        $supplier->name                 = e(Input::get('name'));
        $supplier->address              = e(Input::get('address'));
        $supplier->address2             = e(Input::get('address2'));
        $supplier->city                 = e(Input::get('city'));
        $supplier->state                = e(Input::get('state'));
        $supplier->country              = e(Input::get('country'));
        $supplier->zip                  = e(Input::get('zip'));
        $supplier->contact              = e(Input::get('contact'));
        $supplier->phone                = e(Input::get('phone'));
        $supplier->fax                  = e(Input::get('fax'));
        $supplier->email                = e(Input::get('email'));
        $supplier->url                  = $supplier->addhttp(e(Input::get('url')));
        $supplier->notes                = e(Input::get('notes'));

        if (Input::file('image')) {
            $image = Input::file('image');
            $file_name = str_random(25).".".$image->getClientOriginalExtension();
            $path = public_path('uploads/suppliers/'.$file_name);
            Image::make($image->getRealPath())->resize(300, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path);
            $supplier->image = $file_name;
        }

        if (Input::get('image_delete') == 1 && Input::file('image') == "") {
            $supplier->image = null;
        }

        if ($supplier->save()) {
            return redirect()->to("admin/settings/suppliers")->with('success', trans('admin/suppliers/message.update.success'));
        }

        return redirect()->back()->withInput()->withErrors($supplier->getErrors());

    }

    /**
     * Delete the given supplier.
     *
     * @param  int  $supplierId
     * @return Redirect
     */
    public function getDelete($supplierId)
    {
        // Check if the supplier exists
        if (is_null($supplier = Supplier::find($supplierId))) {
            // Redirect to the suppliers page
            return redirect()->to('admin/settings/suppliers')->with('error', trans('admin/suppliers/message.not_found'));
        }

        if ($supplier->num_assets() > 0) {

            // Redirect to the asset management page
            return redirect()->to('admin/settings/suppliers')->with('error', trans('admin/suppliers/message.assoc_users'));
        } else {

            // Delete the supplier
            $supplier->delete();

            // Redirect to the suppliers management page
            return redirect()->to('admin/settings/suppliers')->with('success', trans('admin/suppliers/message.delete.success'));
        }

    }


    /**
    *  Get the asset information to present to the supplier view page
    *
    * @param  int  $assetId
    * @return View
    **/
    public function getView($supplierId = null)
    {
        $supplier = Supplier::find($supplierId);

        if (isset($supplier->id)) {
                return View::make('suppliers/view', compact('supplier'));
        } else {
            // Prepare the error message
            $error = trans('admin/suppliers/message.does_not_exist', compact('id'));

            // Redirect to the user management page
            return redirect()->route('suppliers')->with('error', $error);
        }


    }

    public function getDatatable()
    {
        $suppliers = Supplier::with('assets', 'licenses')->select(array('id','name','address','address2','city','state','country','fax', 'phone','email','contact'))
        ->whereNull('deleted_at');

        if (Input::has('search')) {
            $suppliers = $suppliers->TextSearch(e(Input::get('search')));
        }

        if (Input::has('offset')) {
            $offset = e(Input::get('offset'));
        } else {
            $offset = 0;
        }

        if (Input::has('limit')) {
            $limit = e(Input::get('limit'));
        } else {
            $limit = 50;
        }

        $allowed_columns = ['id','name','address','phone','contact','fax','email'];
        $order = Input::get('order') === 'asc' ? 'asc' : 'desc';
        $sort = in_array(Input::get('sort'), $allowed_columns) ? Input::get('sort') : 'created_at';

        $suppliers->orderBy($sort, $order);

        $suppliersCount = $suppliers->count();
        $suppliers = $suppliers->skip($offset)->take($limit)->get();

        $rows = array();

        foreach ($suppliers as $supplier) {
            $actions = '<a href="'.route('update/supplier', $supplier->id).'" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a><a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/supplier', $supplier->id).'" data-content="'.trans('admin/suppliers/message.delete.confirm').'" data-title="'.trans('general.delete').' '.htmlspecialchars($supplier->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';

            $rows[] = array(
                'id'                => $supplier->id,
                'name'              => (string)link_to('admin/settings/suppliers/'.$supplier->id.'/view', e($supplier->name)),
                'contact'           => e($supplier->contact),
                'address'           => e($supplier->address).' '.e($supplier->address2).' '.e($supplier->city).' '.e($supplier->state).' '.e($supplier->country),
                'phone'             => e($supplier->phone),
                'fax'             => e($supplier->fax),
                'email'             => ($supplier->email!='') ? '<a href="mailto:'.e($supplier->email).'">'.e($supplier->email).'</a>' : '',
                'assets'            => $supplier->assets->count(),
                'licenses'          => $supplier->licenses->count(),
                'actions'           => $actions
            );
        }

        $data = array('total' => $suppliersCount, 'rows' => $rows);

        return $data;

    }
}
