<?php

class Asset extends Depreciable
{
	use SoftDeletingTrait;
	use CompanyableTrait;

    protected $dates = ['deleted_at'];
    protected $table = 'assets';
    protected $errors;
    protected $rules = [
      'name'            => 'alpha_space|min:2|max:255',
      'model_id'        => 'required',
      'status_id'       => 'required',
      'company_id'      => 'integer',
      'warranty_months' => 'integer|min:0|max:240',
      'note'            => 'alpha_space',
      'notes'           => 'alpha_space',
      'physical'         => 'integer',
      'checkout_date'   => 'date|max:10|min:10',
      'checkin_date'    => 'date|max:10|min:10',
      'supplier_id'     => 'integer',
      'asset_tag'       => 'required|alpha_space|min:2|max:255|unique:assets,asset_tag,{id},id,deleted_at,NULL',
      'status'          => 'integer',
    ];

    public function company()
    {
        return $this->belongsTo('Company', 'company_id');
    }


    /**
    * Checkout asset
    */
    public function checkOutToUser($user, $admin, $checkout_at = null, $expected_checkin = null, $note = null, $name = null) {

		if ($expected_checkin) {
			$this->expected_checkin = $expected_checkin ;
		}

		$this->last_checkout = $checkout_at;

            $this->assigneduser()->associate($user);
            $this->name = $name;

            $settings = Setting::getSettings();

            if($this->requireAcceptance()) {
              $this->accepted="pending";
            }

            if($this->save()) {

                $log_id = $this->createCheckoutLog($checkout_at, $admin, $user, $expected_checkin, $note);

                if ((($this->requireAcceptance()=='1')  || ($this->getEula())) && ($user->email!='')) {
                    $this->checkOutNotifyMail($log_id, $user, $checkout_at, $expected_checkin, $note);
                }

                if ($settings->slack_endpoint) {
                    $this->checkOutNotifySlack($settings, $admin, $note);
                }
                return true;

            }
            return false;

        }

        public function checkOutNotifyMail($log_id, $user, $checkout_at, $expected_checkin, $note) {

            $data['log_id'] = $log_id;
            $data['eula'] = $this->getEula();
            $data['first_name'] = $user->first_name;
            $data['item_name'] = $this->showAssetName();
            $data['checkout_date'] = $checkout_at;
            $data['expected_checkin'] = $expected_checkin;
            $data['item_tag'] = $this->asset_tag;
            $data['note'] = $note;
            $data['item_serial'] = $this->serial;
            $data['require_acceptance'] = $this->requireAcceptance();

            if ((($this->requireAcceptance()=='1')  || ($this->getEula())) && (!Config::get('app.lock_passwords'))) {

	            Mail::send('emails.accept-asset', $data, function ($m) use ($user) {
	                $m->to($user->email, $user->first_name . ' ' . $user->last_name);
	                $m->subject('Confirm asset delivery');
	            });
            }

        }

        public function checkOutNotifySlack($settings, $admin, $note = null) {

			if ($settings->slack_endpoint) {

                $slack_settings = [
                    'username' => $settings->botname,
                    'channel' => $settings->slack_channel,
                    'link_names' => true
                ];

                $client = new \Maknz\Slack\Client($settings->slack_endpoint,$slack_settings);

                    try {
                        $client->attach([
                            'color' => 'good',
                            'fields' => [
                                [
                                    'title' => 'Checked Out:',
                                    'value' => 'HARDWARE asset <'.Config::get('app.url').'/hardware/'.$this->id.'/view'.'|'.$this->showAssetName().'> checked out to <'.Config::get('app.url').'/admin/users/'.$this->assigned_to.'/view|'.$this->assigneduser->fullName().'> by <'.Config::get('app.url').'/hardware/'.$this->id.'/view'.'|'.$admin->fullName().'>.'
                                ],
                                [
                                    'title' => 'Note:',
                                    'value' => e($note)
                                ],



                            ]
                        ])->send('Asset Checked Out');

                    } catch (Exception $e) {
                        print_r($e);
                    }
                }

        }

