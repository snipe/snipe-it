<?php
class Throttle extends Elegant
{
	
	protected $table = 'throttle';
    public function user()
    {
        return $this->belongsTo('User', 'user_id');
    }
    

}
