<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * This is the model class for table "serials".
 * @property int $id
 * @property int $component_id
 * @property int $asset_id
 * @property string $serial_number
 * @property string $notes
 * @property int $status (0 = available, 1 = assigned, 2 = reserved)
 * @property string $created_at
 * @property string $updated_at
 * @property string $purchase_date
 * @property string $purchase_order
 * @property float $purchase_cost
 * @property int $supplier_id
 * @property string $warranty_date
 */
class Serial extends Model
{
    // Table name
    protected $table = 'serials';

    // Primary key
    public $primaryKey = 'id';

    // Timestamps
    public $timestamps = true;

    // Unfillable fields
    protected $guarded = [
        'id',
    ];

    // Date fields
    protected $dates = [
        'created_at',
        'updated_at',
        'purchase_date',
        'warranty_date',
    ];

    // Append fields
    protected $appends = [
        'status_label',
    ];

    /**
     * This will update the status of the serial to either Assigned or Available.
     *
     * @param $value
     * @return void
     */
    public function setAssetIdAttribute($value)
    {
        // Do not update status if the serial is reserved
        if ($this->status !== 2) {
            $this->attributes['status'] = (!empty($value)) ? 1 : 0;
        }
    }

    // Get the associated component
    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }

    // Get the associated asset
    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }

    // Get the associated supplier
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    // Return the status of the serial number
    public function getStatusLabelAttribute(): string
    {
        switch ($this->status) {
            case 0:
                return 'Available';
            case 1:
                return 'Assigned';
            case 2:
                return 'Reserved';
            default:
                return 'Unknown';
        }
    }
}
