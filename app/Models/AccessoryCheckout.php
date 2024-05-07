<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AccessoryCheckout extends Model
{

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
     */
    public function accessory(): BelongsTo
    {
        return $this->belongsTo(Accessory::class, 'accessory_id')->withTrashed();
    }

    /**
     * Establishes the checked out accessory -> assignee relationship
     *
     * @author G. Martinez
     * @since [v6.4]
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to')->withTrashed();
    }
}
