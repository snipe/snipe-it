<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Entity;
use Redirect;
use Setting;
use DB;
use Sentry;
use Str;
use Validator;
use View;

class EntitiesController extends AdminController
{
    /**
     * Show a list of all the entities.
     *
     * @return View
     */

    public function getIndex()
    {
        // Grab all the entities
        $entities = Entity::orderBy('created_at', 'DESC')->paginate(Setting::getSettings()->per_page);

        // Show the page
        return View::make('backend/entities/index', compact('entities'));
    }


    /**
     * Entity create.
     *
     * @return View
     */
    public function getCreate()
    {
        // Show the page
        $entity_options = array('0' => 'Top Level') + Entity::lists('name', 'id', 'common_name', 'notes');
        return View::make('backend/entities/edit')->with('entity_options',$entity_options)->with('entity',new Entity);
    }


    /**
     * Entity create form processing.
     *
     * @return Redirect
     */
    public function postCreate()
    {

        // get the POST data
        $new = Input::all();

        // create a new entity instance
        $entity = new Entity();

        // attempt validation
        if ($entity->validate($new)) {

            // Save the entity data
            $entity->name            	= e(Input::get('name'));
            $entity->common_name	= e(Input::get('common_name'));
            $entity->notes		= e(Input::get('notes'));
            $entity->user_id            = Sentry::getId();

            // Was the entity created?
            if($entity->save()) {
                // Redirect to the new entity  page
                return Redirect::to("admin/settings/entities")->with('success', Lang::get('admin/entities/message.create.success'));
            }
        } else {
            // failure
            $errors = $entity->errors();
            return Redirect::back()->withInput()->withErrors($errors);
        }

        // Redirect to the entity create page
        return Redirect::to('admin/settings/entities/create')->with('error', Lang::get('admin/entities/message.create.error'));

    }


    /**
     * Entity update.
     *
     * @param  int  $entityId
     * @return View
     */
    public function getEdit($entityId = null)
    {
        // Check if the entity exists
        if (is_null($entity = Entity::find($entityId))) {
            // Redirect to the blogs management page
            return Redirect::to('admin/settings/entities')->with('error', Lang::get('admin/entities/message.does_not_exist'));
        }

        // Show the page
        $entity_options = array('' => 'Top Level') + DB::table('entities')->where('id', '!=', $entityId)->lists('name', 'id', 'common_name', 'notes');
        return View::make('backend/entities/edit', compact('entity'))->with('entity_options',$entity_options);
    }


    /**
     * Entity update form processing page.
     *
     * @param  int  $entityId
     * @return Redirect
     */
    public function postEdit($entityId = null)
    {
        // Check if the entity exists
        if (is_null($entity = Entity::find($entityId))) {
            // Redirect to the error page
            return Redirect::to('admin/settings/entities')->with('error', Lang::get('admin/entities/message.does_not_exist'));
        }

        //attempt to validate
        $validator = Validator::make(Input::all(), $entity->validationRules($entityId));

        if ($validator->fails())
        {
            // The given data did not pass validation            
            return Redirect::back()->withInput()->withErrors($validator->messages());
        }
        // attempt validation
        else {

            // Update the entity data
            $entity->name            	= e(Input::get('name'));
            $entity->common_name	= e(Input::get('common_name'));
            $entity->notes		= e(Input::get('notes'));
            $entity->user_id            = Sentry::getId();

            // Was the entity created?
            if($entity->save()) {
                // Redirect to the saved entity page
                return Redirect::to("admin/settings/entities/")->with('success', Lang::get('admin/entities/message.update.success'));
            }
        } 

        // Redirect to the error page
        return Redirect::to("admin/settings/entities/$entityId/edit")->with('error', Lang::get('admin/entities/message.update.error'));

    }

    /**
     * Delete the given entity.
     *
     * @param  int  $entityId
     * @return Redirect
     */
    public function getDelete($entityId)
    {
        // Check if the entity exists
        if (is_null($entity = Entity::find($entityId))) {
            // Redirect to the error page
            return Redirect::to('admin/settings/entities')->with('error', Lang::get('admin/entities/message.not_found'));
        }


        if ($entity->has_locations() > 0) {

            // Redirect to the error page
            return Redirect::to('admin/settings/entities')->with('error', Lang::get('admin/entities/message.assoc_locations'));
        } else {

            $entity->delete();

            // Redirect to the error page
            return Redirect::to('admin/settings/entities')->with('success', Lang::get('admin/entities/message.delete.success'));
        }



    }
    
    public function getView($entityId)
    {
        // Check if the entity exists
        if (is_null($entity = Entity::find($entityId))) {
            // Redirect to the error page
            return Redirect::to('admin/settings/entities')->with('error', Lang::get('admin/entities/message.not_found'));
        }
        
        return View::make('backend/entities/view', compact('entity'));
    }
}