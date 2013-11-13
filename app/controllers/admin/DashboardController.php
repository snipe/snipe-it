<?php namespace Controllers\Admin;

use AdminController;
use View;

class DashboardController extends AdminController {

	/**
	 * Show the administration dashboard page.
	 *
	 * @return View
	 */
	public function getIndex()
	{
		// Show the page
		return View::make('backend/dashboard');
	}

}
