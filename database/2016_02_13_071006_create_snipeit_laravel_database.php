<?php

//
// NOTE Migration Created: 2016-02-13 07:10:06
// --------------------------------------------------

class CreateSnipeitLaravelDatabase {
//
// NOTE - Make changes to the database.
// --------------------------------------------------

public function up()
{

//
// NOTE -- accessories
// --------------------------------------------------

Schema::create('accessories', function($table) {
 $table->increments('id')->unsigned();
 $table->string('name', 255)->nullable();
 $table->integer('category_id')->nullable();
 $table->integer('user_id')->nullable();
 $table->integer('qty');
 $table->boolean('requestable');
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 $table->timestamp('deleted_at')->nullable();
 $table->integer('location_id')->nullable();
 $table->date('purchase_date')->nullable();
 $table->decimal('purchase_cost', 13,4)->nullable();
 $table->string('order_number', 255)->nullable();
 $table->integer('company_id')->nullable()->unsigned();
 });


//
// NOTE -- accessories_users
// --------------------------------------------------

Schema::create('accessories_users', function($table) {
 $table->increments('id')->unsigned();
 $table->integer('user_id')->nullable();
 $table->integer('accessory_id')->nullable();
 $table->integer('assigned_to')->nullable();
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 });


//
// NOTE -- asset_logs
// --------------------------------------------------

Schema::create('asset_logs', function($table) {
 $table->increments('id')->unsigned();
 $table->integer('user_id');
 $table->string('action_type', 255);
 $table->integer('asset_id')->nullable();
 $table->integer('checkedout_to')->nullable();
 $table->integer('location_id')->nullable();
 $table->dateTime('created_at')->default("0000-00-00 00:00:00");
 $table->string('asset_type', 100)->nullable();
 $table->text('note')->nullable();
 $table->text('filename')->nullable();
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 $table->timestamp('deleted_at')->nullable();
 $table->dateTime('requested_at')->nullable();
 $table->dateTime('accepted_at')->nullable();
 $table->integer('accessory_id')->nullable();
 $table->integer('accepted_id')->nullable();
 $table->integer('consumable_id')->nullable();
 $table->date('expected_checkin')->nullable();
 $table->integer('thread_id')->nullable();
 });


//
// NOTE -- asset_maintenances
// --------------------------------------------------

Schema::create('asset_maintenances', function($table) {
 $table->increments('id')->unsigned();
 $table->integer('asset_id')->unsigned();
 $table->integer('supplier_id')->unsigned();
 $table->enum('asset_maintenance_type', array('Maintenance','Repair','Upgrade'));
 $table->string('title', 100);
 $table->boolean('is_warranty');
 $table->date('start_date');
 $table->date('completion_date')->nullable();
 $table->integer('asset_maintenance_time')->nullable();
 $table->string('notes')->nullable();
 $table->decimal('cost', 10,2)->nullable();
 $table->dateTime('deleted_at')->nullable();
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 });


//
// NOTE -- asset_uploads
// --------------------------------------------------

Schema::create('asset_uploads', function($table) {
 $table->increments('id')->unsigned();
 $table->integer('user_id');
 $table->string('filename', 255);
 $table->integer('asset_id');
 $table->string('filenotes', 255);
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 $table->timestamp('deleted_at')->nullable();
 });


//
// NOTE -- assets
// --------------------------------------------------

Schema::create('assets', function($table) {
 $table->increments('id')->unsigned();
 $table->string('name', 255)->nullable();
 $table->string('asset_tag', 255);
 $table->integer('model_id');
 $table->string('serial', 255);
 $table->date('purchase_date')->nullable();
 $table->decimal('purchase_cost', 13,4)->default("0.0000");
 $table->string('order_number', 255)->nullable();
 $table->integer('assigned_to')->nullable();
 $table->text('notes')->nullable();
 $table->text('image')->nullable();
 $table->integer('user_id');
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 $table->boolean('physical')->default("1");
 $table->timestamp('deleted_at')->nullable();
 $table->integer('status_id')->nullable();
 $table->boolean('archived');
 $table->integer('warranty_months')->nullable();
 $table->boolean('depreciate');
 $table->integer('supplier_id')->nullable();
 $table->boolean('requestable');
 $table->integer('rtd_location_id')->nullable();
 $table->string('_snipeit_mac_address', 255)->nullable();
 $table->enum('accepted', array('pending','accepted','rejected'))->nullable();
 $table->dateTime('last_checkout')->nullable();
 $table->date('expected_checkin')->nullable();
 $table->integer('company_id')->nullable()->unsigned();
 });


//
// NOTE -- categories
// --------------------------------------------------

Schema::create('categories', function($table) {
 $table->increments('id')->unsigned();
 $table->string('name', 255);
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 $table->integer('user_id');
 $table->timestamp('deleted_at')->nullable();
 $table->text('eula_text')->nullable();
 $table->boolean('use_default_eula');
 $table->boolean('require_acceptance');
 $table->string('category_type', 255)->nullable()->default("asset");
 $table->boolean('checkin_email');
 });


//
// NOTE -- companies
// --------------------------------------------------

Schema::create('companies', function($table) {
 $table->increments('id')->unsigned();
 $table->string('name', 255)->unique();
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 });


//
// NOTE -- consumables
// --------------------------------------------------

Schema::create('consumables', function($table) {
 $table->increments('id')->unsigned();
 $table->string('name', 255)->nullable();
 $table->integer('category_id')->nullable();
 $table->integer('location_id')->nullable();
 $table->integer('user_id')->nullable();
 $table->integer('qty');
 $table->boolean('requestable');
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 $table->timestamp('deleted_at')->nullable();
 $table->date('purchase_date')->nullable();
 $table->decimal('purchase_cost', 13,4)->nullable();
 $table->string('order_number', 255)->nullable();
 $table->integer('company_id')->nullable()->unsigned();
 });


//
// NOTE -- consumables_users
// --------------------------------------------------

Schema::create('consumables_users', function($table) {
 $table->increments('id')->unsigned();
 $table->integer('user_id')->nullable();
 $table->integer('consumable_id')->nullable();
 $table->integer('assigned_to')->nullable();
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 });


//
// NOTE -- custom_field_custom_fieldset
// --------------------------------------------------

Schema::create('custom_field_custom_fieldset', function($table) {
 $table->integer('custom_field_id');
 $table->integer('custom_fieldset_id');
 $table->integer('order');
 $table->boolean('required');
 });


//
// NOTE -- custom_fields
// --------------------------------------------------

Schema::create('custom_fields', function($table) {
 $table->increments('id')->unsigned();
 $table->string('name', 255);
 $table->string('format', 255);
 $table->string('element', 255);
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 $table->integer('user_id')->nullable();
 });


//
// NOTE -- custom_fieldsets
// --------------------------------------------------

Schema::create('custom_fieldsets', function($table) {
 $table->increments('id')->unsigned();
 $table->string('name', 255);
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 $table->integer('user_id')->nullable();
 });


//
// NOTE -- depreciations
// --------------------------------------------------

Schema::create('depreciations', function($table) {
 $table->increments('id')->unsigned();
 $table->string('name', 255);
 $table->integer('months');
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 $table->integer('user_id');
 });


//
// NOTE -- groups
// --------------------------------------------------

Schema::create('groups', function($table) {
 $table->increments('id')->unsigned();
 $table->string('name', 255)->unique();
 $table->text('permissions')->nullable();
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 });


//
// NOTE -- history
// --------------------------------------------------

Schema::create('history', function($table) {
 $table->increments('id')->unsigned();
 $table->integer('checkedout_to');
 $table->integer('location_id');
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 $table->integer('user_id');
 });


//
// NOTE -- license_seats
// --------------------------------------------------

Schema::create('license_seats', function($table) {
 $table->increments('id')->unsigned();
 $table->integer('license_id');
 $table->integer('assigned_to')->nullable();
 $table->text('notes')->nullable();
 $table->integer('user_id');
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 $table->timestamp('deleted_at')->nullable();
 $table->integer('asset_id')->nullable();
 });


//
// NOTE -- licenses
// --------------------------------------------------

Schema::create('licenses', function($table) {
 $table->increments('id')->unsigned();
 $table->string('name', 255);
 $table->text('serial')->nullable();
 $table->date('purchase_date')->nullable();
 $table->decimal('purchase_cost', 13,4)->nullable();
 $table->string('order_number', 50)->nullable();
 $table->integer('seats')->default("1");
 $table->text('notes')->nullable();
 $table->integer('user_id');
 $table->boolean('depreciation_id');
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 $table->timestamp('deleted_at')->nullable();
 $table->string('license_name', 100)->nullable();
 $table->string('license_email', 120)->nullable();
 $table->boolean('depreciate')->nullable();
 $table->integer('supplier_id')->nullable();
 $table->date('expiration_date')->nullable();
 $table->string('purchase_order', 255)->nullable();
 $table->date('termination_date')->nullable();
 $table->boolean('maintained');
 $table->boolean('reassignable')->default("1");
 $table->integer('company_id')->nullable()->unsigned();
 });


//
// NOTE -- locations
// --------------------------------------------------

Schema::create('locations', function($table) {
 $table->increments('id')->unsigned();
 $table->string('name', 255);
 $table->string('city', 255);
 $table->string('state', 255);
 $table->string('country', 2);
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 $table->integer('user_id');
 $table->string('address', 80);
 $table->string('address2', 255)->nullable();
 $table->string('zip', 10)->nullable();
 $table->timestamp('deleted_at')->nullable();
 $table->integer('parent_id')->nullable();
 $table->string('currency', 10)->nullable();
 });


//
// NOTE -- manufacturers
// --------------------------------------------------

Schema::create('manufacturers', function($table) {
 $table->increments('id')->unsigned();
 $table->string('name', 255);
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 $table->integer('user_id');
 $table->timestamp('deleted_at')->nullable();
 });


//
// NOTE -- models
// --------------------------------------------------

Schema::create('models', function($table) {
 $table->increments('id')->unsigned();
 $table->string('name', 255);
 $table->string('modelno', 255)->nullable();
 $table->integer('manufacturer_id');
 $table->integer('category_id');
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 $table->integer('depreciation_id');
 $table->integer('user_id');
 $table->integer('eol')->nullable();
 $table->string('image', 255)->nullable();
 $table->boolean('deprecated_mac_address');
 $table->timestamp('deleted_at')->nullable();
 $table->integer('fieldset_id')->nullable();
 $table->text('note')->nullable();
 });


//
// NOTE -- requested_assets
// --------------------------------------------------

Schema::create('requested_assets', function($table) {
 $table->increments('id')->unsigned();
 $table->integer('asset_id');
 $table->integer('user_id');
 $table->dateTime('accepted_at')->nullable();
 $table->dateTime('denied_at')->nullable();
 $table->string('notes', 255);
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 });


//
// NOTE -- requests
// --------------------------------------------------

Schema::create('requests', function($table) {
 $table->increments('id')->unsigned();
 $table->integer('asset_id');
 $table->integer('user_id');
 $table->text('request_code');
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 $table->timestamp('deleted_at')->nullable();
 });


//
// NOTE -- settings
// --------------------------------------------------

Schema::create('settings', function($table) {
 $table->increments('id')->unsigned();
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 $table->integer('user_id');
 $table->integer('per_page')->default("20");
 $table->string('site_name', 100)->default("Snipe IT Asset Management");
 $table->integer('qr_code')->nullable();
 $table->string('qr_text', 32)->nullable();
 $table->integer('display_asset_name')->nullable();
 $table->integer('display_checkout_date')->nullable();
 $table->integer('display_eol')->nullable();
 $table->integer('auto_increment_assets');
 $table->string('auto_increment_prefix', 255);
 $table->boolean('load_remote')->default("1");
 $table->string('logo', 255)->nullable();
 $table->string('header_color', 255)->nullable();
 $table->string('alert_email', 255)->nullable();
 $table->boolean('alerts_enabled')->default("1");
 $table->text('default_eula_text')->nullable();
 $table->string('barcode_type', 255)->nullable()->default("QRCODE");
 $table->string('slack_endpoint', 255)->nullable();
 $table->string('slack_channel', 255)->nullable();
 $table->string('slack_botname', 255)->nullable();
 $table->string('default_currency', 10)->nullable();
 $table->text('custom_css')->nullable();
 $table->boolean('brand')->default("1");
 $table->string('ldap_enabled', 255)->nullable();
 $table->string('ldap_server', 255)->nullable();
 $table->string('ldap_uname', 255)->nullable();
 $table->string('ldap_pword')->nullable();
 $table->string('ldap_basedn', 255)->nullable();
 $table->string('ldap_filter', 255)->nullable()->default("cn=*");
 $table->string('ldap_username_field', 255)->nullable()->default("samaccountname");
 $table->string('ldap_lname_field', 255)->nullable()->default("sn");
 $table->string('ldap_fname_field', 255)->nullable()->default("givenname");
 $table->string('ldap_auth_filter_query', 255)->nullable()->default("uid=samaccountname");
 $table->integer('ldap_version')->nullable()->default("3");
 $table->string('ldap_active_flag', 255)->nullable();
 $table->string('ldap_emp_num', 255)->nullable();
 $table->string('ldap_email', 255)->nullable();
 $table->boolean('full_multiple_companies_support');
 $table->boolean('ldap_server_cert_ignore');
 });


//
// NOTE -- status_labels
// --------------------------------------------------

Schema::create('status_labels', function($table) {
 $table->increments('id')->unsigned();
 $table->string('name', 100);
 $table->integer('user_id');
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 $table->timestamp('deleted_at')->nullable();
 $table->boolean('deployable');
 $table->boolean('pending');
 $table->boolean('archived');
 $table->text('notes')->nullable();
 });


//
// NOTE -- suppliers
// --------------------------------------------------

Schema::create('suppliers', function($table) {
 $table->increments('id')->unsigned();
 $table->string('name', 255);
 $table->string('address', 50)->nullable();
 $table->string('address2', 50)->nullable();
 $table->string('city', 255)->nullable();
 $table->string('state', 32)->nullable();
 $table->string('country', 2)->nullable();
 $table->string('phone', 20)->nullable();
 $table->string('fax', 20)->nullable();
 $table->string('email', 150)->nullable();
 $table->string('contact', 100)->nullable();
 $table->string('notes', 255)->nullable();
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 $table->integer('user_id');
 $table->timestamp('deleted_at')->nullable();
 $table->string('zip', 10)->nullable();
 $table->string('url', 250)->nullable();
 $table->string('image', 255)->nullable();
 });


//
// NOTE -- throttle
// --------------------------------------------------

Schema::create('throttle', function($table) {
 $table->increments('id')->unsigned();
 $table->integer('user_id')->nullable()->unsigned();
 $table->string('ip_address', 255)->nullable();
 $table->integer('attempts');
 $table->boolean('suspended');
 $table->boolean('banned');
 $table->timestamp('last_attempt_at')->nullable();
 $table->timestamp('suspended_at')->nullable();
 $table->timestamp('banned_at')->nullable();
 });


//
// NOTE -- users
// --------------------------------------------------

Schema::create('users', function($table) {
 $table->increments('id')->unsigned();
 $table->string('email', 255)->nullable();
 $table->string('password', 255);
 $table->text('permissions')->nullable();
 $table->boolean('activated');
 $table->string('activation_code', 255)->nullable();
 $table->timestamp('activated_at')->nullable();
 $table->timestamp('last_login')->nullable();
 $table->string('persist_code', 255)->nullable();
 $table->string('reset_password_code', 255)->nullable();
 $table->string('first_name', 255);
 $table->string('last_name', 255);
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 $table->timestamp('deleted_at')->nullable();
 $table->string('website', 255)->nullable();
 $table->string('country', 255)->nullable();
 $table->string('gravatar', 255)->nullable();
 $table->integer('location_id')->nullable();
 $table->string('phone', 20)->nullable();
 $table->string('jobtitle', 100)->nullable();
 $table->integer('manager_id')->nullable();
 $table->text('employee_num')->nullable();
 $table->string('avatar', 255)->nullable();
 $table->string('username', 255)->nullable();
 $table->string('notes', 255)->nullable();
 $table->integer('company_id')->nullable()->unsigned();
 });


//
// NOTE -- users_groups
// --------------------------------------------------

Schema::create('users_groups', function($table) {
 $table->increments('user_id')->unsigned();
 $table->integer('group_id')->unsigned();
 });



}

//
// NOTE - Revert the changes to the database.
// --------------------------------------------------

public function down()
{

Schema::drop('accessories');
Schema::drop('accessories_users');
Schema::drop('asset_logs');
Schema::drop('asset_maintenances');
Schema::drop('asset_uploads');
Schema::drop('assets');
Schema::drop('categories');
Schema::drop('companies');
Schema::drop('consumables');
Schema::drop('consumables_users');
Schema::drop('custom_field_custom_fieldset');
Schema::drop('custom_fields');
Schema::drop('custom_fieldsets');
Schema::drop('depreciations');
Schema::drop('groups');
Schema::drop('history');
Schema::drop('license_seats');
Schema::drop('licenses');
Schema::drop('locations');
Schema::drop('manufacturers');
Schema::drop('models');
Schema::drop('requested_assets');
Schema::drop('requests');
Schema::drop('settings');
Schema::drop('status_labels');
Schema::drop('suppliers');
Schema::drop('throttle');
Schema::drop('users');
Schema::drop('users_groups');

}
}
