<?php

namespace App\Console\Commands;


use Illuminate\Console\Command;
use App\Models\Asset;
use App\Models\Actionlog;
use App\Models\Accessory;
use App\Models\AssetModel;
use App\Models\AssetMaintenance;
use App\Models\Category;
use App\Models\Company;
use App\Models\Consumable;
use App\Models\Component;
use App\Models\License;
use App\Models\CustomField;
use App\Models\CustomFieldset;
use App\Models\Department;
use App\Models\Depreciation;
use App\Models\Group;
use App\Models\Import;
use App\Models\LicenseSeat;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Statuslabel;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use DB;

class DemoData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'snipeit:demo-seed {--username=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will seed the Snipe-IT database with realistic-looking data. ';

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


        if (config('app.env')=='production') {
            $this->error('This action cannot be performed on a production system.');
            $this->info('If you wish to reset a production system, please put your');
            $this->info('app into develop mode. This is for your protection.');
            return false;
        }

        if ($this->confirm("!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! WARNING !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!\n This will overwrite your existing database. Do you wish to continue?")) {


            $this->dropRealCustomFieldsColumns();
            $this->dropAndCreateCategories();
            $this->dropAndCreateManufacturers();
            $this->dropAndCreateLocations();
            $this->dropAndCreateActionlogs();
            $this->dropAndCreateAssetModels();
            $this->dropAndCreateStatusLabels();
            $this->dropAndCreateAssets();
            $this->dropAndCreateDepreciations();
            $this->dropAndCreateSuppliers();
            $this->dropAndCreateAccessories();
            $this->dropAndCreateLicenses();
            $this->dropAndCreateComponents();
            $this->dropAndCreateConsumables();


            Import::truncate();
            AssetMaintenance::truncate();
            Group::truncate();
            Company::truncate();
            CustomField::truncate();
            Group::truncate();
            CustomFieldset::truncate();
            Department::truncate();
            User::where('username', '!=', 'snipe')
                ->where('username', '!=', 'admin')
                ->forceDelete();
            DB::table('custom_field_custom_fieldset')->truncate();
            DB::table('checkout_requests')->truncate();


        }


    }


    public function dropAndCreateAssets() {

        Asset::truncate();

        $assets = [

            // Assets
            [
                'id' => 1,
                'user_id' => 1,
                'name' => 'Brady Laptop',
                'model_id' => 1,
                'assigned_to' => null,
                'assigned_type' => null,
                'purchase_cost' => '3025.56',
                'purchase_date' => date('Y-m-d'),
                'supplier_id' => rand(1,4),
                'status_id' => 1,
                'rtd_location_id' =>  rand(1,4),
                'serial' => self::generateRandomString(),
                'asset_tag' => '1000341'
            ],

            [
                'id' => 2,
                'user_id' => 1,
                'name' => 'Alison Laptop',
                'model_id' => 1,
                'assigned_to' => null,
                'assigned_type' => null,
                'purchase_cost' => '3025.56',
                'purchase_date' => date('Y-m-d'),
                'supplier_id' => rand(1,4),
                'status_id' => 1,
                'rtd_location_id' =>  rand(1,4),
                'serial' => self::generateRandomString(),
                'asset_tag' => '1000342'
            ],

            [
                'id' => 3,
                'user_id' => 1,
                'name' => 'Frontdesk Laptop',
                'model_id' => 1,
                'assigned_to' => null,
                'assigned_type' => null,
                'purchase_cost' => '3025.56',
                'purchase_date' => date('Y-m-d'),
                'supplier_id' => rand(1,4),
                'status_id' => 2,
                'rtd_location_id' =>  rand(1,4),
                'serial' => self::generateRandomString(),
                'asset_tag' => '1000343'
            ],

            [
                'id' => 4,
                'user_id' => 1,
                'name' => null,
                'model_id' => 2,
                'assigned_to' => 1,
                'assigned_type' => User::class,
                'purchase_cost' => '3025.56',
                'purchase_date' => date('Y-m-d'),
                'supplier_id' => rand(1,4),
                'status_id' => 1,
                'rtd_location_id' =>  rand(1,4),
                'serial' => self::generateRandomString(),
                'asset_tag' => '1000344'
            ],
            [
                'id' => 5,
                'user_id' => 1,
                'name' => null,
                'model_id' => 3,
                'assigned_to' => 1,
                'assigned_type' => User::class,
                'purchase_cost' => '3025.56',
                'purchase_date' => date('Y-m-d'),
                'supplier_id' => rand(1,4),
                'status_id' => 1,
                'rtd_location_id' =>  rand(1,4),
                'serial' => self::generateRandomString(),
                'asset_tag' => '1000345'
            ],
            [
                'id' => 6,
                'user_id' => 1,
                'name' => 'Backroom Desktop',
                'model_id' => 3,
                'assigned_to' => 2,
                'assigned_type' => Location::class,
                'purchase_cost' => '3025.56',
                'purchase_date' => date('Y-m-d'),
                'supplier_id' => rand(1,4),
                'status_id' => 1,
                'rtd_location_id' =>  rand(1,4),
                'serial' => self::generateRandomString(),
                'asset_tag' => '1000346'
            ],
            [
                'id' => 7,
                'user_id' => 1,
                'name' => 'Lobby Laptop',
                'model_id' => 4,
                'assigned_to' => 2,
                'assigned_type' => Location::class,
                'purchase_cost' => '3025.56',
                'purchase_date' => date('Y-m-d'),
                'supplier_id' => rand(1,4),
                'status_id' => 1,
                'rtd_location_id' =>  rand(1,4),
                'serial' => self::generateRandomString(),
                'asset_tag' => '1000347'
            ],

            [
                'id' => 8,
                'user_id' => 1,
                'name' => 'Conference Room A Polycom',
                'model_id' => 11,
                'assigned_to' => 2,
                'assigned_type' => Location::class,
                'purchase_cost' => '3025.56',
                'purchase_date' => date('Y-m-d'),
                'supplier_id' => rand(1,4),
                'status_id' => 1,
                'rtd_location_id' =>  rand(1,4),
                'serial' => self::generateRandomString(),
                'asset_tag' => '1000348'
            ],

            [
                'id' => 9,
                'user_id' => 1,
                'name' => null,
                'model_id' => 12,
                'assigned_to' => null,
                'assigned_type' => null,
                'purchase_cost' => '799.56',
                'purchase_date' => date('Y-m-d'),
                'supplier_id' => rand(1,4),
                'status_id' => 1,
                'rtd_location_id' =>  rand(1,4),
                'serial' => self::generateRandomString(),
                'asset_tag' => '1000349'
            ],
            [
                'id' => 10,
                'user_id' => 1,
                'name' => null,
                'model_id' => 13,
                'assigned_to' => 1,
                'assigned_type' => User::class,
                'purchase_cost' => '799.56',
                'purchase_date' => date('Y-m-d'),
                'supplier_id' => rand(1,4),
                'status_id' => 1,
                'rtd_location_id' =>  rand(1,4),
                'serial' => self::generateRandomString(),
                'asset_tag' => '1000310'
            ],
            [
                'id' => 11,
                'user_id' => 1,
                'name' => null,
                'model_id' => 14,
                'assigned_to' => null,
                'assigned_type' => null,
                'purchase_cost' => '899.56',
                'purchase_date' => date('Y-m-d'),
                'supplier_id' => rand(1,4),
                'status_id' => 1,
                'rtd_location_id' =>  rand(1,4),
                'serial' => self::generateRandomString(),
                'asset_tag' => '1000311'
            ],


        ];

        // Create assets
        DB::table('assets')->insert($assets);
        return $assets;

    }

    public function dropAndCreateManufacturers() {

        Manufacturer::truncate();

        $manufacturers = [

            // Asset Manufacturers
            [
                'id' => 1,
                'user_id' => 1,
                'name' => 'Apple',
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'name' => 'Microsoft',
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'name' => 'Dell',
            ],
            [
                'id' => 4,
                'user_id' => 1,
                'name' => 'Asus',
            ],
            [
                'id' => 5,
                'user_id' => 1,
                'name' => 'HP',
            ],
            [
                'id' => 6,
                'user_id' => 1,
                'name' => 'Lenovo',
            ],
            [
                'id' => 7,
                'user_id' => 1,
                'name' => 'LG',
            ],
            [
                'id' => 8,
                'user_id' => 1,
                'name' => 'Polycom',
            ],
            [
                'id' => 9,
                'user_id' => 1,
                'name' => 'Adobe',
            ],

        ];

        // Create Manufacturers
        DB::table('manufacturers')->insert($manufacturers);
        return $manufacturers;
        
    }


    public function dropAndCreateSuppliers() {

        Supplier::truncate();

        $supppliers = [
            [
                'id' => 1,
                'user_id' => 1,
                'name' => 'Best Buy',
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'name' => 'Frys',
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'name' => 'New Egg',
            ],
            [
                'id' => 4,
                'user_id' => 1,
                'name' => 'Mikes Tech Shop',
            ],
        ];

        // Create Depreciations
        DB::table('suppliers')->insert($supppliers);
        return $supppliers;
    }


    public function dropAndCreateDepreciations() {

        Depreciation::truncate();

        $depreciations = [
            [
                'id' => 1,
                'months' => 36,
                'user_id' => 1,
                'name' => 'Computers Depreciation',
            ],
            [
                'id' => 2,
                'months' => 24,
                'user_id' => 1,
                'name' => 'Mobile Phone Depreciation',
            ],
        ];

        // Create Depreciations
        DB::table('depreciations')->insert($depreciations);
        return $depreciations;
    }


    public function dropAndCreateAssetModels() {

        AssetModel::truncate();

        $models = [

            // Asset models
            [
                'id' => 1,
                'user_id' => 1,
                'manufacturer_id' => 1,
                'depreciation_id' => 1,
                'category_id' => 1,
                'name' => 'Macbook Pro Retina 13"',
                'eol' => 36,
                'notes' => 'Created by demo seeder',
                'model_number' => rand(111111,99999)
            ],

            [
                'id' => 2,
                'user_id' => 1,
                'manufacturer_id' => 1,
                'depreciation_id' => 1,
                'category_id' => 1,
                'name' => 'Macbook Air',
                'eol' => 36,
                'notes' => 'Created by demo seeder',
                'model_number' => rand(111111,99999)
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'manufacturer_id' => 1,
                'depreciation_id' => 1,
                'category_id' => 2,
                'name' => 'iMac Pro',
                'eol' => 36,
                'notes' => 'Created by demo seeder',
                'model_number' => rand(111111,99999)
            ],
            [
                'id' => 4,
                'user_id' => 1,
                'manufacturer_id' => 2,
                'depreciation_id' => 1,
                'category_id' => 1,
                'name' => 'Surface Pro',
                'eol' => 36,
                'notes' => 'Created by demo seeder',
                'model_number' => rand(111111,99999)
            ],
            [
                'id' => 5,
                'user_id' => 1,
                'manufacturer_id' => 3,
                'depreciation_id' => 1,
                'category_id' => 1,
                'name' => 'XPS 13',
                'eol' => 36,
                'notes' => 'Created by demo seeder',
                'model_number' => rand(111111,99999)
            ],
            [
                'id' => 6,
                'user_id' => 1,
                'manufacturer_id' => 4,
                'depreciation_id' => 1,
                'category_id' => 1,
                'name' => 'ZenBook UX310',
                'eol' => 36,
                'notes' => 'Created by demo seeder',
                'model_number' => rand(111111,99999)
            ],
            [
                'id' => 7,
                'user_id' => 1,
                'manufacturer_id' => 5,
                'depreciation_id' => 1,
                'category_id' => 1,
                'name' => 'Spectre',
                'eol' => 36,
                'notes' => 'Created by demo seeder',
                'model_number' => rand(111111,99999)
            ],
            [
                'id' => 8,
                'user_id' => 1,
                'manufacturer_id' => 6,
                'depreciation_id' => 1,
                'category_id' => 1,
                'name' => 'Yoga 910',
                'eol' => 36,
                'notes' => 'Created by demo seeder',
                'model_number' => rand(111111,99999)
            ],
            [
                'id' => 9,
                'user_id' => 1,
                'manufacturer_id' => 7,
                'depreciation_id' => 1,
                'category_id' => 4,
                'name' => '4G Ultrafine',
                'eol' => 24,
                'notes' => 'Created by demo seeder',
                'model_number' => rand(111111,99999)
            ],
            [
                'id' => 10,
                'user_id' => 1,
                'manufacturer_id' => 5,
                'depreciation_id' => 1,
                'category_id' => 4,
                'name' => '20.7" LED FHD Monitor - Black',
                'eol' => 24,
                'notes' => 'Created by demo seeder',
                'model_number' => rand(111111,99999)
            ],
            [
                'id' => 11,
                'user_id' => 1,
                'manufacturer_id' => 8,
                'depreciation_id' => 1,
                'category_id' => 7,
                'name' => 'Soundstation 2',
                'eol' => 24,
                'notes' => 'Created by demo seeder',
                'model_number' => rand(111111,99999)
            ],
            [
                'id' => 12,
                'user_id' => 1,
                'manufacturer_id' => 1,
                'depreciation_id' => 2,
                'category_id' => 3,
                'name' => 'iPhone 6S',
                'eol' => 36,
                'notes' => 'Created by demo seeder',
                'model_number' => rand(111111,99999)
            ],
            [
                'id' => 13,
                'user_id' => 1,
                'manufacturer_id' => 1,
                'depreciation_id' => 2,
                'category_id' => 5,
                'name' => 'iPad Pro',
                'eol' => 36,
                'notes' => 'Created by demo seeder',
                'model_number' => rand(111111,99999)
            ],
            [
                'id' => 14,
                'user_id' => 1,
                'manufacturer_id' => 1,
                'depreciation_id' => 2,
                'category_id' => 3,
                'name' => 'iPhone 7',
                'eol' => 36,
                'notes' => 'Created by demo seeder',
                'model_number' => rand(111111,99999)
            ],

        ];

        // Create Models
        DB::table('models')->insert($models);
        return $models;
    }
    public function dropAndCreateCategories() {

        Category::truncate();
        $categories = [

            [
                'id' => 1,
                'name' => 'Laptops',
                'category_type' => 'asset',
                'require_acceptance' => rand(0,1)
            ],

            [
                'id' => 2,
                'name' => 'Desktops',
                'category_type' => 'asset',
                'require_acceptance' => rand(0,1)
            ],

            [
                'id' => 3,
                'name' => 'Mobile Phones',
                'category_type' => 'asset',
                'require_acceptance' => rand(0,1)
            ],

            [
                'id' => 4,
                'name' => 'Displays',
                'category_type' => 'asset',
                'require_acceptance' => rand(0,1)
            ],

            [
                'id' => 5,
                'name' => 'Tablets',
                'category_type' => 'asset',
                'require_acceptance' => rand(0,1)
            ],

            [
                'id' => 6,
                'name' => 'VOIP Phones',
                'category_type' => 'asset',
                'require_acceptance' => rand(0,1)
            ],

            [
                'id' => 7,
                'name' => 'Conference Phones',
                'category_type' => 'asset',
                'require_acceptance' => rand(0,1)
            ],

            // Accessory categories: 8-9
            [
                'id' => 8,
                'name' => 'Keyboard',
                'category_type' => 'accessory',
                'require_acceptance' => rand(0,1)
            ],

            [
                'id' => 9,
                'name' => 'Mouse',
                'category_type' => 'accessory',
                'require_acceptance' => rand(0,1)
            ],
            [
                'id' => 10,
                'name' => 'Printer Paper',
                'category_type' => 'consumable',
                'require_acceptance' => 0,
            ],
            [
                'id' => 11,
                'name' => 'Printer Toner',
                'category_type' => 'consumable',
                'require_acceptance' => 0,
            ],
            [
                'id' => 12,
                'name' => 'RAM',
                'category_type' => 'component',
                'require_acceptance' => 0,
            ],
            [
                'id' => 13,
                'name' => 'Hard Drives',
                'category_type' => 'component',
                'require_acceptance' => 0,
            ],


        ];


        // Create Categories
        DB::table('categories')->insert($categories);
        return $categories;
    }

    public function dropAndCreateLocations() {

        Location::truncate();

        $locations = [

            // Locations
            [
                'id' => 1,
                'user_id' => 1,
                'name' => 'San Diego HQ',
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'name' => 'Ocean Beach HQ',
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'name' => 'Point Loma HQ',
            ],
            [
                'id' => 4,
                'user_id' => 1,
                'name' => 'Pacific Beach HQ',
            ],
        ];

        // Create Locations
        DB::table('locations')->insert($locations);
        return $locations;

    }

    public function dropAndCreateLicenses() {

        License::truncate();
        LicenseSeat::truncate();

        $licenses = [

            // Licenses
            [
                'id' => 1,
                'user_id' => 1,
                'name' => 'Adobe Acrobat Pro',
                'serial' => self::generateRandomString(),
                'purchase_cost' => '99.99',
                'license_name' => 'Alison Gianotto',
                'license_email' => 'foo@example.com',
                'depreciate' => 0,
                'supplier_id' => 1,
                'manufacturer_id' => 9,
                'seats' => rand(2,20),
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'name' => 'Adobe Photoshop',
                'serial' => self::generateRandomString(),
                'purchase_cost' => '299.99',
                'license_name' => 'Alison Gianotto',
                'license_email' => 'foo@example.com',
                'depreciate' => 0,
                'supplier_id' => 1,
                'manufacturer_id' => 9,
                'seats' => rand(2,20),
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'name' => 'Garageband',
                'serial' => self::generateRandomString(),
                'purchase_cost' => '39.99',
                'license_name' => 'Alison Gianotto',
                'license_email' => 'foo@example.com',
                'depreciate' => 0,
                'supplier_id' => 1,
                'manufacturer_id' => 1,
                'seats' => rand(2,20),
            ],
            [
                'id' => 4,
                'user_id' => 1,
                'name' => 'Office',
                'serial' => self::generateRandomString(),
                'purchase_cost' => '39.99',
                'license_name' => 'Alison Gianotto',
                'license_email' => 'foo@example.com',
                'depreciate' => 0,
                'supplier_id' => 1,
                'manufacturer_id' => 2,
                'seats' => rand(2,20),
            ],

        ];

        // Create Licenses
        DB::table('licenses')->insert($licenses);

        foreach ($licenses as $license) {
            $license_seats =
                [
                    'license_id' => $license['id'],
                    'notes' => 'Created by demo seeder',
                    'user_id' => 1
                ];

            for ($x=0; $x < $license['seats']; $x++) {
                DB::table('license_seats')->insert($license_seats);
            }


        }
        return $licenses;

    }

    public function dropAndCreateAccessories() {

        Accessory::truncate();
        DB::table('accessories_users')->truncate();


        $accessories = [

            // Accessories
            [
                'id' => 1,
                'user_id' => 1,
                'name' => 'Bluetooth Keyboard',
                'category_id' => 8,
                'manufacturer_id' => 1,
                'location_id' => 1,
                'model_number' => rand(123,12345677),
                'purchase_cost' => '99.99',
                'qty' => 10,
                'min_amt' => 2,
            ],
            [
                'id' => 2,
                'user_id' => 1,
                'name' => 'USB Keyboard',
                'category_id' => 8,
                'manufacturer_id' => 1,
                'location_id' => 1,
                'model_number' => rand(123,12345677),
                'purchase_cost' => '69.99',
                'qty' => 5,
                'min_amt' => 1,
            ],
            [
                'id' => 3,
                'user_id' => 1,
                'name' => 'Magic Mouse 2',
                'category_id' => 9,
                'manufacturer_id' => 1,
                'location_id' => 2,
                'model_number' => rand(123,12345677),
                'purchase_cost' => '59.99',
                'qty' => 15,
                'min_amt' => 2,
            ],
            [
                'id' => 4,
                'user_id' => 1,
                'name' => 'Sculpt Comfort Mouse',
                'category_id' => 9,
                'manufacturer_id' => 2,
                'location_id' => 3,
                'model_number' => rand(123,12345677),
                'purchase_cost' => '24.99',
                'qty' => 10,
                'min_amt' => 2,
            ],
        ];

        // Create Locations
        DB::table('accessories')->insert($accessories);
        return $accessories;

    }



    public function dropAndCreateComponents() {

        Component::truncate();
        DB::table('components_assets')->truncate();

        $components = [

            // Components
            [
                'id' => 1,
                'user_id' => 1,
                'name' => 'Seagate 1TB',
                'category_id' => 12,
                'location_id' => 1,
                'purchase_cost' => '99.99',
                'qty' => 10,
                'min_amt' => 2,
            ],

        ];

        // Create Locations
        DB::table('components')->insert($components);
        return $components;

    }


    public function dropAndCreateConsumables() {

        Consumable::truncate();
        DB::table('consumables_users')->truncate();

        $consumables = [

            // Consumables
            [
                'id' => 1,
                'user_id' => 1,
                'name' => 'Bone White Cardstock',
                'category_id' => 10,
                'location_id' => 1,
                'purchase_cost' => '29.99',
                'qty' => 10,
                'min_amt' => 2,
            ],


        ];

        // Create Locations
        DB::table('consumables')->insert($consumables);
        return $consumables;

    }


    public function dropAndCreateActionlogs() {

        Actionlog::truncate();

        $action_logs = [

            // Action logs
            [
                'user_id' => 1,
                'action_type' => 'checkout',
                'target_id' => 1,
                'target_type' => User::class,
                'item_type' => Asset::class,
                'item_id' => 4,
                'created_at' => date('Y-m-d'),
                'note' => 'Created by demo seeder',
            ],
            [
                'user_id' => 1,
                'action_type' => 'checkout',
                'target_id' => 1,
                'target_type' => User::class,
                'item_type' => Asset::class,
                'item_id' => 5,
                'created_at' => date('Y-m-d'),
                'note' => 'Created by demo seeder',
            ],
            [
                'user_id' => 1,
                'action_type' => 'checkout',
                'target_id' => 2,
                'target_type' => Location::class,
                'item_type' => Asset::class,
                'item_id' => 5,
                'created_at' => date('Y-m-d'),
                'note' => 'Created by demo seeder',
            ],
            [
                'user_id' => 1,
                'action_type' => 'checkout',
                'target_id' => 2,
                'target_type' => Location::class,
                'item_type' => Asset::class,
                'item_id' => 7,
                'created_at' => date('Y-m-d'),
                'note' => 'Created by demo seeder',
            ],
            [
                'user_id' => 1,
                'action_type' => 'checkout',
                'target_id' => 2,
                'target_type' => Location::class,
                'item_type' => Asset::class,
                'item_id' => 8,
                'created_at' => date('Y-m-d'),
                'note' => 'Created by demo seeder',
            ],
            [
                'user_id' => 1,
                'action_type' => 'checkin from',
                'target_id' => 2,
                'target_type' => Location::class,
                'item_type' => Asset::class,
                'item_id' => 8,
                'created_at' => date('Y-m-d'),
                'note' => 'Created by demo seeder',
            ],
            [
                'user_id' => 1,
                'action_type' => 'checkout',
                'target_id' => 2,
                'target_type' => Location::class,
                'item_type' => Asset::class,
                'item_id' => 8,
                'created_at' => date('Y-m-d'),
                'note' => 'Created by demo seeder',
            ],

        ];

        // Create Logs
        DB::table('action_logs')->insert($action_logs);
        return $action_logs;
    }

    public function dropAndCreateStatusLabels() {

        Statuslabel::truncate();

        $statuslabels = [

            // Status Labels
            [
                'id' => 1,
                'user_id' => 1,
                'name' => 'New - Ready for Deployment',
                'deployable' => 1,
                'pending' => 0,
                'archived' => 0,
                'notes' => 'Created by demo seeder',

            ],

            // Status Labels
            [
                'id' => 2,
                'user_id' => 1,
                'name' => 'Awaiting Repair',
                'deployable' => 0,
                'pending' => 1,
                'archived' => 0,
                'notes' => 'Created by demo seeder',

            ],

            // Status Labels
            [
                'id' => 3,
                'user_id' => 1,
                'name' => 'Archived - Keep for Records',
                'deployable' => 0,
                'pending' => 0,
                'archived' => 1,
                'notes' => 'Created by demo seeder',

            ],

            // Status Labels
            [
                'id' => 4,
                'user_id' => 1,
                'name' => 'Broken - Not Fixable',
                'deployable' => 0,
                'pending' => 0,
                'archived' => 1,
                'notes' => 'Created by demo seeder',

            ],


        ];

        // Create status labels
        DB::table('status_labels')->insert($statuslabels);
        return $statuslabels;
    }

    public function dropRealCustomFieldsColumns() {
        // delete custom field columns on the asset table
        $fields = Customfield::all();
        foreach ($fields as $field) {
            if ($field->db_column!='') {
                $this->info('Dropping DB column: '.$field->db_column);
                Schema::table('assets', function (Blueprint $table) {
                    $table->dropColumn($field->db_column);
                });
            }
        }
    }

    public function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }


}
