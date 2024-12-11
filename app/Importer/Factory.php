<?php

declare(strict_types=1);

namespace App\Importer;

use Illuminate\Support\Str;

class Factory
{
    /**
     * Create a new importer instance.
     */
    public static function make(string $filepath, string $type): Importer
    {
        return match (Type::from(Str::camel($type))) {
            Type::ACCESSORY   => new AccessoryImporter($filepath),
            Type::ASSET       => new AssetImporter($filepath),
            Type::COMPONENT   => new ComponentImporter($filepath),
            Type::CONSUMABLE  => new ConsumableImporter($filepath),
            Type::LICENSE     => new LicenseImporter($filepath),
            Type::LOCATION    => new LocationImporter($filepath),
            Type::USER        => new UserImporter($filepath),
            Type::ASSET_MODEL => new AssetModelImporter($filepath),
        };
    }
}
