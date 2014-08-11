
ALTER TABLE `asset_uploads` 
CHANGE COLUMN `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

ALTER TABLE `assets` 
CHANGE COLUMN `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

ALTER TABLE `categories` 
CHANGE COLUMN `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

ALTER TABLE `depreciations` 
CHANGE COLUMN `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

ALTER TABLE `groups` 
CHANGE COLUMN `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

ALTER TABLE `history` 
CHANGE COLUMN `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

ALTER TABLE `license_seats` 
CHANGE COLUMN `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

ALTER TABLE `licenses` 
CHANGE COLUMN `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

ALTER TABLE `locations` 
CHANGE COLUMN `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

ALTER TABLE `manufacturers` 
CHANGE COLUMN `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

ALTER TABLE `models` 
CHANGE COLUMN `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

ALTER TABLE `settings` 
CHANGE COLUMN `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

ALTER TABLE `status_labels` 
CHANGE COLUMN `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

ALTER TABLE `suppliers` 
CHANGE COLUMN `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

ALTER TABLE `users` 
CHANGE COLUMN `created_at` `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
CHANGE COLUMN `updated_at` `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;


UPDATE assets SET status_id=0 where status_id is null;
UPDATE assets SET purchase_cost=0 where purchase_cost is null;
UPDATE models SET eol=0 where eol is null;
UPDATE users SET location_id=0 where location_id is null;

ALTER TABLE `assets` 
CHANGE COLUMN `name` `name` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL ,
CHANGE COLUMN `asset_tag` `asset_tag` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
CHANGE COLUMN `purchase_cost` `purchase_cost` DECIMAL(13,4) NOT NULL DEFAULT '0.0000' ,
CHANGE COLUMN `order_number` `order_number` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL ,
CHANGE COLUMN `assigned_to` `assigned_to` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `notes` `notes` TEXT CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL ,
CHANGE COLUMN `status_id` `status_id` INT(11) NULL DEFAULT NULL ;
CHANGE COLUMN `archived` `archived` TINYINT(1) NOT NULL DEFAULT '0' ,
CHANGE COLUMN `depreciate` `depreciate` TINYINT(1) NOT NULL DEFAULT '0' ,
CHANGE COLUMN `supplier_id` `supplier_id` INT(11) NULL DEFAULT NULL ,
CHANGE COLUMN `requestable` `requestable` TINYINT(4) NOT NULL DEFAULT '0' ;

ALTER TABLE `licenses` 
CHANGE COLUMN `purchase_cost` `purchase_cost` DECIMAL(13,4) NULL DEFAULT NULL ,
CHANGE COLUMN `depreciate` `depreciate` TINYINT(1) NULL DEFAULT '0' ;

ALTER TABLE `locations` 
CHANGE COLUMN `address2` `address2` VARCHAR(80) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL ,
CHANGE COLUMN `zip` `zip` VARCHAR(10) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL ;

ALTER TABLE `models` 
CHANGE COLUMN `modelno` `modelno` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NULL DEFAULT NULL ,
CHANGE COLUMN `manufacturer_id` `manufacturer_id` INT(11) NOT NULL ,
CHANGE COLUMN `category_id` `category_id` INT(11) NOT NULL ,
CHANGE COLUMN `depreciation_id` `depreciation_id` INT(11) NOT NULL DEFAULT '0' ,
CHANGE COLUMN `eol` `eol` INT(11) NULL DEFAULT '0' ;

ALTER TABLE `users` 
CHANGE COLUMN `first_name` `first_name` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
CHANGE COLUMN `last_name` `last_name` VARCHAR(255) CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci' NOT NULL ,
CHANGE COLUMN `location_id` `location_id` INT(11) NOT NULL ;

