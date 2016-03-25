<?php
namespace App\Http\Controllers;

use Image;
use Input;
use Redirect;
use App\Models\Location;
use View;
use Auth;
use App\Helpers\Helper;

class ProfileController extends Controller
{
    /**
     * User profile page.
     *
     * @return View
     */
    public function getIndex()
    {
        // Get the user information
        $user = Auth::user();
        $location_list = Helper::locationsList();
        return View::make('account/profile', compact('user'))->with('location_list', $location_list);
    }

    /**
     * User profile form processing page.
     *
     * @return Redirect
     */
    public function postIndex()
    {

      // Grab the user
        $user = Auth::user();

      // Update the user information
        $user->first_name = Input::get('first_name');
        $user->last_name  = Input::get('last_name');
        $user->website    = Input::get('website');
        $user->location_id    = Input::get('location_id');
        $user->gravatar   = Input::get('gravatar');
        $user->locale = Input::get('locale');

        if (Input::file('avatar')) {
            $image = Input::file('avatar');
            $file_name = $user->first_name."-".$user->last_name.".".$image->getClientOriginalExtension();
            $path = public_path('uploads/avatars/'.$file_name);
            Image::make($image->getRealPath())->resize(84, 84)->save($path);
            $user->avatar = $file_name;
        }

        if (Input::get('avatar_delete') == 1 && Input::file('avatar') == "") {
            $user->avatar = null;
        }

        if ($user->save()) {
            return Redirect::route('profile')->with('success', 'Account successfully updated');
        }
        return Redirect::back()->withInput()->withErrors($user->getErrors());
    }
}
