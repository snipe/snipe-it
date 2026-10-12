<?php

namespace App\Enums;

use App\Models\Traits\HasUploads;

/**
 * Single source of truth for file-storage directory names across the app.
 *
 * Each case backs a directory subdir name. Scope methods declare
 * whether the directory lives under public, private, or both. Path /
 * directory accessors derive from the backing value plus the scope.
 *
 * Call sites use the enum cases directly rather than passing literal
 * strings, so IDE autocomplete / static analysis will catch typos:
 *
 *     FileStorage::Signatures->privatePath();
 *     FileStorage::Avatars->publicPath();
 *     FileStorage::publicDirs(); // for enumeration
 *     FileStorage::privateDirs();
 *
 * Models with image/avatar fields use the `HasImageUpload`
 * trait to declare their resource once and resolve the path via
 * `$model->imageUploadPath()`.
 */
enum FileStorage: string
{
    case Accessories = 'accessories';
    case Assets = 'assets';
    case Audits = 'audits';
    case Avatars = 'avatars';
    case Backups = 'backups';
    case Barcodes = 'barcodes';
    case Categories = 'categories';
    case Companies = 'companies';
    case Components = 'components';
    case Consumables = 'consumables';
    case Departments = 'departments';
    case EulaPdfs = 'eula-pdfs';
    case Imports = 'imports';
    case Licenses = 'licenses';
    case Locations = 'locations';
    case Maintenances = 'maintenances';
    case Manufacturers = 'manufacturers';
    case Models = 'models';
    case Signatures = 'signatures';
    case Suppliers = 'suppliers';
    case Users = 'users';

    /**
     * Historical private-tree directory renames. Backups from older
     * installs may carry the old subdir name. The restore maps old to
     * new so the files end up in the current directory.
     *
     * @var array<string, string>
     */
    private const PRIVATE_ALIASES = [
        'assetmodels' => 'models',
        'asset_maintenances' => 'maintenances',
    ];

    /**
     * Subdir names enumerated by publicDirs() / privateDirs() that the
     * restore command must leave untouched. Backups live here because
     * wiping storage/app/backups during a restore would race against
     * the archive being read and destroy sibling rollback points.
     * Entries match the enum backing value.
     *
     * @var array<int, string>
     */
    private const SKIP_IN_RESTORE_PRUNE = [
        'backups',
    ];

    public function hasPublicScope(): bool
    {
        return match ($this) {
            self::Accessories,
            self::Assets,
            self::Avatars,
            self::Barcodes,
            self::Categories,
            self::Companies,
            self::Components,
            self::Consumables,
            self::Departments,
            self::Locations,
            self::Maintenances,
            self::Manufacturers,
            self::Models,
            self::Suppliers => true,
            default => false,
        };
    }

    /**
     * Private cases without a parent model. Everything model-backed is
     * resolved by reflecting on HasUploads so adding the trait to a new
     * model is the only step needed to light up its file-upload path.
     */
    private const NON_MODEL_PRIVATE_CASES = [
        'audits',
        'backups',
        'eula-pdfs',
        'imports',
        'signatures',
    ];

    public function hasPrivateScope(): bool
    {
        if (in_array($this->value, self::NON_MODEL_PRIVATE_CASES, true)) {
            return true;
        }

        // Avatars is a public-only image alias for User. The private
        // attachment bucket for User lives in self::Users, so skip
        // Avatars before the trait check (which would otherwise mark
        // it private via User's HasUploads use).
        if ($this === self::Avatars) {
            return false;
        }

        $model = $this->modelClass();
        if ($model === null) {
            return false;
        }

        return in_array(HasUploads::class, class_uses_recursive($model), true);
    }

    /**
     * Public upload subdir with trailing slash, suitable for appending
     * a filename. Returns null when the resource has no public scope.
     */
    public function publicPath(): ?string
    {
        return $this->hasPublicScope() ? $this->value.'/' : null;
    }

    /**
     * Private upload subdir with trailing slash. Returns null when the
     * resource has no private scope.
     */
    public function privatePath(): ?string
    {
        return $this->hasPrivateScope() ? $this->value.'/' : null;
    }

    /**
     * Full public directory, relative to the repo root. For restore
     * extraction + pruning.
     */
    public function publicDir(): ?string
    {
        return $this->hasPublicScope() ? 'public/uploads/'.$this->value : null;
    }

    /**
     * Full private directory, relative to the repo root. For restore
     * extraction + pruning. Backups live under Spatie's normal
     * storage/app/backups rather than the private_uploads tree, which
     * every other private case uses.
     */
    public function privateDir(): ?string
    {
        if (! $this->hasPrivateScope()) {
            return null;
        }

        return match ($this) {
            self::Backups => 'storage/app/backups',
            default => 'storage/private_uploads/'.$this->value,
        };
    }

