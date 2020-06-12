<?php

namespace App\Enums;

class States {
  const NONE = 'none'; // used to add inventory as the from state, uses price field
  const IN_STOCK = 'in_stock'; // similar to READY_TO_DEPLOY
  const CHECKED_OUT = 'checked_out'; // quantity checked out
  const PENDING = 'pending'; // similar to PENDING,
  // const ARCHIVED = 'archived'; // similar to ARCHIVED, put away for long storage.  Still available if needed
  const WASTE = 'waste'; // similar to UNDEPLYABLE, broken, thrown away, no longer usable
  const USED = 'used'; // mainly used for consumables, used an no longer usable
  const SOLD = 'sold'; // sold for a price, uses price field, no longer usable
  const LOST = 'lost'; // lost / stolen, no longer usable
  const ORDERED_FROM_SUPPLIER = 'ordered_from_supplier'; // on order with supplier
  const RECEIVED_FROM_SUPPLIER = 'received_from_supplier'; // arrived but not available
  const RESERVED_REQUEST = 'reserved_request'; // reserved quantity

  public static $all_states = [
    self::IN_STOCK, 
    self::CHECKED_OUT, 
    self::PENDING, 
    //self::ARCHIVED, 
    self::WASTE,
    self::USED, 
    self::SOLD, 
    self::LOST,
    self::ORDERED_FROM_SUPPLIER,
    self::RECEIVED_FROM_SUPPLIER,
    self::RESERVED_REQUEST
  ];

  public static $main_states = [
    self::IN_STOCK,
    self::CHECKED_OUT,
    self::PENDING,
    //self::ARCHIVED,
  ];

  public static $wasted_states = [
    self::WASTE,
    self::USED,
    self::SOLD,
    self::LOST,
  ];

  public static $from_states_manual = [
    self::NONE, 
    self::IN_STOCK, 
    self::PENDING, 
    //self::ARCHIVED, 
  ];
  
  public static $to_states_manual = [
    self::IN_STOCK, 
    self::PENDING, 
    //self::ARCHIVED,
    self::WASTE,
    self::USED,
    self::SOLD, 
    self::LOST,
  ];
}