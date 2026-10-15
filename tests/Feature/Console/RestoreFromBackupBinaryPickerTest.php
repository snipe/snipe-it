<?php

namespace Tests\Feature\Console;

use App\Console\Commands\RestoreFromBackup;
use Tests\TestCase;

class RestoreFromBackupBinaryPickerTest extends TestCase
{
    private string $tmpDir;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tmpDir = sys_get_temp_dir().'/snipeit-restore-picker-'.uniqid();
        mkdir($this->tmpDir, 0755, true);
    }

    protected function tearDown(): void
    {
        array_map('unlink', glob($this->tmpDir.'/*') ?: []);
        rmdir($this->tmpDir);
        parent::tearDown();
    }

    private function makeBinary(string $name): void
    {
        touch($this->tmpDir.\DIRECTORY_SEPARATOR.$name.(\DIRECTORY_SEPARATOR === '\\' ? '.exe' : ''));
    }

    public function test_mariadb_driver_prefers_mariadb_binary(): void
    {
        $this->makeBinary('mysql');
        $this->makeBinary('mariadb');

        $picked = RestoreFromBackup::pickDbClientBinary('mariadb', $this->tmpDir);

        $this->assertSame($this->tmpDir.\DIRECTORY_SEPARATOR.'mariadb'.(\DIRECTORY_SEPARATOR === '\\' ? '.exe' : ''), $picked);
    }

    public function test_mysql_driver_prefers_mysql_binary(): void
    {
        $this->makeBinary('mysql');
        $this->makeBinary('mariadb');

        $picked = RestoreFromBackup::pickDbClientBinary('mysql', $this->tmpDir);

        $this->assertSame($this->tmpDir.\DIRECTORY_SEPARATOR.'mysql'.(\DIRECTORY_SEPARATOR === '\\' ? '.exe' : ''), $picked);
    }

    public function test_mariadb_driver_falls_back_to_mysql_binary_when_mariadb_missing(): void
    {
        $this->makeBinary('mysql');

        $picked = RestoreFromBackup::pickDbClientBinary('mariadb', $this->tmpDir);

        $this->assertSame($this->tmpDir.\DIRECTORY_SEPARATOR.'mysql'.(\DIRECTORY_SEPARATOR === '\\' ? '.exe' : ''), $picked);
    }

    public function test_mysql_driver_falls_back_to_mariadb_binary_when_mysql_missing(): void
    {
        $this->makeBinary('mariadb');

        $picked = RestoreFromBackup::pickDbClientBinary('mysql', $this->tmpDir);

        $this->assertSame($this->tmpDir.\DIRECTORY_SEPARATOR.'mariadb'.(\DIRECTORY_SEPARATOR === '\\' ? '.exe' : ''), $picked);
    }

    public function test_returns_null_when_no_binary_exists(): void
    {
        $picked = RestoreFromBackup::pickDbClientBinary('mysql', $this->tmpDir);

        $this->assertNull($picked);
    }

    public function test_trailing_separator_on_path_does_not_double(): void
    {
        $this->makeBinary('mariadb');

        $picked = RestoreFromBackup::pickDbClientBinary('mariadb', $this->tmpDir.\DIRECTORY_SEPARATOR);

        $this->assertSame($this->tmpDir.\DIRECTORY_SEPARATOR.'mariadb'.(\DIRECTORY_SEPARATOR === '\\' ? '.exe' : ''), $picked);
    }

    public function test_config_exposes_mariadb_connection_with_correct_driver(): void
    {
        $this->assertSame('mariadb', config('database.connections.mariadb.driver'));
    }

    public function test_public_files_covers_current_branding_upload_shape(): void
    {
        // Regression for #19503. ImageUploadRequest::handleImages produces
        // filenames like Setting-<field><id>-<random>.<ext> for the branding
        // fields, and the restore classifier uses strrpos (case-sensitive)
        // to match. Both cases must be present or the branding files get
        // silently dropped during restore.
        $this->assertContains('public/uploads/Setting-*', RestoreFromBackup::PUBLIC_FILES);
        $this->assertContains('public/uploads/setting-*', RestoreFromBackup::PUBLIC_FILES);
    }

    public function test_skip_ssl_is_absent_from_dump_config_by_default(): void
    {
        // Regression: spatie's processExtraDumpParameters iterates the dump
        // config and treats a `false` value as "call the setter with no args",
        // which for setSkipSsl(bool $x = true) silently sets skipSsl to TRUE.
        // The key must be absent from the array (not set to false) when opted
        // out, matching the old add_extra_option gating shape.
        $this->assertArrayNotHasKey('skip_ssl', config('database.connections.mysql.dump'));
        $this->assertArrayNotHasKey('skip_ssl', config('database.connections.mariadb.dump'));
        $this->assertArrayNotHasKey('add_extra_option', config('database.connections.mysql.dump'));
        $this->assertArrayNotHasKey('add_extra_option', config('database.connections.mariadb.dump'));
    }
}
