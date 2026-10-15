<?php

namespace Tests\Support;

use App\Models\SyncAdapterInstance;
use App\SyncAdapters\SyncAdapter;
use Illuminate\Support\Str;

/**
 * Seed one row in sync_adapter_instances per shipped adapter type
 * (Fleet, Kandji, etc.) at test-setup time.
 *
 */
trait SeedsShippedSyncAdapters
{
    public function seedShippedSyncAdapters(): void
    {
        foreach (SyncAdapter::allTypes() as $slug => $class) {
            SyncAdapterInstance::create([
                'slug' => $slug,
                'adapter_type' => $slug,
                'label' => $class::typeLabel() ?: Str::title(str_replace('_', ' ', $slug)),
                'active' => false,
            ]);
        }
    }
}
