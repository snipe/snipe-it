<?php

use Cartalyst\Sentry\Users\Eloquent\User as SentryUserModel;

class User extends SentryUserModel
{
  /**
  * Indicates if the model should soft delete.
  *
  * @var bool
  */
  use SoftDeletingTrait;
	protected $dates = ['deleted_at'];

  // public function __construct()
  // {
  //   $this->setHasher(new \Cartalyst\Sentry\Hashing\BCryptHasher);
  // }


  public function company()
  {
      return $this->belongsTo('Company', 'company_id');
  }


  /**
   * Returns the user full name, it simply concatenates
   * the user first and last name.
   *
   * @return string
   */
  public function fullName()
  {
      return "{$this->first_name} {$this->last_name}";
  }


  /**
   * Returns the user Gravatar image url.
   *
   * @return string
   */
  public function gravatar()
  {
      // Generate the Gravatar hash
      $gravatar = md5(strtolower(trim($this->email)));

      // Return the Gravatar url
      return "//gravatar.com/avatar/{$gravatar}";
  }

  /**
  * Get assets assigned to this user
  */
  public function assets()
  {
      return $this->hasMany('Asset', 'assigned_to')->withTrashed();
  }

  /**
  * Get accessories assigned to this user
  */
  public function accessories()
  {
      return $this->belongsToMany('Accessory', 'accessories_users', 'assigned_to','accessory_id')->withPivot('id')->withTrashed();
  }

  /**
  * Get consumables assigned to this user
  */
  public function consumables()
 {
     return $this->belongsToMany('Consumable', 'consumables_users', 'assigned_to','consumable_id')->withPivot('id')->withTrashed();
 }

 /**
 * Get licenses assigned to this user
 */
  public function licenses()
  {
      return $this->belongsToMany('License', 'license_seats', 'assigned_to', 'license_id')->withPivot('id');
  }

  /**
  * Get action logs for this user
  */
  public function userlog()
  {
      return $this->hasMany('Actionlog','checkedout_to')->orderBy('created_at', 'DESC')->withTrashed();
  }

  /**
  * Get the asset's location based on the assigned user
  **/
  public function userloc()
  {
      return $this->belongsTo('Location','location_id')->withTrashed();
  }

  /**
  * Get the user's manager based on the assigned user
  **/
  public function manager()
  {
      return $this->belongsTo('User','manager_id')->withTrashed();
  }


  public function accountStatus()
  {
      if ($this->sentryThrottle) {
  	    if ($this->sentryThrottle->suspended==1) {
  		 	return 'suspended';
  		} elseif ($this->sentryThrottle->banned==1) {
  		 	return 'banned';
  	 	} else {
  		 	return false;
  	 	}
      } else {
          return false;
      }
  }

  public function assetlog()
  {
      return $this->hasMany('Asset','id')->withTrashed();
  }

  /**
  * Get uploads for this asset
  */
  public function uploads()
  {
      return $this->hasMany('Actionlog','asset_id')
          ->where('asset_type', '=', 'user')
          ->where('action_type', '=', 'uploaded')
          ->whereNotNull('filename')
          ->orderBy('created_at', 'desc');
  }

  public function sentryThrottle() {
    return $this->hasOne('Throttle');
  }

  public function scopeGetDeleted($query)
{
	return $query->withTrashed()->whereNotNull('deleted_at');
}

public function scopeGetNotDeleted($query)
{
	return $query->whereNull('deleted_at');
}

  /**
  * Override the SentryUser getPersistCode method for
  * multiple logins at one time
  **/
  public function getPersistCode()
  {

      if (!Config::get('session.multi_login') || (!$this->persist_code))
      {
          $this->persist_code = $this->getRandomString();

          // Our code got hashed
          $persistCode = $this->persist_code;
          $this->save();
          return $persistCode;
      }
      return $this->persist_code;
  }

  public function scopeMatchEmailOrUsername( $query, $user_username, $user_email )
  {
      return $query->where('email','=',$user_email)
      ->orWhere('username','=',$user_username)
      ->orWhere('username','=',$user_email);
  }


  public static function generateFormattedNameFromFullName($format = 'filastname', $users_name) {
      $name = explode(" ", $users_name);
      $name = str_replace("'", '', $name);
      $first_name = $name[0];
      $email_last_name = '';
      $email_prefix = $first_name;

      // If there is no last name given
      if (!array_key_exists(1, $name)) {
          $last_name='';
          $email_last_name = $last_name;
          $user_username = $first_name;

      // There is a last name given
      } else {

          $last_name = str_replace($first_name,'',$users_name);

          if ($format=='filastname') {
              $email_last_name.=str_replace(' ','',$last_name);
              $email_prefix = $first_name[0].$email_last_name;

          } elseif ($format=='firstname.lastname') {
              $email_last_name.=str_replace(' ','',$last_name);
              $email_prefix = $first_name.'.'.$email_last_name;

          } elseif ($format=='firstname') {
              $email_last_name.=str_replace(' ','',$last_name);
              $email_prefix = $first_name;

          }
      }

      $user_username = $email_prefix;
      $user['first_name'] = $first_name;
      $user['last_name'] = $last_name;
      $user['username'] = strtolower($user_username);

      return $user;


  }

/**
* Query builder scope to search on text
*
* @param  Illuminate\Database\Query\Builder  $query  Query builder instance
* @param  text                              $search    	 Search term
*
* @return Illuminate\Database\Query\Builder          Modified query builder
*/
  public function scopeTextsearch($query, $search)
{

  return $query->where(function($query) use ($search) {
      $query->where('users.first_name', 'LIKE', "%$search%")
      ->orWhere('users.last_name', 'LIKE', "%$search%")
      ->orWhere('users.email', 'LIKE', "%$search%")
      ->orWhere('users.username', 'LIKE', "%$search%")
      ->orWhere('users.notes', 'LIKE', "%$search%")
      ->orWhere('users.employee_num', 'LIKE', "%$search%")
      ->orWhere(function($query) use ($search) {
          $query->whereHas('userloc', function($query) use ($search) {
              $query->where('locations.name','LIKE','%'.$search.'%');
          });
      })

      // Ugly, ugly code because Laravel sucks at self-joins
      ->orWhere(function($query) use ($search) {
          $query->whereRaw("users.manager_id IN (select id from users where first_name LIKE '%".$search."%' OR last_name LIKE '%".$search."%') ");
      });
  });

}


  /**
   * Query builder scope for Deleted users
   *
   * @param  Illuminate\Database\Query\Builder $query Query builder instance
   *
   * @return Illuminate\Database\Query\Builder          Modified query builder
   */

  public function scopeDeleted($query)
  {
      return $query->whereNotNull('deleted_at');
  }


  /**
  * Query builder scope to order on manager
  *
  * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
  * @param  text                              $order    	 Order
  *
  * @return Illuminate\Database\Query\Builder          Modified query builder
  */
  public function scopeOrderManager($query, $order)
  {
    // Left join here, or it will only return results with parents
    return $query->leftJoin('users as manager', 'users.manager_id', '=', 'manager.id')->orderBy('manager.first_name', $order)->orderBy('manager.last_name', $order);
  }

  /**
  * Query builder scope to order on company
  *
  * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
  * @param  text                              $order    	 Order
  *
  * @return Illuminate\Database\Query\Builder          Modified query builder
  */
  public function scopeOrderLocation($query, $order)
  {
    return $query->leftJoin('locations', 'users.location_id', '=', 'locations.id')->orderBy('locations.name', $order);
  }



}
