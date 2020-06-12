<?php

namespace App\Enums;

use App\Models\Accessory;
use App\Models\Consumable;
use App\Models\Component;

class AssetTypes {
  const ACCESSORY = Accessory::class;
  const CONSUMABLE = Consumable::class;
  const COMPONENT = Component::class;

  public static $allAssetTypes = [
    self::ACCESSORY,
    self::CONSUMABLE,
    self::COMPONENT,
  ];

  public static $typePluralNames = [
    self::ACCESSORY => 'accessories',
    self::CONSUMABLE => 'consumables',
    self::COMPONENT => 'components',
  ];
}