<?php

class ConsumableAssignment extends Elegant
{
  use CompanyableTrait;

  protected $dates = ['deleted_at'];
  protected $table = 'consumables_users';

  public function consumable()
  {
    return $this->belongsTo('Consumable');
  }

  public function user()
  {
    return $this->belongsTo('User','assigned_to');
  }

  public function admin()
  {
    return $this->belongsTo('User','user_id');
  }



}
