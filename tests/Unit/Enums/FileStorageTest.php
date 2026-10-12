<?php

namespace Tests\Unit\Enums;

use App\Enums\FileStorage;
use App\Http\Controllers\Controller;
use Tests\TestCase;

class FileStorageTest extends TestCase
{
    public function test_public_only_cases_expose_public_paths_and_not_private(): void
    {
        $this->assertSame('avatars/', FileStorage::Avatars->publicPath());
        $this->assertSame('public/uploads/avatars', FileStorage::Avatars->publicDir());
        $this->assertNull(FileStorage::Avatars->privatePath());
        $this->assertNull(FileStorage::Avatars->privateDir());
    }

    public function test_private_only_cases_expose_private_paths_and_not_public(): void
    {
        $this->assertSame('signatures/', FileStorage::Signatures->privatePath());
        $this->assertSame('storage/private_uploads/signatures', FileStorage::Signatures->privateDir());
        $this->assertNull(FileStorage::Signatures->publicPath());
        $this->assertNull(FileStorage::Signatures->publicDir());
    }

    public function test_both_scope_cases_expose_both_paths(): void
    {
        // Assets split content across both scopes: public holds asset
        // pictures, private holds asset file attachments.
        $this->assertSame('assets/', FileStorage::Assets->publicPath());
        $this->assertSame('assets/', FileStorage::Assets->privatePath());
        $this->assertSame('public/uploads/assets', FileStorage::Assets->publicDir());
        $this->assertSame('storage/private_uploads/assets', FileStorage::Assets->privateDir());
    }

    public function test_public_dirs_enumeration_includes_barcodes_cache(): void
    {
        // Barcode cache dir has to be in the public enumeration so the
        // restore prunes stale QR / 1D barcode images that would
        // otherwise linger from the previous install.
        $this->assertContains('public/uploads/barcodes', FileStorage::publicDirs());
    }

    public function test_private_dirs_enumeration_includes_historical_aliases(): void
    {
        // Backups from older installs may carry old subdir names.
        // The restore maps them to their current destinations so the
        // files land correctly after the rename.
        $privateDirs = FileStorage::privateDirs();

        $this->assertArrayHasKey('storage/private_uploads/assetmodels', $privateDirs);
        $this->assertSame('storage/private_uploads/models', $privateDirs['storage/private_uploads/assetmodels']);

        $this->assertArrayHasKey('storage/private_uploads/asset_maintenances', $privateDirs);
        $this->assertSame('storage/private_uploads/maintenances', $privateDirs['storage/private_uploads/asset_maintenances']);
    }

    public function test_public_dirs_includes_every_public_scoped_case(): void
    {
        $publicDirs = FileStorage::publicDirs();
        foreach (FileStorage::cases() as $case) {
            if ($case->hasPublicScope()) {
                $this->assertContains($case->publicDir(), $publicDirs, "Public dir enumeration missing {$case->value}.");
            }
        }
    }

    public function test_private_dirs_includes_every_private_scoped_case(): void
    {
        $privateDirs = FileStorage::privateDirs();
        foreach (FileStorage::cases() as $case) {
            if ($case->hasPrivateScope()) {
                $this->assertContains($case->privateDir(), $privateDirs, "Private dir enumeration missing {$case->value}.");
            }
        }
    }

    public function test_backups_resolve_to_spatie_dir_not_private_uploads_tree(): void
    {
        $this->assertTrue(FileStorage::Backups->hasPrivateScope());
        $this->assertFalse(FileStorage::Backups->hasPublicScope());
        $this->assertSame('storage/app/backups', FileStorage::Backups->privateDir());
        $this->assertNull(FileStorage::Backups->publicDir());
    }

    public function test_backups_appear_in_full_private_dirs_enumeration(): void
    {
        // publicDirs() / privateDirs() are the authoritative "every dir
        // of that scope" list. Backups has to be here so a future caller
        // enumerating private storage locations sees it.
        $this->assertContains('storage/app/backups', FileStorage::privateDirs());
    }

    public function test_restore_filtered_enumerations_exclude_backups(): void
    {
        // The restore pruning passes must leave Spatie's backup directory
        // alone. Otherwise the archive being read from, plus every
        // sibling rollback point, would be wiped mid-restore.
        $this->assertNotContains('storage/app/backups', FileStorage::privateDirsForRestore());
        $this->assertNotContains('storage/app/backups', FileStorage::publicDirsForRestore());
    }

    public function test_restore_filtered_private_enumeration_still_contains_regular_private_cases(): void
    {
        $pruneable = FileStorage::privateDirsForRestore();
        $this->assertContains('storage/private_uploads/signatures', $pruneable);
        $this->assertContains('storage/private_uploads/users', $pruneable);
        $this->assertContains('storage/private_uploads/eula-pdfs', $pruneable);

        // Historical alias entries carry through as string-keyed pairs
        // because older archives still ship the old subdir names.
        $this->assertArrayHasKey('storage/private_uploads/assetmodels', $pruneable);
    }

