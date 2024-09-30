<?php

namespace Tests\Feature\Importing\Api;

use App\Models\Location;
use App\Models\User;
use Database\Factories\AssetFactory;
use Illuminate\Support\Str;
use Database\Factories\UserFactory;
use Database\Factories\ImportFactory;
use PHPUnit\Framework\Attributes\Test;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\TestResponse;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\Support\Importing\UsersImportFileBuilder as ImportFileBuilder;

class ImportUsersTest extends ImportDataTestCase
{
    use WithFaker;

    protected function importFileResponse(array $parameters = []): TestResponse
    {
        if (!array_key_exists('import-type', $parameters)) {
            $parameters['import-type'] = 'user';
        }

        return parent::importFileResponse($parameters);
    }

    #[Test]
    #[DataProvider('permissionsTestData')]
    public function onlyUserWithPermissionCanImportUsers(array|string $permissions): void
    {
        $permissions = collect((array) $permissions)
            ->map(fn (string $permission) => [$permission => '1'])
            ->toJson();

        $this->actingAsForApi(UserFactory::new()->create(['permissions' => $permissions]));

        $this->importFileResponse(['import' => 44])->assertForbidden();
    }

    #[Test]
    public function userWithImportAssetsPermissionCanImportUsers(): void
    {
        $this->actingAsForApi(UserFactory::new()->canImport()->create());

        $import = ImportFactory::new()->users()->create();

        $this->importFileResponse(['import' => $import->id])->assertOk();
    }

