<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessoryCheckout extends Model
{
    use Loggable;

    protected $guarded = 'id';
    protected $table = 'accessories_users';

    protected $fillable = [
        'assigned_to',
    ];

    /**
     * Establishes the checked out accessory -> accessories relationship
     *
     * @author G. Martinez
     * @since [v6.4]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function accessory()
    {
        return $this->belongsTo(\App\Models\Accessory::class, 'accessory_id')->withTrashed();
    }
    /**
     * Establishes the checked out accessory -> assignee relationship
     *
     * @author G. Martinez
     * @since [v6.4]
     * @return \Illuminate\Database\Eloquent\Relations\Relation
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'assigned_to')->withTrashed();
    }
}