    public function test_private_storage_key_resolves_to_default_disk_key_with_trailing_slash(): void
    {
        $this->assertSame('private_uploads/signatures/', FileStorage::Signatures->privateStorageKey());
        $this->assertSame('private_uploads/users/', FileStorage::Users->privateStorageKey());
        $this->assertSame('private_uploads/eula-pdfs/', FileStorage::EulaPdfs->privateStorageKey());
        $this->assertSame('private_uploads/accessories/', FileStorage::Accessories->privateStorageKey());
    }

    public function test_private_storage_key_special_cases_backups_outside_private_uploads(): void
    {
        // Backups live at storage/app/backups (Spatie's convention), not
        // under storage/app/private_uploads, so the default-disk key has
        // no private_uploads/ prefix.
        $this->assertSame('backups/', FileStorage::Backups->privateStorageKey());
    }

    public function test_private_storage_key_is_null_for_public_only_cases(): void
    {
        $this->assertNull(FileStorage::Avatars->privateStorageKey());
        $this->assertNull(FileStorage::Barcodes->privateStorageKey());
    }

    public function test_model_class_resolves_each_case_to_its_eloquent_owner(): void
    {
        $this->assertSame(\App\Models\Accessory::class, FileStorage::Accessories->modelClass());
        $this->assertSame(\App\Models\Asset::class, FileStorage::Assets->modelClass());
        $this->assertSame(\App\Models\Category::class, FileStorage::Categories->modelClass());
        $this->assertSame(\App\Models\Company::class, FileStorage::Companies->modelClass());
        $this->assertSame(\App\Models\Component::class, FileStorage::Components->modelClass());
        $this->assertSame(\App\Models\Consumable::class, FileStorage::Consumables->modelClass());
        $this->assertSame(\App\Models\Department::class, FileStorage::Departments->modelClass());
        $this->assertSame(\App\Models\License::class, FileStorage::Licenses->modelClass());
        $this->assertSame(\App\Models\Location::class, FileStorage::Locations->modelClass());
        $this->assertSame(\App\Models\Maintenance::class, FileStorage::Maintenances->modelClass());
        $this->assertSame(\App\Models\Manufacturer::class, FileStorage::Manufacturers->modelClass());
        $this->assertSame(\App\Models\Supplier::class, FileStorage::Suppliers->modelClass());
    }

    public function test_model_class_maps_rename_cases_to_their_owner(): void
    {
        // Avatars is the public case for the User model's avatar column,
        // Users is the private case for User's Files-tab uploads. Both
        // tie back to User despite the two case names.
        $this->assertSame(\App\Models\User::class, FileStorage::Avatars->modelClass());
        $this->assertSame(\App\Models\User::class, FileStorage::Users->modelClass());

        // Models is the public case for the AssetModel model's image.
        $this->assertSame(\App\Models\AssetModel::class, FileStorage::Models->modelClass());
    }

    public function test_every_mapped_storage_path_resolves_to_a_private_key(): void
    {
        // Regression test for #19808. Suppliers / Companies / Departments
        // appear in Controller::getMapStoragePath() for file attachments
        // but were missing from FileStorage::hasPrivateScope(), so
        // privateStorageKey() returned null and UploadedFilesController
        // crashed with a TypeError when uploading. Pin the invariant
        // that every entry in the controller map produces a usable path.
        foreach (Controller::getMapStoragePath() as $resource => $path) {
            $this->assertIsString($path, "No private storage key for '$resource'. Add HasUploads to the model, or add the case to FileStorage::NON_MODEL_PRIVATE_CASES.");
            $this->assertNotSame('', $path);
        }
    }

    public function test_every_has_uploads_model_resolves_to_a_private_file_storage_case(): void
    {
        // Walk every HasUploads model and confirm its FileStorage case is marked private.
        $hasUploadsModels = [];
        foreach (FileStorage::cases() as $case) {
            $model = $case->modelClass();
            if ($model === null) {
                continue;
            }
            if (in_array(\App\Models\Traits\HasUploads::class, class_uses_recursive($model), true)) {
                $hasUploadsModels[$model] = $case;
            }
        }

        $this->assertNotEmpty($hasUploadsModels, 'No HasUploads models mapped through FileStorage::modelClass(). Did the mapping drift?');

        foreach ($hasUploadsModels as $model => $case) {
            $this->assertTrue(
                $case->hasPrivateScope(),
                "Model $model uses HasUploads but FileStorage::{$case->name}->hasPrivateScope() returned false.",
            );
            $this->assertIsString($case->privateStorageKey());
        }
    }

    public function test_model_class_is_null_for_non_model_owned_cases(): void
    {
        // Signatures, EULA PDFs, audits, imports, backups, and the
        // barcode cache do not belong to a single parent model, so
        // modelClass() returns null for all of them. Callers iterating
        // cases to build a model->path map skip these.
        $this->assertNull(FileStorage::Audits->modelClass());
        $this->assertNull(FileStorage::Backups->modelClass());
        $this->assertNull(FileStorage::Barcodes->modelClass());
        $this->assertNull(FileStorage::EulaPdfs->modelClass());
        $this->assertNull(FileStorage::Imports->modelClass());
        $this->assertNull(FileStorage::Signatures->modelClass());
    }
}
