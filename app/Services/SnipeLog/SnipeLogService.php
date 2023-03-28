<?php

namespace App\Services\SnipeLog;

use App\Models\Actionlog;
use App\Models\AdminLog;

class SnipeLogService
{
    protected $actionType;
   
    protected $fillable = ['created_at', 'item_type', 'user_id', 'item_id', 'action_type', 'note', 'target_id', 'target_type'];

    public function action()
    {
        return new Actionlog();
    }

    public function admin(string $actionType = null)
    {
        $adminLog = new AdminLog();
        $adminLog->actionType($actionType);
        return $adminLog;
    }
   
    // public function actionType(string $type)
    // {
    //     $this->actionType = $type;
    //     return $this;
    // }
}
