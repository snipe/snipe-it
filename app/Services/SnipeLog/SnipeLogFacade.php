<?php 

namespace App\Services\SnipeLog;

use App\Models\Actionlog;
use App\Models\AdminLog;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Facade;

/**
 * @method static item(string $query)
 */

class SnipeLogFacade extends Facade {

    protected static function getFacadeAccessor()
    {
        return SnipeLogService::class;
    }
}