  public function createCheckoutLog($checkout_at = null, $admin, $user, $expected_checkin = null, $note = null) {

      $logaction = new Actionlog();
      $logaction->asset_id = $this->id;
      $logaction->checkedout_to = $this->assigned_to;
      $logaction->asset_type = 'hardware';
      $logaction->location_id = $user->location_id;
      $logaction->adminlog()->associate($admin);
      $logaction->note = $note;
      if ($checkout_at) {
          $logaction->created_at = $checkout_at;
      }
      $log = $logaction->logaction('checkout');
      return $logaction->id;
  }


  /**
   * Set depreciation relationship
   */
  public function depreciation()
  {
      return $this->model->belongsTo( 'Depreciation', 'depreciation_id' );
  }

  /**
   * Get depreciation attribute from associated asset model
   */
  public function get_depreciation()
  {
      return $this->model->depreciation;
  }

  /**
   * Get uploads for this asset
   */
  public function uploads()
  {

      return $this->hasMany( 'Actionlog', 'asset_id' )
                  ->where( 'asset_type', '=', 'hardware' )
                  ->where( 'action_type', '=', 'uploaded' )
                  ->whereNotNull( 'filename' )
                  ->orderBy( 'created_at', 'desc' );
  }

public static function checkUploadIsImage($file) {
// Check if the file is an image, so we can show a preview
$finfo = @finfo_open(FILEINFO_MIME_TYPE); // return mime type ala mimetype extension
$filetype = @finfo_file($finfo, $file);
finfo_close($finfo);

if (($filetype=="image/jpeg") || ($filetype=="image/jpg") || ($filetype=="image/gif")) {
  return true;
}

return false;
}

  public function assigneduser()
  {

      return $this->belongsTo( 'User', 'assigned_to' )
                  ->withTrashed();
  }

  /**
   * Get the asset's location based on the assigned user
   **/
  public function assetloc()
  {

      if ($this->assigneduser) {
          return $this->assigneduser->userloc();
      } else {
          return $this->belongsTo( 'Location', 'rtd_location_id' );
      }

  }

  /**
   * Get the asset's location based on default RTD location
   **/
  public function defaultLoc()
  {

      return $this->belongsTo( 'Location', 'rtd_location_id' );
  }

  /**
   * Get action logs for this asset
   */
  public function assetlog()
  {

      return $this->hasMany( 'Actionlog', 'asset_id' )
                  ->where( 'asset_type', '=', 'hardware' )
                  ->orderBy( 'created_at', 'desc' )
                  ->withTrashed();
  }

  /**
   * assetmaintenances
   * Get improvements for this asset
   *
   * @return mixed
   * @author  Vincent Sposato <vincent.sposato@gmail.com>
   * @version v1.0
   */
  public function assetmaintenances()
  {

      return $this->hasMany( 'AssetMaintenance', 'asset_id' )
                  ->orderBy( 'created_at', 'desc' )
                  ->withTrashed();
  }

  /**
   * Get action logs for this asset
   */
  public function adminuser()
  {

      return $this->belongsTo( 'User', 'user_id' );
  }

  /**
   * Get total assets
   */
  public static function assetcount()
  {

      return Asset::where( 'physical', '=', '1' )
               ->whereNull( 'deleted_at', 'and' )
               ->count();
  }

  /**
   * Get total assets not checked out
   */
  public static function availassetcount()
  {

      return Asset::RTD()
                  ->whereNull( 'deleted_at' )
                  ->count();

  }

  /**
   * Get requestable assets
   */
  public static function getRequestable()
  {

      return Asset::Requestable()
                  ->whereNull( 'deleted_at' )
                  ->count();

  }

  /**
   * Get total assets
   */
  public function assetstatus()
  {

      return $this->belongsTo( 'Statuslabel', 'status_id' );
  }