    #[Test]
    public function importUsers(): void
    {
        Notification::fake();

        $importFileBuilder = ImportFileBuilder::new();
        $row = $importFileBuilder->firstRow();
        $import = ImportFactory::new()->users()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id, 'send-welcome' => 1])
            ->assertOk()
            ->assertExactJson([
                'payload'  => null,
                'status'   => 'success',
                'messages' => ['redirect_url' => route('users.index')]
            ]);

        $newUser = User::query()
            ->with(['company', 'location'])
            ->where('username', $row['username'])
            ->sole();

        Notification::assertNothingSent();

        $this->assertEquals($newUser->email, $row['email']);
        $this->assertEquals($newUser->first_name, $row['firstName']);
        $this->assertEquals($newUser->last_name, $row['lastName']);
        $this->assertEquals($newUser->employee_num, $row['employeeNumber']);
        $this->assertEquals($newUser->company->name, $row['companyName']);
        $this->assertEquals($newUser->location->name, $row['location']);
        $this->assertEquals($newUser->phone, $row['phoneNumber']);
        $this->assertEquals($newUser->jobtitle, $row['position']);
        $this->assertTrue(Hash::isHashed($newUser->password));
        $this->assertEquals($newUser->website, '');
        $this->assertEquals($newUser->country, '');
        $this->assertEquals($newUser->address, '');
        $this->assertEquals($newUser->city, '');
        $this->assertEquals($newUser->state, '');
        $this->assertEquals($newUser->zip, '');
        $this->assertNull($newUser->permissions);
        $this->assertNull($newUser->avatar);
        $this->assertNull($newUser->notes);
        $this->assertNull($newUser->skin);
        $this->assertNull($newUser->department_id);
        $this->assertNull($newUser->two_factor_secret);
        $this->assertNull($newUser->idap_import);
        $this->assertEquals($newUser->locale, 'en-US');
        $this->assertEquals($newUser->show_in_list, 1);
        $this->assertEquals($newUser->two_factor_enrolled, 0);
        $this->assertEquals($newUser->two_factor_optin, 0);
        $this->assertEquals($newUser->remote, 0);
        $this->assertEquals($newUser->autoassign_licenses, 0);
        $this->assertEquals($newUser->vip, 0);
        $this->assertEquals($newUser->enable_sounds, 0);
        $this->assertEquals($newUser->enable_confetti, 0);
        $this->assertNull($newUser->created_by);
        $this->assertNull($newUser->start_date);
        $this->assertNull($newUser->end_date);
        $this->assertNull($newUser->scim_externalid);
        $this->assertNull($newUser->manager_id);
        $this->assertNull($newUser->activation_code);
        $this->assertNull($newUser->last_login);
        $this->assertNull($newUser->persist_code);
        $this->assertNull($newUser->reset_password_code);
        $this->assertEquals($newUser->activated, 0);
    }

    #[Test]
    public function willIgnoreUnknownColumnsWhenFileContainsUnknownColumns(): void
    {
        $row = ImportFileBuilder::new()->definition();
        $row['unknownColumnInCsvFile'] = 'foo';

        $importFileBuilder = new ImportFileBuilder([$row]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());

        $import = ImportFactory::new()->users()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->importFileResponse(['import' => $import->id])->assertOk();
    }

    #[Test]
    public function willNotCreateNewUserWhenUserWithUserNameAlreadyExist(): void
    {
        $user = UserFactory::new()->create(['username' => Str::random()]);
        $importFileBuilder = ImportFileBuilder::times(4)->replace(['username' => $user->username]);
        $import = ImportFactory::new()->users()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $probablyNewUsers = User::query()
            ->where('username', $user->username)
            ->get();

        $this->assertCount(1, $probablyNewUsers);
    }

    #[Test]
    public function willGenerateUsernameWhenUsernameFieldIsMissing(): void
    {
        $importFileBuilder = ImportFileBuilder::new()->forget('username');
        $row = $importFileBuilder->firstRow();
        $import = ImportFactory::new()->users()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id])->assertOk();

        $newUser = User::query()
            ->where('email', $row['email'])
            ->sole();

        $generatedUsername = User::generateFormattedNameFromFullName("{$row['firstName']} {$row['lastName']}")['username'];

        $this->assertEquals($newUser->username, $generatedUsername);
    }

    #[Test]
    public function willUpdateLocationOfAllAssetsAssignedToUser(): void
    {
        $user = UserFactory::new()->create(['username' => Str::random()]);
        $assetsAssignedToUser = AssetFactory::new()->create(['assigned_to' => $user->id, 'assigned_type' => User::class]);
        $importFileBuilder = ImportFileBuilder::new(['username' => $user->username]);
        $import = ImportFactory::new()->users()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id, 'import-update' => true])->assertOk();

        $userLocation = Location::query()->where('name', $importFileBuilder->firstRow()['location'])->sole(['id']);

        $this->assertEquals(
            $assetsAssignedToUser->refresh()->location_id,
            $userLocation->id
        );
    }

    #[Test]
    public function whenRequiredColumnsAreMissingInImportFile(): void
    {
        $importFileBuilder = ImportFileBuilder::new(['firstName' => ''])->forget(['username']);
        $import = ImportFactory::new()->users()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());

        $this->importFileResponse(['import' => $import->id])
            ->assertInternalServerError()
            ->assertExactJson([
                'status'   => 'import-errors',
                'payload'  => null,
                'messages' => [
                    '' => [
                        'User' => [
                            'first_name' => ['The first name field is required.'],
                        ]
                    ]
                ]
            ]);

        $newUsers = User::query()
            ->where('email', $importFileBuilder->firstRow()['email'])
            ->get();

        $this->assertCount(0, $newUsers);
    }

    #[Test]
    public function updateUserFromImport(): void
    {
        $user = UserFactory::new()->create(['username' => Str::random()])->refresh();
        $importFileBuilder = ImportFileBuilder::new(['username'  => $user->username]);

        $row = $importFileBuilder->firstRow();
        $import = ImportFactory::new()->users()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());
        $this->importFileResponse(['import' => $import->id, 'import-update' => true])->assertOk();

        $updatedUser = User::query()->with(['company', 'location'])->find($user->id);
        $updatedAttributes = [
            'first_name', 'email', 'last_name', 'employee_num', 'company',
            'location_id', 'company_id', 'updated_at', 'phone', 'jobtitle'
        ];

        $this->assertEquals($updatedUser->email, $row['email']);
        $this->assertEquals($updatedUser->first_name, $row['firstName']);
        $this->assertEquals($updatedUser->last_name, $row['lastName']);
        $this->assertEquals($updatedUser->employee_num, $row['employeeNumber']);
        $this->assertEquals($updatedUser->company->name, $row['companyName']);
        $this->assertEquals($updatedUser->location->name, $row['location']);
        $this->assertEquals($updatedUser->phone, $row['phoneNumber']);
        $this->assertEquals($updatedUser->jobtitle, $row['position']);
        $this->assertTrue(Hash::isHashed($updatedUser->password));

        $this->assertEquals(
            Arr::except($updatedUser->attributesToArray(), $updatedAttributes),
            Arr::except($user->attributesToArray(), $updatedAttributes),
        );
    }

    #[Test]
    public function customColumnMapping(): void
    {
        $faker = ImportFileBuilder::new()->definition();
        $row = [
            'companyName'    => $faker['username'],
            'email'          => $faker['position'],
            'employeeNumber' => $faker['phoneNumber'],
            'firstName'       => $faker['location'],
            'lastName'       => $faker['lastName'],
            'location'       => $faker['firstName'],
            'phoneNumber'    => $faker['employeeNumber'],
            'position'       => $faker['email'],
            'username'       => $faker['companyName'],
        ];

        $importFileBuilder = new ImportFileBuilder([$row]);
        $import = ImportFactory::new()->users()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(UserFactory::new()->superuser()->create());

        $this->importFileResponse([
            'import' => $import->id,
            'column-mappings' => [
                'Company'         => 'username',
                'email'           => 'jobtitle',
                'Employee Number' => 'phone_number',
                'First Name'      => 'location',
                'Last Name'       => 'last_name',
                'Location'        => 'first_name',
                'Phone Number'    => 'employee_num',
                'Job Title'       => 'email',
                'Username'        => 'company',
            ]
        ])->assertOk();

        $newUser = User::query()
            ->with(['company', 'location'])
            ->where('username', $row['companyName'])
            ->sole();

        $this->assertEquals($newUser->email, $row['position']);
        $this->assertEquals($newUser->first_name, $row['location']);
        $this->assertEquals($newUser->last_name, $row['lastName']);
        $this->assertEquals($newUser->jobtitle, $row['email']);
        $this->assertEquals($newUser->employee_num, $row['phoneNumber']);
        $this->assertEquals($newUser->company->name, $row['username']);
        $this->assertEquals($newUser->location->name, $row['firstName']);
        $this->assertEquals($newUser->phone, $row['employeeNumber']);
        $this->assertTrue(Hash::isHashed($newUser->password));
        $this->assertEquals($newUser->website, '');
        $this->assertEquals($newUser->country, '');
        $this->assertEquals($newUser->address, '');
        $this->assertEquals($newUser->city, '');
        $this->assertEquals($newUser->state, '');
        $this->assertEquals($newUser->zip, '');
        $this->assertNull($newUser->permissions);
        $this->assertNull($newUser->avatar);
        $this->assertNull($newUser->notes);
        $this->assertNull($newUser->skin);
        $this->assertNull($newUser->department_id);
        $this->assertNull($newUser->two_factor_secret);
        $this->assertNull($newUser->idap_import);
        $this->assertEquals($newUser->locale, 'en-US');
        $this->assertEquals($newUser->show_in_list, 1);
        $this->assertEquals($newUser->two_factor_enrolled, 0);
        $this->assertEquals($newUser->two_factor_optin, 0);
        $this->assertEquals($newUser->remote, 0);
        $this->assertEquals($newUser->autoassign_licenses, 0);
        $this->assertEquals($newUser->vip, 0);
        $this->assertEquals($newUser->enable_sounds, 0);
        $this->assertEquals($newUser->enable_confetti, 0);
        $this->assertNull($newUser->created_by);
        $this->assertNull($newUser->start_date);
        $this->assertNull($newUser->end_date);
        $this->assertNull($newUser->scim_externalid);
        $this->assertNull($newUser->manager_id);
        $this->assertNull($newUser->activation_code);
        $this->assertNull($newUser->last_login);
        $this->assertNull($newUser->persist_code);
        $this->assertNull($newUser->reset_password_code);
        $this->assertEquals($newUser->activated, 0);
    }
}
