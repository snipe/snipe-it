<?php

namespace App\Models\Relationships;



use App\Models\User;

/**
 * This trait wraps all actionlog model relationships,
 *
 */
trait ActionlogRelationships {


    public function childlogs()
    {
        return $this->hasMany('\App\Models\ActionLog', 'thread_id');
    }

    public function company()
    {
        return $this->hasMany('\App\Models\Company', 'id', 'company_id');
    }

    public function item()
    {
        return $this->morphTo('item')->withTrashed();
    }

    public function location() {
        return $this->belongsTo('\App\Models\Location', 'location_id' )->withTrashed();
    }

    public function parentlog()
    {
        return $this->belongsTo('\App\Models\ActionLog', 'thread_id');
    }

    public function target()
    {
        return $this->morphTo('target')->withTrashed();
    }

    public function uploads()
    {
        return $this->morphTo('item')
            ->where('action_type', '=', 'uploaded')
            ->withTrashed();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')
            ->withTrashed();
    }

    public function userlog()
    {
        return $this->target();
    }

}