  /**
   * Get name for EULA
   **/
  public function showAssetName()
  {

      if ($this->name == '') {
          return $this->model->name;
      } else {
          return $this->name;
      }
  }

  public function warrantee_expires()
  {

      $date = date_create( $this->purchase_date );
      date_add( $date, date_interval_create_from_date_string( $this->warranty_months . ' months' ) );

      return date_format( $date, 'Y-m-d' );
  }

  public function model()
  {

      return $this->belongsTo( 'Model', 'model_id' )
                  ->withTrashed();
  }

  public static function getExpiringWarrantee( $days = 30 )
  {

      return Asset::where( 'archived', '=', '0' )
                  ->whereNotNull( 'warranty_months' )
                  ->whereNotNull( 'purchase_date' )
                  ->whereNull( 'deleted_at' )
                  ->whereRaw( DB::raw( 'DATE_ADD(`purchase_date`,INTERVAL `warranty_months` MONTH) <= DATE(NOW() + INTERVAL '
                                       . $days
                                       . ' DAY) AND DATE_ADD(`purchase_date`,INTERVAL `warranty_months` MONTH) > NOW()' ) )
                  ->orderBy( 'purchase_date', 'ASC' )
                  ->get();

  }

  /**
   * Get the license seat information
   **/
  public function licenses()
  {

      return $this->belongsToMany( 'License', 'license_seats', 'asset_id', 'license_id' );

  }

  public function licenseseats()
  {

      return $this->hasMany( 'LicenseSeat', 'asset_id' );
  }

  public function supplier()
  {

      return $this->belongsTo( 'Supplier', 'supplier_id' );
  }

  public function months_until_eol()
  {

      $today = date( "Y-m-d" );
      $d1    = new DateTime( $today );
      $d2    = new DateTime( $this->eol_date() );

      if ($this->eol_date() > $today) {
          $interval = $d2->diff( $d1 );
      } else {
          $interval = null;
      }

      return $interval;
  }

  public function eol_date()
  {

      if (( $this->purchase_date ) && ( $this->model->eol !='' ) && ( $this->model->eol > 0 )) {
          $date = date_create( $this->purchase_date );
          date_add( $date, date_interval_create_from_date_string( $this->model->eol . ' months' ));
          return date_format( $date, 'Y-m-d' );
      } else {
	      return false;
      }

  }

  /**
   * Get total assets
   */
  public static function autoincrement_asset()
  {

      $settings = Setting::getSettings();

		if ($settings->auto_increment_assets == '1') {
			$asset_tag = DB::table('assets')
				->where('physical', '=', '1')
				->max('id');
			return $settings->auto_increment_prefix.($asset_tag + 1);
		} else {
			return false;
		}
    }

    public function checkin_email() {
        return $this->model->category->checkin_email;
    }

    public function requireAcceptance() {
	    return $this->model->category->require_acceptance;
    }

        public function getEula()
        {

            $Parsedown = new Parsedown();

            if ($this->model->category->eula_text) {
                return $Parsedown->text( e( $this->model->category->eula_text ) );
            } elseif ($this->model->category->use_default_eula == '1') {
                return $Parsedown->text( e( Setting::getSettings()->default_eula_text ) );
            } else {
                return null;
            }

        }



        /**
         * -----------------------------------------------
         * BEGIN QUERY SCOPES
         * -----------------------------------------------
         **/

        /**
         * Query builder scope for hardware
         *
         * @param  Illuminate\Database\Query\Builder $query Query builder instance
         *
         * @return Illuminate\Database\Query\Builder          Modified query builder
         */

        public function scopeHardware( $query )
        {

            return $query->where( 'physical', '=', '1' );
        }

        /**
         * Query builder scope for pending assets
         *
         * @param  Illuminate\Database\Query\Builder $query Query builder instance
         *
         * @return Illuminate\Database\Query\Builder          Modified query builder
         */

