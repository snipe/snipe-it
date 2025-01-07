<?php

namespace App\Http\Traits;

trait CheckoutableTrait
{
    public const LOCATION = 'location';
    public const ASSET = 'asset';
    public const USER = 'user';
    public function checkedOutToUser(): bool
    {
        return $this->assignedType() === self::USER;
    }

    public function checkedOutToLocation(): bool
    {
        return $this->assignedType() === self::LOCATION;
    }

    public function checkedOutToAsset(): bool
    {
        return $this->assignedType() === self::ASSET;
    }
}