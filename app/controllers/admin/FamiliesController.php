<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Family;
use Redirect;
use Setting;
use DB;
use Sentry;
use Str;
use Validator;
use View;

class FamiliesController extends AdminController
{
    /**
     * Show a list of all the families.
     *
     * @return View
     */

    public function getIndex()
    {
        // Grab all the families
        $families = Family::orderBy('created_at', 'DESC')->paginate(Setting::getSettings()->per_page);

        // Show the page
        return View::make('backend/families/index', compact('families'));
    }


    /**
     * Family create.
     *
     * @return View
     */
    public function getCreate()
    {
        // Show the page
        $family_options = array('0' => 'Top Level') + Family::lists('name', 'id', 'common_name', 'notes');
        return View::make('backend/families/edit')->with('family_options',$family_options)->with('family',new Family);
    }


    /**
     * Family create form processing.
     *
     * @return Redirect
     */
    public function postCreate()
    {

        // get the POST data
        $new = Input::all();

        // create a new family instance
        $family = new Family();

        // attempt validation
        if ($family->validate($new)) {

            // Save the family data
            $family->name            	= e(Input::get('name'));
            $family->common_name	= e(Input::get('common_name'));
            $family->notes		= e(Input::get('notes'));
            $family->user_id            = Sentry::getId();

            // Was the family created?
            if($family->save()) {
                // Redirect to the new family  page
                return Redirect::to("admin/settings/families")->with('success', Lang::get('admin/families/message.create.success'));
            }
        } else {
            // failure
            $errors = $family->errors();
            return Redirect::back()->withInput()->withErrors($errors);
        }

        // Redirect to the family create page
        return Redirect::to('admin/settings/families/create')->with('error', Lang::get('admin/families/message.create.error'));

    }


    /**
     * Family update.
     *
     * @param  int  $familyId
     * @return View
     */
    public function getEdit($familyId = null)
    {
        // Check if the family exists
        if (is_null($family = Family::find($familyId))) {
            // Redirect to the blogs management page
            return Redirect::to('admin/settings/families')->with('error', Lang::get('admin/families/message.does_not_exist'));
        }

        // Show the page
        $family_options = array('' => 'Top Level') + DB::table('families')->where('id', '!=', $familyId)->lists('name', 'id', 'common_name', 'notes');
        return View::make('backend/families/edit', compact('family'))->with('family_options',$family_options);
    }


    /**
     * Family update form processing page.
     *
     * @param  int  $familyId
     * @return Redirect
     */
    public function postEdit($familyId = null)
    {
        // Check if the family exists
        if (is_null($family = Family::find($familyId))) {
            // Redirect to the error page
            return Redirect::to('admin/settings/families')->with('error', Lang::get('admin/families/message.does_not_exist'));
        }

        //attempt to validate
        $validator = Validator::make(Input::all(), $family->validationRules($familyId));

        if ($validator->fails())
        {
            // The given data did not pass validation            
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
        // attempt validation
        else {

            // Update the family data
            $family->name            	= e(Input::get('name'));
            $family->common_name	= e(Input::get('common_name'));
            $family->notes		= e(Input::get('notes'));
            $family->user_id            = Sentry::getId();

            // Was the family created?
            if($family->save()) {
                // Redirect to the saved family page
                return Redirect::to("admin/settings/families/")->with('success', Lang::get('admin/families/message.update.success'));
            }
        } 

        // Redirect to the error page
        return Redirect::to("admin/settings/families/$familyId/edit")->with('error', Lang::get('admin/families/message.update.error'));

    }

    /**
     * Delete the given family.
     *
     * @param  int  $familyId
     * @return Redirect
     */
    public function getDelete($familyId)
    {
        // Check if the family exists
        if (is_null($family = Family::find($familyId))) {
            // Redirect to the error page
            return Redirect::to('admin/settings/families')->with('error', Lang::get('admin/families/message.not_found'));
        }


        if ($family->has_licenses() > 0) {
            // Redirect to the error page
            return Redirect::to('admin/settings/families')->with('error', Lang::get('admin/families/message.assoc_locations'));
        } else {

            $family->delete();

            // Redirect to the error page
            return Redirect::to('admin/settings/families')->with('success', Lang::get('admin/families/message.delete.success'));
        }



    }



}