<?php namespace Controllers\Account;

use AuthorizedController;
use Image;
use Input;
use Redirect;
use Sentry;
use Validator;
use Location;
use View;

class ProfileController extends AuthorizedController
{
    /**
     * User profile page.
     *
     * @return View
     */
    public function getIndex()
    {
        // Get the user information
        $user = Sentry::getUser();

        // Show the page

        $location_list = array('' => 'Select One') + Location::lists('name', 'id');

        // Show the page
        return View::make('frontend/account/profile', compact('user'))->with('location_list',$location_list);
    }

    /**
     * User profile form processing page.
     *
     * @return Redirect
     */
    public function postIndex()
    {
        // Declare the rules for the form validation
        $rules = array(
            'first_name' => 'required|alpha_space|min:2',
            'last_name'  => 'required|alpha_space|min:2',
            'location_id'  => 'required',
            'website'    => 'url|alpha_space|min:10',
            'gravatar'   => 'email',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        // Grab the user
        $user = Sentry::getUser();

        // Update the user information
        $user->first_name = Input::get('first_name');
        $user->last_name  = Input::get('last_name');
        $user->website    = Input::get('website');
        $user->location_id    = Input::get('location_id');
        $user->gravatar   = Input::get('gravatar');
		
		if (Input::file('avatar')) {
            $image = Input::file('avatar');
            $file_name = $user->first_name."-".$user->last_name.".".$image->getClientOriginalExtension();
            $path = public_path('uploads/avatars/'.$file_name);
            Image::make($image->getRealPath())->resize(84, 84)->save($path);
            $user->avatar = $file_name;
        }

        if (Input::get('avatar_delete') == 1 && Input::file('avatar') == "") {
            $user->avatar = NULL;
        }
		
        $user->save();

        // Redirect to the settings page
        return Redirect::route('profile')->with('success', 'Account successfully updated');
    }

}
