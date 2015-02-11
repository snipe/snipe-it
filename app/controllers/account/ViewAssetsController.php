<?php namespace Controllers\Account;

use AuthorizedController;
use Input;
use Redirect;
use Sentry;
use Validator;
use Location;
use View;
use Asset;

class ViewAssetsController extends AuthorizedController
{
    /**
     * Redirect to the profile page.
     *
     * @return Redirect
     */
    public function getIndex()
    {
    	$user = Sentry::getUser();


            if (isset($user->id)) {
                return View::make('frontend/account/view-assets', compact('user'));
            } else {
                // Prepare the error message
                $error = Lang::get('admin/users/message.user_not_found', compact('id' ));

                // Redirect to the user management page
                return Redirect::route('users')->with('error', $error);
            }

	}


	public function getRequestableIndex() {

		$assets = Asset::with('model','defaultLoc')->Hardware()->Requestable()->get();
        return View::make('frontend/account/requestable-assets', compact('user','assets'));
    }


    public function getRequestAsset($assetId = null) {

    	// Check if the asset exists
        if (is_null($asset = Asset::find($assetId))) {
            // Redirect to the asset management page
            return Redirect::to('hardware')->with('error', Lang::get('admin/hardware/message.does_not_exist'));
        } else {


			 //return View::make('frontend/account/view-asset', compact('asset'));
        }


    }


}
