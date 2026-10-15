<?php

namespace Tests\Unit\Helpers;

use App\Helpers\StorageHelper;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StorageHelperTest extends TestCase
{
    public function test_readable_path_returns_null_when_file_missing(): void
    {
        Storage::fake('public');

        $this->assertNull(StorageHelper::readablePath('does-not-exist.png'));
    }

    public function test_readable_path_returns_direct_disk_path_on_local_driver(): void
    {
        $disk = Storage::fake('public');
        $disk->put('logos/site-logo.png', 'PNGDATA');

        $result = StorageHelper::readablePath('logos/site-logo.png');

        $this->assertSame($disk->path('logos/site-logo.png'), $result);
        $this->assertFileExists($result);
        $this->assertSame('PNGDATA', file_get_contents($result));
    }

    public function test_readable_path_materializes_to_temp_file_on_non_local_driver(): void
    {
        // Storage::fake registers a local-backed disk. Overriding the driver
        // config to 's3' exercises the non-local branch while the underlying
        // Flysystem adapter still functions normally for reads.
        $disk = Storage::fake('public');
        Config::set('filesystems.disks.public.driver', 's3');
        $disk->put('companies/acme.jpg', 'JPEGBYTES');

        $result = StorageHelper::readablePath('companies/acme.jpg');

        $this->assertIsString($result);
        $this->assertNotSame($disk->path('companies/acme.jpg'), $result);
        $this->assertStringEndsWith('.jpg', $result);
        $this->assertFileExists($result);
        $this->assertSame('JPEGBYTES', file_get_contents($result));

        @unlink($result);
    }

    public function test_readable_path_preserves_missing_extension_on_non_local_driver(): void
    {
        // getimagesize() sniffs by content, not extension, when the extension
        // is absent, so we should still return a usable temp file.
        $disk = Storage::fake('public');
        Config::set('filesystems.disks.public.driver', 's3');
        $disk->put('blobs/nofext', 'RAW');

        $result = StorageHelper::readablePath('blobs/nofext');

        $this->assertIsString($result);
        $this->assertFileExists($result);
        $this->assertSame('RAW', file_get_contents($result));
        $this->assertDoesNotMatchRegularExpression('/\.[a-z0-9]+$/i', basename($result));

        @unlink($result);
    }
}
