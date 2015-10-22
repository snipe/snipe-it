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

    public function assets()
    {
        return $this->hasMany('Asset', 'assigned_to')->withTrashed();
    }

    public function accessories()
    {
        return $this->belongsToMany('Accessory', 'accessories_users', 'assigned_to','accessory_id')->withPivot('id')->withTrashed();
    }

    public function consumables()
   {
       return $this->belongsToMany('Consumable', 'consumables_users', 'assigned_to','consumable_id')->withPivot('id')->withTrashed();
   }

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
                $query->where('first_name', 'LIKE', "%$search%")
                ->orWhere('last_name', 'LIKE', "%$search%")
                ->orWhere('email', 'LIKE', "%$search%")
                ->orWhere('username', 'LIKE', "%$search%")
                ->orWhere('notes', 'LIKE', "%$search%")
                ->orWhere(function($query) use ($search) {
                    $query->whereHas('userloc', function($query) use ($search) {
                        $query->where('name','LIKE','%'.$search.'%');
                    });
                })

                // This doesn't actually work - need to use a table alias maybe?
                ->orWhere(function($query) use ($search) {
                    $query->whereHas('manager', function($query) use ($search) {
                        $query->where(function($query) use ($search) {
                            $query->where('first_name','LIKE','%'.$search.'%')
                            ->orWhere('last_name','LIKE','%'.$search.'%');
                        });
                    });
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


}
