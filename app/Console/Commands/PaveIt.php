<?php

namespace App\Console\Commands;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Category;
use App\Models\Company;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\Department;
use App\Models\Depreciation;
use App\Models\Group;
use App\Models\Import;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Statuslabel;
use App\Models\Supplier;
use DB;
use Illuminate\Console\Command;

class PaveIt extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:pave
              {--soft : Perform a "Soft" Delete, leaving all migrations, table structure, and the first user in place.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pave the database to start over. This should ALMOST NEVER BE USED. (It is primarily a quick tool for developers.)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if ($this->confirm("\n****************************************************\nTHIS WILL DELETE ALL OF THE DATA IN YOUR DATABASE. \nThere is NO undo. This WILL destroy ALL of your data. \n****************************************************\n\nDo you wish to continue? No backsies! [y|N]")) {
            if ($this->option('soft')) {
                Accessory::getQuery()->delete();
                Asset::getQuery()->delete();
                Category::getQuery()->delete();
                Company::getQuery()->delete();
                Component::getQuery()->delete();
                Consumable::getQuery()->delete();
                Department::getQuery()->delete();
                Depreciation::getQuery()->delete();
                License::getQuery()->delete();
                LicenseSeat::getQuery()->delete();
                Location::getQuery()->delete();
                Manufacturer::getQuery()->delete();
                AssetModel::getQuery()->delete();
                Statuslabel::getQuery()->delete();
                Supplier::getQuery()->delete();
                Group::getQuery()->delete();
                Import::getQuery()->delete();

                DB::statement('delete from accessories_users');
                DB::statement('delete from asset_logs');
                DB::statement('delete from asset_maintenances');
                DB::statement('delete from login_attempts');
                DB::statement('delete from asset_uploads');
                DB::statement('delete from action_logs');
                DB::statement('delete from checkout_requests');
                DB::statement('delete from consumables_users');
                DB::statement('delete from custom_field_custom_fieldset');
                DB::statement('delete from custom_fields');
                DB::statement('delete from custom_fieldsets');
                DB::statement('delete from components_assets');
                DB::statement('delete from password_resets');
                DB::statement('delete from requested_assets');
                DB::statement('delete from requests');
                DB::statement('delete from throttle');
                DB::statement('delete from users_groups');
                DB::statement('delete from users WHERE id!=1');
            } else {
                \DB::statement('drop table IF EXISTS accessories_users');
                \DB::statement('drop table IF EXISTS accessories');
                \DB::statement('drop table IF EXISTS asset_logs');
                \DB::statement('drop table IF EXISTS action_logs');
                \DB::statement('drop table IF EXISTS asset_maintenances');
                \DB::statement('drop table IF EXISTS asset_uploads');
                \DB::statement('drop table IF EXISTS assets');
                \DB::statement('drop table IF EXISTS categories');
                \DB::statement('drop table IF EXISTS checkout_requests');
                \DB::statement('drop table IF EXISTS companies');
                \DB::statement('drop table IF EXISTS consumables_users');
                \DB::statement('drop table IF EXISTS consumables');
                \DB::statement('drop table IF EXISTS custom_field_custom_fieldset');
                \DB::statement('drop table IF EXISTS custom_fields');
                \DB::statement('drop table IF EXISTS custom_fieldsets');
                \DB::statement('drop table IF EXISTS depreciations');
                \DB::statement('drop table IF EXISTS departments');
                \DB::statement('drop table IF EXISTS groups');
                \DB::statement('drop table IF EXISTS history');
                \DB::statement('drop table IF EXISTS components');
                \DB::statement('drop table IF EXISTS components_assets');
                \DB::statement('drop table IF EXISTS license_seats');
                \DB::statement('drop table IF EXISTS licenses');
                \DB::statement('drop table IF EXISTS locations');
                \DB::statement('drop table IF EXISTS manufacturers');
                \DB::statement('drop table IF EXISTS models');
                \DB::statement('drop table IF EXISTS migrations');
                \DB::statement('drop table IF EXISTS oauth_access_tokens');
                \DB::statement('drop table IF EXISTS oauth_auth_codes');
                \DB::statement('drop table IF EXISTS oauth_clients');
                \DB::statement('drop table IF EXISTS oauth_personal_access_clients');
                \DB::statement('drop table IF EXISTS oauth_refresh_tokens');
                \DB::statement('drop table IF EXISTS password_resets');
                \DB::statement('drop table IF EXISTS requested_assets');
                \DB::statement('drop table IF EXISTS requests');
                \DB::statement('drop table IF EXISTS settings');
                \DB::statement('drop table IF EXISTS status_labels');
                \DB::statement('drop table IF EXISTS suppliers');
                \DB::statement('drop table IF EXISTS throttle');
                \DB::statement('drop table IF EXISTS users_groups');
                \DB::statement('drop table IF EXISTS users');
                \DB::statement('drop table IF EXISTS imports');
            }
        }
    }
}