        public function scopePending( $query )
        {

            return $query->whereHas( 'assetstatus', function ( $query ) {

                $query->where( 'deployable', '=', 0 )
                      ->where( 'pending', '=', 1 )
                      ->where( 'archived', '=', 0 );
            } );
        }

        /**
         * Query builder scope for RTD assets
         *
         * @param  Illuminate\Database\Query\Builder $query Query builder instance
         *
         * @return Illuminate\Database\Query\Builder          Modified query builder
         */

        public function scopeRTD( $query )
        {

            return $query->whereNULL( 'assigned_to' )
                         ->whereHas( 'assetstatus', function ( $query ) {

                             $query->where( 'deployable', '=', 1 )
                                   ->where( 'pending', '=', 0 )
                                   ->where( 'archived', '=', 0 );
                         } );
        }

        /**
         * Query builder scope for Undeployable assets
         *
         * @param  Illuminate\Database\Query\Builder $query Query builder instance
         *
         * @return Illuminate\Database\Query\Builder          Modified query builder
         */

        public function scopeUndeployable( $query )
        {

            return $query->whereHas( 'assetstatus', function ( $query ) {

                $query->where( 'deployable', '=', 0 )
                      ->where( 'pending', '=', 0 )
                      ->where( 'archived', '=', 0 );
            } );
        }

        /**
         * Query builder scope for Archived assets
         *
         * @param  Illuminate\Database\Query\Builder $query Query builder instance
         *
         * @return Illuminate\Database\Query\Builder          Modified query builder
         */

        public function scopeArchived( $query )
        {

            return $query->whereHas( 'assetstatus', function ( $query ) {

                $query->where( 'deployable', '=', 0 )
                      ->where( 'pending', '=', 0 )
                      ->where( 'archived', '=', 1 );
            } );
        }

        /**
         * Query builder scope for Deployed assets
         *
         * @param  Illuminate\Database\Query\Builder $query Query builder instance
         *
         * @return Illuminate\Database\Query\Builder          Modified query builder
         */

        public function scopeDeployed( $query )
        {

            return $query->where( 'assigned_to', '>', '0' );
        }

        /**
         * Query builder scope for Requestable assets
         *
         * @param  Illuminate\Database\Query\Builder $query Query builder instance
         *
         * @return Illuminate\Database\Query\Builder          Modified query builder
         */

        public function scopeRequestableAssets( $query )
        {

            return $query->where( 'requestable', '=', 1 )
                         ->whereHas( 'assetstatus', function ( $query ) {

                             $query->where( 'deployable', '=', 1 )
                                   ->where( 'pending', '=', 0 )
                                   ->where( 'archived', '=', 0 );
                         } );
        }

        /**
         * Query builder scope for Deleted assets
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
     * scopeInModelList
     * Get all assets in the provided listing of model ids
     *
     * @param       $query
     * @param array $modelIdListing
     *
     * @return mixed
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
	public function scopeInModelList( $query, array $modelIdListing )
	{
		return $query->whereIn('model_id', $modelIdListing );
	}

  /**
  * Query builder scope to get not-yet-accepted assets
  *
  * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
  *
  * @return Illuminate\Database\Query\Builder          Modified query builder
  */
	public function scopeNotYetAccepted($query)
	{
		return $query->where("accepted","=","pending");
	}

  /**
  * Query builder scope to get rejected assets
  *
  * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
  *
  * @return Illuminate\Database\Query\Builder          Modified query builder
  */
	public function scopeRejected($query)
	{
		return $query->where("accepted","=","rejected");
	}


  /**
  * Query builder scope to get accepted assets
  *
  * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
  *
  * @return Illuminate\Database\Query\Builder          Modified query builder
  */
	public function scopeAccepted($query)
	{
		return $uery->where("accepted","=","accepted");
	}


