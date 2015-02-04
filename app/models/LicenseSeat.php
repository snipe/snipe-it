<?php

class LicenseSeat extends Elegant
{
	use SoftDeletingTrait;
    protected $dates = ['deleted_at'];
    protected $guarded = 'id';
    protected $table = 'license_seats';

    public function license()
    {
        return $this->belongsTo('License','license_id');
    }

    public function user()
    {
        return $this->belongsTo('User','assigned_to')->withTrashed();
    }

    public function asset()
    {
        return $this->belongsTo('Asset','asset_id')->withTrashed();
    }
}
