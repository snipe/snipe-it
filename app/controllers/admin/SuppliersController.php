<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Supplier;
use Redirect;
use Setting;
use Sentry;
use Str;
use Validator;
use View;

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
            $supplier->name            		= e(Input::get('name'));
            $supplier->address          	= e(Input::get('address'));
            $supplier->address2          	= e(Input::get('address2'));
            $supplier->city          		= e(Input::get('city'));
            $supplier->state          		= e(Input::get('state'));
            $supplier->country          	= e(Input::get('country'));
            $supplier->zip          		= e(Input::get('zip'));
            $supplier->contact          	= e(Input::get('contact'));
            $supplier->phone          		= e(Input::get('phone'));
            $supplier->fax         	 		= e(Input::get('fax'));
            $supplier->email          		= e(Input::get('email'));
            $supplier->notes          		= e(Input::get('notes'));
            $supplier->url          		= $supplier->addhttp(e(Input::get('url')));
            $supplier->user_id          	= Sentry::getId();

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
            $supplier->name            		= e(Input::get('name'));
            $supplier->address          	= e(Input::get('address'));
            $supplier->address2          	= e(Input::get('address2'));
            $supplier->city          		= e(Input::get('city'));
            $supplier->state          		= e(Input::get('state'));
            $supplier->country          	= e(Input::get('country'));
            $supplier->zip          		= e(Input::get('zip'));
            $supplier->contact          	= e(Input::get('contact'));
            $supplier->phone          		= e(Input::get('phone'));
            $supplier->fax          		= e(Input::get('fax'));
            $supplier->email          		= e(Input::get('email'));
            $supplier->url          		= $supplier->addhttp(e(Input::get('url')));
            $supplier->notes          		= e(Input::get('notes'));


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



}
