<?php

namespace App\Enums;

enum ActionType: string {
    case Restore = 'restore';
    case TwoFactorReset = '2FA reset';
    case CheckinFrom = 'checkin from';
    case Checkout = 'checkout';
    case RequestCanceled = 'request canceled';
    case Requested = 'requested';
    case DeleteSeats = 'delete seats';
    case AddSeats = 'add seats';
    case Update = 'update';
    case Create = 'create';
    case Delete = 'delete';
    case NoteAdded = 'note added';
    case Audit = 'audit';
    case Merged = 'merged';
    case Accepted = 'accepted';
    case Declined = 'declined';
    case Uploaded = 'uploaded';
}