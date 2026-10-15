<?php

namespace App\Providers;

use App\Enums\FileStorage;
use App\Models\Setting;
use Illuminate\Support\ServiceProvider;

/**
 * This service provider shares `$snipeSettings` with every view and
 * registers legacy `{resource}_upload_path` / `{resource}_upload_url`
 * singletons that Blade templates and a handful of callers resolve via
 * `app('users_upload_path')` and similar.
 *
 * The directory values are now sourced from `FileStorage` so there
 * is one authoritative map, and the previous duplicate binding of
 * `accessories_upload_path` (defined twice with conflicting values
 * before the migration) is naturally gone.
 */
class SettingsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Share common setting variables with all views.
        view()->composer('*', function ($view) {
            $view->with('snipeSettings', Setting::getSettings());
            $view->with('settings', Setting::getSettings());
        });

        // Legacy upload-path singletons, now derived from FileStorage.
        // Keep the `{resource}_upload_path` singleton name shape because
        // call sites across Blade and a few controllers resolve them by
        // string key. New callers should reach for `FileStorage` cases
        // directly rather than adding more legacy keys here.
        $publicPathMap = [
            'accessories_upload_path' => FileStorage::Accessories,
            'assets_upload_path' => FileStorage::Assets,
            'audits_upload_path' => FileStorage::Audits,
            'categories_upload_path' => FileStorage::Categories,
            'companies_upload_path' => FileStorage::Companies,
            'components_upload_path' => FileStorage::Components,
            'consumables_upload_path' => FileStorage::Consumables,
            'departments_upload_path' => FileStorage::Departments,
            'locations_upload_path' => FileStorage::Locations,
            'maintenances_upload_path' => FileStorage::Maintenances,
            'manufacturers_upload_path' => FileStorage::Manufacturers,
            'models_upload_path' => FileStorage::Models,
            'suppliers_upload_path' => FileStorage::Suppliers,
            // The user's own avatar directory is historically named
            // `avatars/`, not `users/`, so this singleton points at the
            // Avatars case rather than Users. `users_upload_url` (below)
            // keeps the legacy `users/` value for the handful of Blade
            // call sites that pre-date the enum.
            'users_upload_path' => FileStorage::Avatars,
        ];
        foreach ($publicPathMap as $key => $case) {
            app()->singleton($key, fn () => $case->publicPath());
        }

        // Legacy `_upload_url` singletons. These historically used the
        // same subdir name as the path for everything except users,
        // which pointed at the URL segment `users/` rather than the
        // storage dir `avatars/`. Audits does not appear in the url
        // map because audits is a private-only resource (eula-pdfs is
        // the companion exclusion). Everything else mirrors publicPath.
        $publicUrlMap = [
            'accessories_upload_url' => FileStorage::Accessories,
            'assets_upload_url' => FileStorage::Assets,
            'categories_upload_url' => FileStorage::Categories,
            'companies_upload_url' => FileStorage::Companies,
            'components_upload_url' => FileStorage::Components,
            'consumables_upload_url' => FileStorage::Consumables,
            'departments_upload_url' => FileStorage::Departments,
            'licenses_upload_url' => FileStorage::Licenses,
            'locations_upload_url' => FileStorage::Locations,
            'maintenances_upload_url' => FileStorage::Maintenances,
            'manufacturers_upload_url' => FileStorage::Manufacturers,
            'models_upload_url' => FileStorage::Models,
            'suppliers_upload_url' => FileStorage::Suppliers,
        ];
        foreach ($publicUrlMap as $key => $case) {
            app()->singleton($key, fn () => $case->value.'/');
        }

        // Users URL is the one historical outlier - it's the URL
        // segment `users/`, not the storage path `avatars/`.
        app()->singleton('users_upload_url', fn () => 'users/');

        // Legacy standalone singletons that don't fit the resource map.
        app()->singleton('eula_pdf_path', fn () => 'eula_pdf_path/');

        // Legacy short-form alias. `resources/views/maintenances/edit.blade.php`
        // resolves this instead of the `maintenances_upload_path` long form.
        app()->singleton('maintenances_path', fn () => FileStorage::Maintenances->publicPath());

        // Set the monetary locale to the configured locale to make helper::parseFloat work.
        setlocale(LC_MONETARY, config('app.locale'));
        setlocale(LC_NUMERIC, config('app.locale'));
    }

    public function register() {}
}
