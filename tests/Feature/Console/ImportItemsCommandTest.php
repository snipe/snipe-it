<?php

namespace Tests\Feature\Console;

use Tests\TestCase;
use App\Models\User;
use App\Models\Asset;
use App\Models\License;
use App\Models\Accessory;
use App\Models\AssetModel;
use App\Models\Component;
use App\Models\Consumable;
use Illuminate\Testing\PendingCommand;
use PHPUnit\Framework\Attributes\Test;
use Tests\Support\Importing\CleansUpImportFiles;
use Tests\Support\Importing\UsersImportFileBuilder;
use Tests\Support\Importing\AssetsImportFileBuilder;
use Tests\Support\Importing\LicensesImportFileBuilder;
use Tests\Support\Importing\ComponentsImportFileBuilder;
use Tests\Support\Importing\AccessoriesImportFileBuilder;
use Tests\Support\Importing\AssetModelsImportFileBuilder;
use Tests\Support\Importing\ConsumablesImportFileBuilder;

class ImportItemsCommandTest extends TestCase
{
    use CleansUpImportFiles;

    /**
     * @inheritdoc
     */
    protected function setUp(): void
    {
        parent::setUp();

        //Create the default importer if not exist.
        if (User::query()->find(1) === null) {
            User::factory()->createOne(['id' => 1]);
        }
    }

    #[Test]
    public function importItems(): void
    {
        $accessoriesFile = AccessoriesImportFileBuilder::new();
        $assetsFile = AssetsImportFileBuilder::new();
        $componentsFile = ComponentsImportFileBuilder::new();
        $consumablesFile = ConsumablesImportFileBuilder::new();
        $licensesFile = LicensesImportFileBuilder::new();
        $usersFile = UsersImportFileBuilder::new();
        $assetModelFile = AssetModelsImportFileBuilder::new();

        $this->runCommand(['filename' => $this->getPath($assetsFile->saveToImportsDirectory())])->assertOk();
        $this->runCommand(['filename' => $this->getPath($accessoriesFile->saveToImportsDirectory()), '--item-type' => 'Accessory'])->assertOk();
        $this->runCommand(['filename' => $this->getPath($componentsFile->saveToImportsDirectory()), '--item-type' => 'component'])->assertOk();
        $this->runCommand(['filename' => $this->getPath($consumablesFile->saveToImportsDirectory()), '--item-type' => 'Consumable'])->assertOk();
        $this->runCommand(['filename' => $this->getPath($licensesFile->saveToImportsDirectory()), '--item-type' => 'License'])->assertOk();
        $this->runCommand(['filename' => $this->getPath($usersFile->saveToImportsDirectory()), '--item-type' => 'user'])->assertOk();
        $this->runCommand(['filename' => $this->getPath($assetModelFile->saveToImportsDirectory()), '--item-type' => 'assetModel'])->assertOk();

        $this->assertTrue(Accessory::query()->where('name', $accessoriesFile->firstRow()['itemName'])->exists());
        $this->assertTrue(Asset::query()->where('serial', $assetsFile->firstRow()['serialNumber'])->exists());
        $this->assertTrue(Component::query()->where('name', $componentsFile->firstRow()['itemName'])->exists());
        $this->assertTrue(Consumable::query()->where('name', $consumablesFile->firstRow()['itemName'])->exists());
        $this->assertTrue(License::query()->where('serial', $licensesFile->firstRow()['serialNumber'])->exists());
        $this->assertTrue(User::query()->where('username', $usersFile->firstRow()['username'])->exists());
        $this->assertTrue(AssetModel::query()->where('name', $assetModelFile->firstRow()['name'])->exists());
    }

    protected function runCommand(array $parameters = []): PendingCommand
    {
        return $this->artisan('snipeit:import', $parameters);
    }

    #[Test]
    public function willReturnFailedWhenFilenameIsNotProvided(): void
    {
        $this->expectExceptionMessage('Not enough arguments (missing: "filename").');

        $this->runCommand();
    }

    #[Test]
    public function willReturnFailedWhenImportFileDoesNotExits(): void
    {
        $this->runCommand(['filename' => 'foo.csv'])
            ->expectsOutput('file "foo.csv" not found.')
            ->assertFailed();

        $this->runCommand(['filename' => $dir = __DIR__])
            ->expectsOutput("file \"{$dir}\" not found.")
            ->assertFailed();
    }

    #[Test]
    public function willReturnFailedWhenImportTypeIsInvalid(): void
    {
        $filename = AssetsImportFileBuilder::times()->saveToImportsDirectory();

        $this->runCommand(['--item-type' => 'foo', 'filename' => $this->getPath($filename)])
            ->expectsOutput('The selected item-type is invalid.')
            ->assertFailed();
    }

    private function getPath(string $filename): string
    {
        return config('app.private_uploads') . "/imports/{$filename}";
    }

    #[Test]
    public function willReturnFailedWhenUserIdIsInvalid(): void
    {
        $filename = AssetsImportFileBuilder::times()->saveToImportsDirectory();

        $this->runCommand(['--user_id' => 'foo', 'filename' => $this->getPath($filename)])
            ->expectsOutput('The user id field must be an integer.')
            ->assertFailed();

        $this->runCommand(['--user_id' => '-1', 'filename' => $this->getPath($filename)])
            ->expectsOutput('The user id field must be at least 1.')
            ->assertFailed();
    }

    #[Test]
    public function willReturnFailedWhenUserDoesNotExists(): void
    {
        $expectedOutput = 'The selected user id is invalid.';
        $filename = AssetsImportFileBuilder::times()->saveToImportsDirectory();
        [$softDeletedUser, $deletedUser] = User::factory()->createMany(2);

        $softDeletedUser->delete();
        $deletedUser->forceDelete();

        $this->runCommand(['--user_id' => "{$softDeletedUser->id}", 'filename' => $this->getPath($filename)])
            ->expectsOutput($expectedOutput)
            ->assertFailed();

        $this->runCommand(['--user_id' => "{$deletedUser->id}", 'filename' => $this->getPath($filename)])
            ->expectsOutput($expectedOutput)
            ->assertFailed();
    }

    #[Test]
    public function willReturnFailedWhenUsernameFormatIsInvalid(): void
    {
        $filename = AssetsImportFileBuilder::times()->saveToImportsDirectory();

        $this->runCommand(['--username_format' => 'foo', 'filename' => $this->getPath($filename)])
            ->expectsOutput('The selected username format is invalid.')
            ->assertFailed();
    }

    #[Test]
    public function willReturnFailedWhenEmailFormatIsInvalid(): void
    {
        $filename = AssetsImportFileBuilder::times()->saveToImportsDirectory();

        $this->runCommand(['--email_format' => 'foo', 'filename' => $this->getPath($filename)])
            ->expectsOutput('The selected email format is invalid.')
            ->assertFailed();
    }

    #[Test]
    public function willReturnFailedWhenFileTypeIsNotSupported(): void
    {
        $this->runCommand(['filename' => __FILE__])->expectsOutput('The given file type is not supported.');
    }
}
