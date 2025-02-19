<?php namespace App\Providers;

use App\Models\Accessory;
use App\Models\Asset;
use App\Models\AssetModel;
use App\Models\Company;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\Department;
use App\Models\Depreciation;
use App\Models\Group;
use App\Models\License;
use App\Models\Location;
use App\Models\Manufacturer;
use App\Models\Statuslabel;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Support\ServiceProvider;
use Tabuna\Breadcrumbs\Breadcrumbs;
use Tabuna\Breadcrumbs\Trail;

class BreadcrumbsServiceProvider extends ServiceProvider
{
/**
* Handles the resource routes for first-class objects
*
* @return void
*/
    public function boot()
    {

        // Default home
        Breadcrumbs::for('home', fn (Trail $trail) =>
        $trail->push(trans('general.dashboard'), route('home'))
        );

        /**
         * Asset Breadcrumbs
         */
        Breadcrumbs::for('hardware.index', fn (Trail $trail) =>
            $trail->parent('home', route('home'))
                ->push(trans('general.assets'), route('hardware.index'))
        );

        Breadcrumbs::for('hardware.create', fn (Trail $trail) =>
        $trail->parent('hardware.index', route('hardware.index'))
        ->push(trans('general.create'), route('hardware.create'))
        );

        Breadcrumbs::for('hardware.show', fn (Trail $trail, Asset $asset) =>
        $trail->parent('hardware.index', route('hardware.index'))
            ->push('View '.$asset->asset_tag, route('home'))
        );

        Breadcrumbs::for('hardware.edit', fn (Trail $trail, Asset $asset) =>
        $trail->parent('hardware.index', route('hardware.index'))
            ->push('Edit asset: '.$asset->asset_tag, route('home'))
        );

        /**
         * Asset Model Breadcrumbs
         */
        Breadcrumbs::for('models.index', fn (Trail $trail) =>
        $trail->parent('home', route('home'))
            ->push(trans('general.asset_models'), route('models.index'))
        );

        Breadcrumbs::for('models.create', fn (Trail $trail) =>
        $trail->parent('models.index', route('models.index'))
            ->push(trans('general.create'), route('home'))
        );

        Breadcrumbs::for('models.show', fn (Trail $trail, AssetModel $model) =>
        $trail->parent('models.index', route('models.index'))
            ->push('View '.$model->name, route('home'))
        );

        Breadcrumbs::for('models.edit', fn (Trail $trail, AssetModel $model) =>
        $trail->parent('models.index', route('models.index'))
            ->push('Edit: '.$model->name, route('home'))
        );


        /**
         * Accessories Breadcrumbs
         */
        Breadcrumbs::for('accessories.index', fn (Trail $trail) =>
        $trail->parent('home', route('home'))
            ->push(trans('general.accessories'), route('accessories.index'))
        );

        Breadcrumbs::for('accessories.create', fn (Trail $trail) =>
        $trail->parent('accessories.index', route('accessories.index'))
            ->push(trans('general.create'), route('home'))
        );

        Breadcrumbs::for('accessories.show', fn (Trail $trail, Accessory $accessory) =>
        $trail->parent('accessories.index', route('accessories.index'))
            ->push('View '.$accessory->name, route('home'))
        );

        Breadcrumbs::for('accessories.edit', fn (Trail $trail, Accessory $accessory) =>
        $trail->parent('accessories.index', route('accessories.index'))
            ->push('Edit: '.$accessory->name, route('home'))
        );


        /**
         * Company Breadcrumbs
         */
        Breadcrumbs::for('companies.index', fn (Trail $trail) =>
        $trail->parent('home', route('home'))
            ->push(trans('general.companies'), route('companies.index'))
        );

        Breadcrumbs::for('companies.create', fn (Trail $trail) =>
        $trail->parent('companies.index', route('companies.index'))
            ->push(trans('general.create'), route('home'))
        );

        Breadcrumbs::for('companies.show', fn (Trail $trail, Company $company) =>
        $trail->parent('companies.index', route('companies.index'))
            ->push('View '.$company->name, route('home'))
        );

        Breadcrumbs::for('companies.edit', fn (Trail $trail, Company $company) =>
        $trail->parent('companies.index', route('companies.index'))
            ->push('Edit: '.$company->name, route('home'))
        );


        /**
         * Components Breadcrumbs
         */
        Breadcrumbs::for('components.index', fn (Trail $trail) =>
        $trail->parent('home', route('home'))
            ->push(trans('general.components'), route('components.index'))
        );

        Breadcrumbs::for('components.create', fn (Trail $trail) =>
        $trail->parent('components.index', route('components.index'))
            ->push(trans('general.create'), route('home'))
        );

        Breadcrumbs::for('components.show', fn (Trail $trail, Component $component) =>
        $trail->parent('components.index', route('components.index'))
            ->push('View '.$component->name, route('home'))
        );

        Breadcrumbs::for('components.edit', fn (Trail $trail, Component $component) =>
        $trail->parent('components.index', route('components.index'))
            ->push('Edit: '.$component->name, route('home'))
        );


        /**
         * Consumables Breadcrumbs
         */
        Breadcrumbs::for('consumables.index', fn (Trail $trail) =>
        $trail->parent('home', route('home'))
            ->push(trans('general.consumables'), route('consumables.index'))
        );

        Breadcrumbs::for('consumables.create', fn (Trail $trail) =>
        $trail->parent('consumables.index', route('consumables.index'))
            ->push(trans('general.create'), route('home'))
        );

        Breadcrumbs::for('consumables.show', fn (Trail $trail, Consumable $consumable) =>
        $trail->parent('consumables.index', route('consumables.index'))
            ->push('View '.$consumable->name, route('home'))
        );

        Breadcrumbs::for('consumables.edit', fn (Trail $trail, Consumable $consumable) =>
        $trail->parent('consumables.index', route('consumables.index'))
            ->push('Edit: '.$consumable->name, route('home'))
        );



        /**
         * Department Breadcrumbs
         */
        Breadcrumbs::for('departments.index', fn (Trail $trail) =>
        $trail->parent('home', route('home'))
            ->push(trans('general.departments'), route('departments.index'))
        );

        Breadcrumbs::for('departments.create', fn (Trail $trail) =>
        $trail->parent('departments.index', route('departments.index'))
            ->push(trans('general.create'), route('home'))
        );

        Breadcrumbs::for('departments.show', fn (Trail $trail, Department $department) =>
        $trail->parent('departments.index', route('departments.index'))
            ->push('View '.$department->name, route('home'))
        );

        Breadcrumbs::for('departments.edit', fn (Trail $trail, Department $department) =>
        $trail->parent('departments.index', route('departments.index'))
            ->push('Edit: '.$department->name, route('home'))
        );


        /**
         * Department Breadcrumbs
         */
        Breadcrumbs::for('depreciations.index', fn (Trail $trail) =>
        $trail->parent('home', route('home'))
            ->push(trans('general.depreciations'), route('depreciations.index'))
        );

        Breadcrumbs::for('depreciations.create', fn (Trail $trail) =>
        $trail->parent('depreciations.index', route('depreciations.index'))
            ->push(trans('general.create'), route('home'))
        );

        Breadcrumbs::for('depreciations.show', fn (Trail $trail, Depreciation $depreciation) =>
        $trail->parent('depreciations.index', route('depreciations.index'))
            ->push('View '.$depreciation->name, route('home'))
        );

        Breadcrumbs::for('depreciations.edit', fn (Trail $trail, Depreciation $depreciation) =>
        $trail->parent('depreciations.index', route('depreciations.index'))
            ->push('Edit: '.$depreciation->name, route('home'))
        );

        /**
         * Groups Breadcrumbs
         */
        Breadcrumbs::for('groups.index', fn (Trail $trail) =>
        $trail->parent('home', route('home'))
            ->push(trans('general.groups'), route('groups.index'))
        );

        Breadcrumbs::for('groups.create', fn (Trail $trail) =>
        $trail->parent('groups.index', route('groups.index'))
            ->push(trans('general.create'), route('home'))
        );

        Breadcrumbs::for('groups.show', fn (Trail $trail, Group $group) =>
        $trail->parent('groups.index', route('groups.index'))
            ->push('View '.$group->name, route('home'))
        );

        Breadcrumbs::for('groups.edit', fn (Trail $trail, Group $group) =>
        $trail->parent('groups.index', route('groups.index'))
            ->push('Edit: '.$group->name, route('home'))
        );



        /**
         * Licenses Breadcrumbs
         */
        Breadcrumbs::for('licenses.index', fn (Trail $trail) =>
        $trail->parent('home', route('home'))
            ->push(trans('general.licenses'), route('licenses.index'))
        );

        Breadcrumbs::for('licenses.create', fn (Trail $trail) =>
        $trail->parent('licenses.index', route('licenses.index'))
            ->push(trans('general.create'), route('home'))
        );

        Breadcrumbs::for('licenses.show', fn (Trail $trail, License $license) =>
        $trail->parent('licenses.index', route('licenses.index'))
            ->push('View '.$license->username, route('home'))
        );

        Breadcrumbs::for('licenses.edit', fn (Trail $trail, License $license) =>
        $trail->parent('licenses.index', route('licenses.index'))
            ->push('Edit: '.$license->username, route('home'))
        );

        /**
         * Locations Breadcrumbs
         */
        Breadcrumbs::for('locations.index', fn (Trail $trail) =>
        $trail->parent('home', route('home'))
            ->push(trans('general.locations'), route('locations.index'))
        );

        Breadcrumbs::for('locations.create', fn (Trail $trail) =>
        $trail->parent('locations.index', route('locations.index'))
            ->push(trans('general.create'), route('home'))
        );

        Breadcrumbs::for('locations.show', fn (Trail $trail, Location $location) =>
        $trail->parent('locations.index', route('locations.index'))
            ->push('View '.$location->name, route('home'))
        );

        Breadcrumbs::for('locations.edit', fn (Trail $trail, Location $location) =>
        $trail->parent('locations.index', route('locations.index'))
            ->push('Edit: '.$location->name, route('home'))
        );

        /**
         * Manufacturers Breadcrumbs
         */
        Breadcrumbs::for('manufacturers.index', fn (Trail $trail) =>
        $trail->parent('home', route('home'))
            ->push(trans('general.manufacturers'), route('manufacturers.index'))
        );

        Breadcrumbs::for('manufacturers.create', fn (Trail $trail) =>
        $trail->parent('manufacturers.index', route('manufacturers.index'))
            ->push(trans('general.create'), route('home'))
        );

        Breadcrumbs::for('manufacturers.show', fn (Trail $trail, Manufacturer $manufacturer) =>
        $trail->parent('manufacturers.index', route('manufacturers.index'))
            ->push('View '.$manufacturer->name, route('home'))
        );

        Breadcrumbs::for('manufacturers.edit', fn (Trail $trail, Manufacturer $manufacturer) =>
        $trail->parent('manufacturers.index', route('manufacturers.index'))
            ->push('Edit: '.$manufacturer->name, route('home'))
        );


        /**
         * Status Labels Breadcrumbs
         */
        Breadcrumbs::for('statuslabels.index', fn (Trail $trail) =>
        $trail->parent('home', route('home'))
            ->push(trans('general.status_labels'), route('statuslabels.index'))
        );

        Breadcrumbs::for('statuslabels.create', fn (Trail $trail) =>
        $trail->parent('statuslabels.index', route('statuslabels.index'))
            ->push(trans('general.create'), route('home'))
        );

        Breadcrumbs::for('statuslabels.show', fn (Trail $trail, Statuslabel $statuslabel) =>
        $trail->parent('statuslabels.index', route('statuslabels.index'))
            ->push('View '.$statuslabel->name, route('home'))
        );

        Breadcrumbs::for('statuslabels.edit', fn (Trail $trail, Statuslabel $statuslabel) =>
        $trail->parent('statuslabels.index', route('statuslabels.index'))
            ->push('Edit: '.$statuslabel->name, route('home'))
        );


        /**
         * Suppliers Breadcrumbs
         */
        Breadcrumbs::for('suppliers.index', fn (Trail $trail) =>
        $trail->parent('home', route('home'))
            ->push(trans('general.suppliers'), route('suppliers.index'))
        );

        Breadcrumbs::for('suppliers.create', fn (Trail $trail) =>
        $trail->parent('suppliers.index', route('suppliers.index'))
            ->push(trans('general.create'), route('home'))
        );

        Breadcrumbs::for('suppliers.show', fn (Trail $trail, Supplier $supplier) =>
        $trail->parent('suppliers.index', route('suppliers.index'))
            ->push('View '.$supplier->name, route('home'))
        );

        Breadcrumbs::for('suppliers.edit', fn (Trail $trail, Supplier $supplier) =>
        $trail->parent('suppliers.index', route('suppliers.index'))
            ->push('Edit: '.$supplier->name, route('home'))
        );



        /**
         * Users Breadcrumbs
         */
        Breadcrumbs::for('users.index', fn (Trail $trail) =>
        $trail->parent('home', route('home'))
            ->push(trans('general.users'), route('users.index'))
        );

        Breadcrumbs::for('users.create', fn (Trail $trail) =>
        $trail->parent('users.index', route('users.index'))
            ->push(trans('general.create'), route('home'))
        );

        Breadcrumbs::for('users.show', fn (Trail $trail, User $user) =>
        $trail->parent('users.index', route('users.index'))
            ->push('View '.$user->username, route('home'))
        );

        Breadcrumbs::for('users.edit', fn (Trail $trail, User $user) =>
        $trail->parent('users.index', route('users.index'))
            ->push('Edit: '.$user->username, route('home'))
        );



    }


}