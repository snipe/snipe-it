<?php namespace Controllers\Admin;

use AdminController;
use Input;
use Lang;
use Depreciation;
use Redirect;
use Setting;
use DB;
use Sentry;
use Str;
use Validator;
use View;

class DepreciationsController extends AdminController {

	/**
	 * Show a list of all the depreciations.
	 *
	 * @return View
	 */

	public function getIndex()
	{
		// Grab all the depreciations
		$depreciations = Depreciation::orderBy('created_at', 'DESC')->paginate(Setting::getSettings()->per_page);

		// Show the page
		return View::make('backend/depreciations/index', compact('depreciations'));
	}


	/**
	 * Depreciation create.
	 *
	 * @return View
	 */
	public function getCreate()
	{
		// Show the page
		$depreciation_options = array('0' => 'Top Level') + Depreciation::lists('name', 'id');
		return View::make('backend/depreciations/edit')->with('depreciation_options',$depreciation_options)->with('depreciation',new Depreciation);
	}


	/**
	 * Depreciation create form processing.
	 *
	 * @return Redirect
	 */
	public function postCreate()
	{

		// get the POST data
		$new = Input::all();

		// create a new instance
		$depreciation = new Depreciation();

		// attempt validation
		if ($depreciation->validate($new))
		{

			// Depreciation data
			$depreciation->name            = e(Input::get('name'));
			$depreciation->months    = e(Input::get('months'));
			$depreciation->user_id          = Sentry::getId();

			// Was the asset created?
			if($depreciation->save())
			{
				// Redirect to the new depreciation  page
				return Redirect::to("admin/settings/depreciations")->with('success', Lang::get('admin/depreciations/message.create.success'));
			}
		}
		else
		{
			// failure
			$errors = $depreciation->errors();
			return Redirect::back()->withInput()->withErrors($errors);
		}

		// Redirect to the depreciation create page
		return Redirect::to('admin/settings/depreciations/create')->with('error', Lang::get('admin/depreciations/message.create.error'));

	}

	/**
	 * Depreciation update.
	 *
	 * @param  int  $depreciationId
	 * @return View
	 */
	public function getEdit($depreciationId = null)
	{
		// Check if the depreciation exists
		if (is_null($depreciation = Depreciation::find($depreciationId)))
		{
			// Redirect to the blogs management page
			return Redirect::to('admin/settings/depreciations')->with('error', Lang::get('admin/depreciations/message.does_not_exist'));
		}

		// Show the page
		//$depreciation_options = array('' => 'Top Level') + Depreciation::lists('name', 'id');

		$depreciation_options = array('' => 'Top Level') + DB::table('depreciations')->where('id', '!=', $depreciationId)->lists('name', 'id');
		return View::make('backend/depreciations/edit', compact('depreciation'))->with('depreciation_options',$depreciation_options);
	}


	/**
	 * Depreciation update form processing page.
	 *
	 * @param  int  $depreciationId
	 * @return Redirect
	 */
	public function postEdit($depreciationId = null)
	{
		// Check if the depreciation exists
		if (is_null($depreciation = Depreciation::find($depreciationId)))
		{
			// Redirect to the blogs management page
			return Redirect::to('admin/settings/depreciations')->with('error', Lang::get('admin/depreciations/message.does_not_exist'));
		}



		// get the POST data
		$new = Input::all();

		// attempt validation
		if ($depreciation->validate($new))
		{

			// Depreciation data
			$depreciation->name            = e(Input::get('name'));
			$depreciation->months    = e(Input::get('months'));

			// Was the asset created?
			if($depreciation->save())
			{
				// Redirect to the depreciation page
				return Redirect::to("admin/settings/depreciations/$depreciationId/edit")->with('success', Lang::get('admin/depreciations/message.update.success'));
			}
		}
		else
		{
			// failure
			$errors = $depreciation->errors();
			return Redirect::back()->withInput()->withErrors($errors);
		}

		// Redirect to the depreciation management page
		return Redirect::to("admin/settings/depreciations/$depreciationId/edit")->with('error', Lang::get('admin/depreciations/message.update.error'));


	}

	/**
	 * Delete the given depreciation.
	 *
	 * @param  int  $depreciationId
	 * @return Redirect
	 */
	public function getDelete($depreciationId)
	{
		// Check if the depreciation exists
		if (is_null($depreciation = Depreciation::find($depreciationId)))
		{
			// Redirect to the blogs management page
			return Redirect::to('admin/settings/depreciations')->with('error', Lang::get('admin/depreciations/message.not_found'));
		}

		if ($depreciation->has_models() > 0) {

			// Redirect to the asset management page
			return Redirect::to('admin/settings/depreciations')->with('error', Lang::get('admin/depreciations/message.assoc_users'));
		} else {

			$depreciation->delete();

			// Redirect to the depreciations management page
			return Redirect::to('admin/settings/depreciations')->with('success', Lang::get('admin/depreciations/message.delete.success'));
		}

	}



}
