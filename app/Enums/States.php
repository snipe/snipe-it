<?php

namespace App\Enums;

class States {
  const NONE = 'none'; // used to add inventory as the from state, uses price field
  const IN_STOCK = 'in_stock'; // similar to READY_TO_DEPLOY
  const CHECKED_OUT = 'checked_out'; // quantity checked out
  const PENDING = 'pending'; // similar to PENDING,
  const UNDEPLOYABLE = 'undeployable'; // similar to UNDEPLYABLE, broken, thrown away
  const SOLD = 'sold'; // sold for a price, uses price field
  const USED = 'used'; // mainly used for consumables
  const LOST = 'lost'; // lost / stolen (could be included with undeployable)
  const ARCHIVED = 'archived'; // similar to ARCHIVED
  const ORDERED_FROM_SUPPLIER = 'ordered_from_supplier'; // on order with supplier
  const RECEIVED_FROM_SUPPLIER = 'received_from_supplier'; // arrived but not available
  const RESERVED_REQUEST = 'reserved_request'; // reserved quantity

  public static $all_states = [
    self::NONE, 
    self::IN_STOCK, 
    self::CHECKED_OUT, 
    self::PENDING, 
    self::UNDEPLOYABLE,
    self::SOLD, 
    self::USED, 
    self::LOST,
    self::ARCHIVED, 
    self::ORDERED_FROM_SUPPLIER,
    self::RECEIVED_FROM_SUPPLIER,
    self::RESERVED_REQUEST
  ];

  public static $default_view_states = [
    self::IN_STOCK,
    self::CHECKED_OUT,
    self::PENDING,
    self::ARCHIVED,
    self::RESERVED_REQUEST,
  ];

  public static $wasted_states = [
    self::UNDEPLOYABLE,
    self::USED,
    self::LOST,
  ];

  public static $unusable_states = [
    self::UNDEPLOYABLE,
    self::USED,
    self::LOST,
    self::SOLD
  ];

  public static $from_states_manual = [
    self::NONE, 
    self::IN_STOCK, 
    self::PENDING, 
    self::ARCHIVED, 
    self::RESERVED_REQUEST,
  ];
  
  public static $to_states_manual = [
    self::IN_STOCK, 
    self::PENDING, 
    self::ARCHIVED,
    self::RESERVED_REQUEST,
    self::UNDEPLOYABLE,
    self::SOLD, 
    self::USED, 
  ];
}