	/**
	* Query builder scope to search on text for complex Bootstrap Tables API
	*
	* @param  Illuminate\Database\Query\Builder  $query  Query builder instance
	* @param  text                              $search    	 Search term
	*
	* @return Illuminate\Database\Query\Builder          Modified query builder
	*/
	public function scopeTextSearch($query, $search)
	{
		$search = explode(' OR ', $search);

		return $query->where(function($query) use ($search)
		{
			foreach ($search as $search) {
				$query->whereHas('model', function($query) use ($search) {
					$query->whereHas('category', function($query) use ($search) {
						$query->where(function($query) use ($search) {
							$query->where('categories.name','LIKE','%'.$search.'%')
							->orWhere('models.name','LIKE','%'.$search.'%');
						});
					});
				})->orWhere(function($query) use ($search) {
					$query->whereHas('assetstatus', function($query) use ($search) {
						$query->where('status_labels.name','LIKE','%'.$search.'%');
					});
        })->orWhere(function($query) use ($search) {
					$query->whereHas('company', function($query) use ($search) {
						$query->where('companies.name','LIKE','%'.$search.'%');
					});
				})->orWhere(function($query) use ($search) {
					$query->whereHas('defaultLoc', function($query) use ($search) {
						$query->where('locations.name','LIKE','%'.$search.'%');
					});
				})->orWhere(function($query) use ($search) {
					$query->whereHas('assigneduser', function($query) use ($search) {
						$query->where(function($query) use ($search) {
							$query->where('users.first_name','LIKE','%'.$search.'%')
							->orWhere('users.last_name','LIKE','%'.$search.'%')
							->orWhere(function($query) use ($search) {
								$query->whereHas('userloc', function($query) use ($search) {
									$query->where('locations.name','LIKE','%'.$search.'%');
								});
							});
						});
					});
				})->orWhere('assets.name','LIKE','%'.$search.'%')
				->orWhere('asset_tag','LIKE','%'.$search.'%')
				->orWhere('serial','LIKE','%'.$search.'%')
				->orWhere('order_number','LIKE','%'.$search.'%')
				->orWhere('notes','LIKE','%'.$search.'');
			}
			foreach(CustomField::all() AS $field) {
				$query->orWhere($field->db_column_name(),'LIKE',"%$search%");
			}
		});
	}

	/**
	* Query builder scope to order on model
	*
	* @param  Illuminate\Database\Query\Builder  $query  Query builder instance
	* @param  text                              $order    	 Order
	*
	* @return Illuminate\Database\Query\Builder          Modified query builder
	*/
	public function scopeOrderModels($query, $order)
	{
		return $query->join('models', 'assets.model_id', '=', 'models.id')->orderBy('models.name', $order);
	}

  /**
	* Query builder scope to order on company
	*
	* @param  Illuminate\Database\Query\Builder  $query  Query builder instance
	* @param  text                              $order    	 Order
	*
	* @return Illuminate\Database\Query\Builder          Modified query builder
	*/
	public function scopeOrderCompany($query, $order)
	{
		return $query->leftJoin('companies', 'assets.company_id', '=', 'companies.id')->orderBy('companies.name', $order);
	}

  /**
  * Query builder scope to order on category
  *
  * @param  Illuminate\Database\Query\Builder  $query  Query builder instance
  * @param  text                              $order    	 Order
  *
  * @return Illuminate\Database\Query\Builder          Modified query builder
  */
	public function scopeOrderCategory($query, $order)
	{
		return $query->join('models', 'assets.model_id', '=', 'models.id')
            ->join('categories', 'models.category_id', '=', 'categories.id')
            ->orderBy('categories.name', $order);
	}

  /**
	* Query builder scope to order on model
	*
	* @param  Illuminate\Database\Query\Builder  $query  Query builder instance
	* @param  text                              $order    	 Order
	*
	* @return Illuminate\Database\Query\Builder          Modified query builder
  * TODO: Extend this method out for checked out assets as well. Right now it
  * only checks the location name related to rtd_location_id
	*/
	public function scopeOrderLocation($query, $order)
	{
		return $query->join('locations', 'locations.id', '=', 'assets.rtd_location_id')->orderBy('locations.name', $order);
	}

}
