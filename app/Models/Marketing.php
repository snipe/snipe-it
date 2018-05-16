<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Presenters\Presentable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Watson\Validating\ValidatingTrait;
use App\Notifications\CheckinAccessoryNotification;
use App\Notifications\CheckoutAccessoryNotification;


class Marketing extends SnipeModel
{
    // empty
}