    /**
     * Storage facade key for the default disk (local root is storage/app),
     * with trailing slash. Suitable for appending a filename for
     * `Storage::put(...)`, `Storage::delete(...)`, etc. Backups return
     * `backups/` because they live directly under storage/app, every other
     * private case returns `private_uploads/<name>/`.
     */
    public function privateStorageKey(): ?string
    {
        if (! $this->hasPrivateScope()) {
            return null;
        }

        return match ($this) {
            self::Backups => 'backups/',
            default => 'private_uploads/'.$this->value.'/',
        };
    }

    /**
     * The Eloquent model class that owns files stored under this case, or
     * null when no single parent model does. Audits, Signatures, EulaPdfs,
     * Imports, and Backups return null because their files are not keyed
     * to a single parent (audits are tied to action_logs across all
     * assets, signatures / EULAs ride on acceptance records, imports are
     * admin-queued uploads not owned by a model, Backups is Spatie
     * output). Barcodes also returns null because that directory stores
     * generated label PNGs rather than user uploads.
     *
     * Closes the loop with `HasImageUpload`, which declares the inverse
     * (model -> FileStorage case) via `static::fileStorage()`.
     *
     * Returns a class string rather than a class-string<Model> union to
     * avoid pulling the Eloquent namespace into the enum layer.
     *
     * @return class-string|null
     */
    public function modelClass(): ?string
    {
        return match ($this) {
            self::Accessories => \App\Models\Accessory::class,
            self::Assets => \App\Models\Asset::class,
            self::Avatars, self::Users => \App\Models\User::class,
            self::Categories => \App\Models\Category::class,
            self::Companies => \App\Models\Company::class,
            self::Components => \App\Models\Component::class,
            self::Consumables => \App\Models\Consumable::class,
            self::Departments => \App\Models\Department::class,
            self::Licenses => \App\Models\License::class,
            self::Locations => \App\Models\Location::class,
            self::Maintenances => \App\Models\Maintenance::class,
            self::Manufacturers => \App\Models\Manufacturer::class,
            self::Models => \App\Models\AssetModel::class,
            self::Suppliers => \App\Models\Supplier::class,
            self::Audits, self::Backups, self::Barcodes, self::EulaPdfs, self::Imports, self::Signatures => null,
        };
    }

    /**
     * All public directories as a flat list. Format matches what
     * RestoreFromBackup's extraction + pruning loops consume.
     *
     * @return list<string>
     */
    public static function publicDirs(): array
    {
        $out = [];
        foreach (self::cases() as $case) {
            if ($case->hasPublicScope()) {
                $out[] = $case->publicDir();
            }
        }

        return $out;
    }

    /**
     * All private directories, including historical aliases mapped to
     * their current destinations.
     * Integer keys for straight entries, string keys for alias =>
     * destination.
     *
     * @return array<int|string, string>
     */
    public static function privateDirs(): array
    {
        $out = [];
        $privateNames = [];
        foreach (self::cases() as $case) {
            if ($case->hasPrivateScope()) {
                $out[] = $case->privateDir();
                $privateNames[$case->value] = true;
            }
        }
        foreach (self::PRIVATE_ALIASES as $old => $new) {
            if (isset($privateNames[$new])) {
                $out['storage/private_uploads/'.$old] = 'storage/private_uploads/'.$new;
            }
        }

        return $out;
    }

    /**
     * Public directories excluding those in SKIP_IN_RESTORE_PRUNE.
     * Only RestoreFromBackup should reach for this. Any other caller
     * that wants the full public enumeration uses publicDirs().
     *
     * @return list<string>
     */
    public static function publicDirsForRestore(): array
    {
        return array_values(array_filter(
            self::publicDirs(),
            fn (string $dir) => ! in_array(basename($dir), self::SKIP_IN_RESTORE_PRUNE, true),
        ));
    }

    /**
     * Private directories excluding those in SKIP_IN_RESTORE_PRUNE.
     * Alias entries are matched by their alias key, not their
     * destination value, because the alias key is what carries the
     * on-disk subdir name of a historical backup.
     *
     * @return array<int|string, string>
     */
    public static function privateDirsForRestore(): array
    {
        return array_filter(
            self::privateDirs(),
            fn (string $dir, int|string $key) => ! in_array(
                basename(is_string($key) ? $key : $dir),
                self::SKIP_IN_RESTORE_PRUNE,
                true,
            ),
            ARRAY_FILTER_USE_BOTH,
        );
    }
}
