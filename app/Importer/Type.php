<?php

declare(strict_types=1);

namespace App\Importer;

enum Type: string
{
    case ACCESSORY   = 'accessory';
    case ASSET       = 'asset';
    case COMPONENT   = 'component';
    case CONSUMABLE  = 'consumable';
    case LICENSE     = 'license';
    case LOCATION    = 'location';
    case USER        = 'user';
    case ASSET_MODEL = 'assetModel';

    /**
     * Get the valid import type cli options.
     *
     * @return array<string>
     */
    public static function validTypesForCli(): array
    {
        $types = array_column(self::cases(), 'value');

        return collect($types)
            ->map(ucfirst(...))
            ->merge($types)
            ->all();
    }
}
