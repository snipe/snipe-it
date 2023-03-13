<?php

namespace App\Console\Commands;

use App\Models\Accessory;
use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\AssetMaintenance;
use App\Models\AssetModel;
use App\Models\Category;
use App\Models\CheckoutAcceptance;
use App\Models\CheckoutRequest;
use App\Models\Company;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\ConsumableAssignment;
use App\Models\CustomField;
use App\Models\CustomFieldset;
use App\Models\Department;
use App\Models\Depreciation;
use App\Models\Group;
use App\Models\Import;
use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\PredefinedKit;
use App\Models\SCIMUser;
use App\Models\Setting;
use App\Models\Statuslabel;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Console\Command;

class CountModels extends Command
{
    protected $signature = 'count-models';

    protected $description = 'Display the current counts for specific models';

    public function handle()
    {
        $this->table(['Model', 'Count'], [
            [Accessory::class, Accessory::count()],
            [Actionlog::class, Actionlog::count()],
            [Asset::class, Asset::count()],
            [AssetMaintenance::class, AssetMaintenance::count()],
            [AssetModel::class, AssetModel::count()],
            [Category::class, Category::count()],
            [CheckoutAcceptance::class, CheckoutAcceptance::count()],
            [CheckoutRequest::class, CheckoutRequest::count()],
            [Company::class, Company::count()],
            [Component::class, Component::count()],
            [Consumable::class, Consumable::count()],
            [ConsumableAssignment::class, ConsumableAssignment::count()],
            [CustomField::class, CustomField::count()],
            [CustomFieldset::class, CustomFieldset::count()],
            [Department::class, Department::count()],
            [Depreciation::class, Depreciation::count()],
            [Group::class, Group::count()],
            [Import::class, Import::count()],
            [License::class, License::count()],
            [LicenseSeat::class, LicenseSeat::count()],
            [Location::class, Location::count()],
            [Manufacturer::class, Manufacturer::count()],
            [PredefinedKit::class, PredefinedKit::count()],
            [SCIMUser::class, SCIMUser::count()],
            [Setting::class, Setting::count()],
            [Statuslabel::class, Statuslabel::count()],
            [Supplier::class, Supplier::count()],
            [User::class, User::count()],
        ]);

        return 0;
    }
}
