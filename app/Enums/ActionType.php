<?php

namespace App\Enums;

enum ActionType: string {
    case Restore = 'restore';
    case TwoFactorReset = '2FA reset';
    case CheckinFrom = 'checkin from';
    case RequestCanceled = 'request canceled';
    case Requested = 'requested';
    case DeleteSeats = 'delete seats';
    case AddSeats = 'add seats';
    case Update = 'update';
    case Create = 'create';
    case Delete = 'delete';
}