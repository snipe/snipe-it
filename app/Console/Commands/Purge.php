<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;
use \App\Models\Asset;
use \App\Models\AssetModel;
use \App\Models\Location;
use \App\Models\Company;
use \App\Models\License;
use \App\Models\Accessory;
use \App\Models\Component;
use \App\Models\Consumable;
use \App\Models\Category;
use \App\Models\User;
use \App\Models\Supplier;
use \App\Models\Manufacturer;
use \App\Models\Depreciation;
use \App\Models\StatusLabel;

class Purge extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:purge';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Purge all soft-deleted deleted records in the database. This will rewrite history for items that have been edited, or checked in or out. It will also reqrite history for users associated with deleted items.';

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

        if ($this->confirm("\n****************************************************\nTHIS WILL PURGE ALL SOFT-DELETED ITEMS IN YOUR SYSTEM. \nThere is NO undo. This WILL permanently destroy \nALL of your deleted data. \n****************************************************\n\nDo you wish to continue? No backsies! [y|N]")) {

            $assets = Asset::whereNotNull('deleted_at');

            foreach ($assets as $asset) {
                $asset->assetlog()->forceDelete();
            }

            $assets->forceDelete();

            $locations = Location::whereNotNull('deleted_at');
            $locations->forceDelete();

            $accessories = Accessory::whereNotNull('deleted_at');
            foreach ($accessories as $accessory) {
                $accessory->assetlog()->forceDelete();
            }
            $accessories->forceDelete();

            $consumables = Consumable::whereNotNull('deleted_at');
            foreach ($consumables as $consumable) {
                $consumable->assetlog()->forceDelete();
            }
            $consumables->forceDelete();

            $components = Component::whereNotNull('deleted_at');
            foreach ($components as $component) {
                $component->assetlog()->forceDelete();
            }
            $components->forceDelete();

            $licenses = License::whereNotNull('deleted_at');
            $licenses->forceDelete();

            $models = AssetModel::whereNotNull('deleted_at');
            $models->forceDelete();

            $categories = Category::whereNotNull('deleted_at');
            $categories->forceDelete();

            $suppliers = Supplier::whereNotNull('deleted_at');
            $suppliers->forceDelete();

            $users = User::whereNotNull('deleted_at');
            foreach ($users as $user) {
                $user->userlog()->forceDelete();
            }
            $users->forceDelete();

            $manufacturers = Manufacturer::whereNotNull('deleted_at');
            $manufacturers->forceDelete();

            $status_labels = StatusLabel::whereNotNull('deleted_at');
            $status_labels->forceDelete();



            // \DB::update('drop table IF EXISTS accessories_users');
            // \DB::statement('drop table IF EXISTS asset_logs');
            // \DB::statement('drop table IF EXISTS asset_maintenances');
            // \DB::statement('drop table IF EXISTS asset_uploads');
            // \DB::statement('drop table IF EXISTS consumables_users');
            // \DB::statement('drop table IF EXISTS groups');
            // //\DB::statement('drop table IF EXISTS history');
            // \DB::statement('drop table IF EXISTS license_seats');
            // \DB::statement('drop table IF EXISTS licenses');
            // \DB::statement('drop table IF EXISTS requested_assets');
            // \DB::statement('drop table IF EXISTS requests');
            // \DB::statement('drop table IF EXISTS users_groups');
            // \DB::statement('drop table IF EXISTS users');


        }

    }
}
