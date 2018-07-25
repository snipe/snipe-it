<?php

namespace App\Models\Relationships;


use App\Models\Accessory;

/**
 * This trait wraps all asset maintenance model relationships,
 *
 */
trait AssetMaintenanceRelationships {

    /**
     * Get the admin who created the maintenance
     *
     * @return mixed
     * @author  A. Gianotto <snipe@snipe.net>
     * @version v3.0
     */
    public function admin()
    {

        return $this->belongsTo('\App\Models\User', 'user_id')
            ->withTrashed();
    }

    /**
     * asset
     * Get asset for this improvement
     *
     * @return mixed
     * @author  Vincent Sposato <vincent.sposato@gmail.com>
     * @version v1.0
     */
    public function asset()
    {

        return $this->belongsTo('\App\Models\Asset', 'asset_id')
            ->withTrashed();
    }

    public function supplier()
    {

        return $this->belongsTo('\App\Models\Supplier', 'supplier_id')
            ->withTrashed();
    }
}
