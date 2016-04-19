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

            /**
             * Delete assets
             */
            $assets = Asset::whereNotNull('deleted_at')->withTrashed()->get();
            $assetcount = $assets->count();
            $this->info($assets->count().' assets purged.');
            $asset_assoc = 0;

            foreach ($assets as $asset) {
                $this->info('- Asset "'.$asset->showAssetName().'" deleted.');
                $asset_assoc += $asset->assetlog()->count();
                $asset->assetlog()->forceDelete();
                $asset->forceDelete();
            }

            $this->info($asset_assoc.' corresponding log records purged.');

            $locations = Location::whereNotNull('deleted_at')->withTrashed()->get();
            $this->info($locations->count().' locations purged.');
            $locations->forceDelete();


            $accessories = Accessory::whereNotNull('deleted_at')->withTrashed()->get();
            foreach ($accessories as $accessory) {
                $accessory->assetlog()->forceDelete();
            }
            $accessories->forceDelete();

            $consumables = Consumable::whereNotNull('deleted_at')->withTrashed()->get();
            foreach ($consumables as $consumable) {
                $consumable->assetlog()->forceDelete();
            }
            $consumables->forceDelete();

            $components = Component::whereNotNull('deleted_at')->withTrashed()->get();
            foreach ($components as $component) {
                $component->assetlog()->forceDelete();
            }
            $components->forceDelete();

            $licenses = License::whereNotNull('deleted_at')->withTrashed()->get();
            $licenses->forceDelete();

            $models = AssetModel::whereNotNull('deleted_at')->withTrashed()->get();
            $models->forceDelete();

            $categories = Category::whereNotNull('deleted_at')->withTrashed()->get();
            $categories->forceDelete();

            $suppliers = Supplier::whereNotNull('deleted_at')->withTrashed()->get();
            $suppliers->forceDelete();

            $users = User::whereNotNull('deleted_at')->withTrashed()->get();
            $this->info($users->count().' users purged.');
            $user_assoc = 0;
            foreach ($users as $user) {
                $this->info('- User "'.$user->username.'" deleted.');
                $user_assoc += $user->userlog()->count();
                $user->userlog()->forceDelete();
                $user->forceDelete();
            }
            $this->info($user_assoc.' corresponding log records purged.');

            $manufacturers = Manufacturer::whereNotNull('deleted_at')->withTrashed()->get();
            $manufacturers->forceDelete();

            $status_labels = StatusLabel::whereNotNull('deleted_at')->withTrashed()->get();
            $status_labels->forceDelete();


        } else {
            $this->info('Action canceled. Nothing was purged.');
        }

    }
}
