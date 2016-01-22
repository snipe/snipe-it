<?php namespace Controllers\Admin;

use AdminController;
use Image;
use AssetMaintenance;
use Input;
use Lang;
use Supplier;
use Redirect;
use Setting;
use Sentry;
use Str;
use Validator;
use View;

use Symfony\Component\HttpFoundation\JsonResponse;


class SuppliersController extends AdminController
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
        return View::make('backend/suppliers/index', compact('suppliers'));
    }


    /**
     * Supplier create.
     *
     * @return View
     */
    public function getCreate()
    {
        return View::make('backend/suppliers/edit')->with('supplier', new Supplier);
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

        // attempt validation
        if ($supplier->validate($new)) {

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
            $supplier->user_id              = Sentry::getId();

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
            if($supplier->save()) {
                // Redirect to the new supplier  page
                return Redirect::to("admin/settings/suppliers")->with('success', Lang::get('admin/suppliers/message.create.success'));
            }
        } else {
            // failure
            $errors = $supplier->errors();
            return Redirect::back()->withInput()->withErrors($errors);
        }

        // Redirect to the supplier create page
        return Redirect::to('admin/settings/suppliers/create')->with('error', Lang::get('admin/suppliers/message.create.error'));

    }

    public function store()
    {
      $supplier=new Supplier;
      $new=Input::all();
      $validator = Validator::make($new, $supplier->validationRules());
      if($validator->fails()) {
        return JsonResponse::create(["error" => "Failed validation: ".print_r($validator->messages()->all('<li>:message</li>'),true)],500);
      } else {
        //$supplier->fill($new);
        $supplier->name=$new['name'];
        $supplier->user_id              = Sentry::getId();

        if($supplier->save()) {
          return JsonResponse::create($supplier);
        } else {
          return JsonResponse::create(["error" => "Couldn't save Supplier"]);
        }
      }
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
        if (is_null($supplier = Supplier::find($supplierId))) {
            // Redirect to the supplier  page
            return Redirect::to('admin/settings/suppliers')->with('error', Lang::get('admin/suppliers/message.does_not_exist'));
        }

        // Show the page
        return View::make('backend/suppliers/edit', compact('supplier'));
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
            return Redirect::to('admin/settings/suppliers')->with('error', Lang::get('admin/suppliers/message.does_not_exist'));
        }


          //attempt to validate
        $validator = Validator::make(Input::all(), $supplier->validationRules($supplierId));

        if ($validator->fails())
        {
            // The given data did not pass validation
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
        // attempt validation
        else {

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
                $supplier->image = NULL;
            }

            // Was it created?
            if($supplier->save()) {
                // Redirect to the new supplier page
                return Redirect::to("admin/settings/suppliers")->with('success', Lang::get('admin/suppliers/message.update.success'));
            }
        }

        // Redirect to the supplier management page
        return Redirect::to("admin/settings/suppliers/$supplierId/edit")->with('error', Lang::get('admin/suppliers/message.update.error'));

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
            return Redirect::to('admin/settings/suppliers')->with('error', Lang::get('admin/suppliers/message.not_found'));
        }

        if ($supplier->num_assets() > 0) {

            // Redirect to the asset management page
            return Redirect::to('admin/settings/suppliers')->with('error', Lang::get('admin/suppliers/message.assoc_users'));
        } else {

            // Delete the supplier
            $supplier->delete();

            // Redirect to the suppliers management page
        return Redirect::to('admin/settings/suppliers')->with('success', Lang::get('admin/suppliers/message.delete.success'));
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
                return View::make('backend/suppliers/view', compact('supplier'));
        } else {
            // Prepare the error message
            $error = Lang::get('admin/suppliers/message.does_not_exist', compact('id'));

            // Redirect to the user management page
            return Redirect::route('suppliers')->with('error', $error);
        }


    }

    public function getDatatable()
    {
        $suppliers = Supplier::select(array('id','name','address','address2','city','state','country','fax', 'phone','email','contact'))
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

        foreach($suppliers as $supplier) {
            $actions = '<a href="'.route('update/supplier', $supplier->id).'" class="btn btn-warning btn-sm" style="margin-right:5px;"><i class="fa fa-pencil icon-white"></i></a><a data-html="false" class="btn delete-asset btn-danger btn-sm" data-toggle="modal" href="'.route('delete/supplier', $supplier->id).'" data-content="'.Lang::get('admin/suppliers/message.delete.confirm').'" data-title="'.Lang::get('general.delete').' '.htmlspecialchars($supplier->name).'?" onClick="return false;"><i class="fa fa-trash icon-white"></i></a>';

            $rows[] = array(
                'id'                => $supplier->id,
                'name'              => link_to('admin/settings/suppliers/'.$supplier->id.'/view', $supplier->name),
                'contact'           => $supplier->contact,
                'address'           => $supplier->address.' '.$supplier->address2.' '.$supplier->city.' '.$supplier->state.' '.$supplier->country,
                'phone'             => $supplier->phone,
                'fax'             => $supplier->fax,
                'email'             => ($supplier->email!='') ? '<a href="mailto:'.$supplier->email.'">'.$supplier->email.'</a>' : '',
                'assets'            => $supplier->num_assets(),
                'licenses'          => $supplier->num_licenses(),
                'actions'           => $actions
            );
        }

        $data = array('total' => $suppliersCount, 'rows' => $rows);

        return $data;

    }



}
