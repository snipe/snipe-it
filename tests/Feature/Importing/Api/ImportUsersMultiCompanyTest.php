<?php

namespace Tests\Feature\Importing\Api;

use App\Models\Company;
use App\Models\Import;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use Tests\Support\Importing\CleansUpImportFiles;
use Tests\Support\Importing\UsersImportFileBuilder as ImportFileBuilder;

class ImportUsersMultiCompanyTest extends ImportDataTestCase
{
    use CleansUpImportFiles;

    protected function importFileResponse(array $parameters = []): TestResponse
    {
        if (! array_key_exists('import-type', $parameters)) {
            $parameters['import-type'] = 'user';
        }

        return parent::importFileResponse($parameters);
    }

    public function test_pipe_separated_company_names_create_multiple_pivot_entries()
    {
        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $importFileBuilder = ImportFileBuilder::new([
            'companyName' => $companyA->name.'|'.$companyB->name,
        ]);

        $row = $importFileBuilder->firstRow();
        $import = Import::factory()->users()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(User::factory()->superuser()->create());

        $this->importFileResponse(['import' => $import->id])
            ->assertOk();

        $user = User::where('username', $row['username'])->firstOrFail();

        $this->assertCount(2, $user->companies, 'User should belong to both pipe-separated companies');
        $this->assertTrue($user->companies->contains($companyA));
        $this->assertTrue($user->companies->contains($companyB));
    }

    public function test_pipe_separated_companies_create_new_companies_when_not_found()
    {
        $importFileBuilder = ImportFileBuilder::new([
            'companyName' => 'Acme Corp|Widget Inc',
        ]);

        $row = $importFileBuilder->firstRow();
        $import = Import::factory()->users()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(User::factory()->superuser()->create());

        $this->importFileResponse(['import' => $import->id])
            ->assertOk();

        $user = User::where('username', $row['username'])->firstOrFail();

        $this->assertCount(2, $user->companies, 'User should belong to two newly-created companies');

        $names = $user->companies->pluck('name')->all();
        $this->assertContains('Acme Corp', $names);
        $this->assertContains('Widget Inc', $names);
    }

    public function test_single_company_name_without_pipe_works_as_before()
    {
        $company = Company::factory()->create();

        $importFileBuilder = ImportFileBuilder::new([
            'companyName' => $company->name,
        ]);

        $row = $importFileBuilder->firstRow();
        $import = Import::factory()->users()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(User::factory()->superuser()->create());

        $this->importFileResponse(['import' => $import->id])
            ->assertOk();

        $user = User::where('username', $row['username'])->firstOrFail();

        $this->assertCount(1, $user->companies);
        $this->assertTrue($user->companies->contains($company));
    }

    public function test_blank_company_column_leaves_user_without_companies()
    {
        $importFileBuilder = ImportFileBuilder::new([
            'companyName' => '',
        ]);

        $row = $importFileBuilder->firstRow();
        $import = Import::factory()->users()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi(User::factory()->superuser()->create());

        $this->importFileResponse(['import' => $import->id])
            ->assertOk();

        $user = User::where('username', $row['username'])->firstOrFail();

        $this->assertCount(0, $user->companies, 'Blank company column should leave user with no companies');
    }

    public function test_non_superuser_cannot_create_floater_user_via_import()
    {
        // #19200: non-superuser importing a new user with no resolvable
        // company while floater mode is on would have minted a floater
        // account — exploitable via the welcome-email + activated columns
        // to hand the attacker valid credentials. Importer must skip the row
        // and leave no user behind.
        $this->settings->enableFloaterMode();

        $importerCompany = Company::factory()->create();
        $importer = $importerCompany->users()->save(
            User::factory()->editUsers()->createUsers()->canImport()->create(),
        );

        $importFileBuilder = ImportFileBuilder::new(['companyName' => '']);
        $row = $importFileBuilder->firstRow();
        $import = Import::factory()->users()->create(['file_path' => $importFileBuilder->saveToImportsDirectory()]);

        $this->actingAsForApi($importer)
            ->importFileResponse(['import' => $import->id]);

        $this->assertDatabaseMissing('users', [
            'username' => $row['username'],
        ]);
    }

    /**
     * GHSA-wwp4-qx8p-62g8 regression coverage for the CSV importer.
     *
     * Before the fix, the importer's update branch used a raw
     * $user->companies()->sync($companyIds), which strips any target
     * pivot rows for companies not in the submitted set. A scoped
     * importer running the interactive Livewire path could re-import a
     * co-tenant target with only their own company in the row and
     * silently detach the target from co-companies the importer never
     * saw. The fix routes the update branch through
     * User::syncCompaniesPreservingInvisibleTo, which reads the target's
     * pivot unscoped, splits into visible + invisible-to-editor, and
     * merges the invisible slice back before syncing.
     */
    public function test_importer_update_preserves_target_memberships_editor_cannot_see()
    {
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();

        [$companyA, $companyB] = Company::factory()->count(2)->create();

        $target = User::factory()->create();
        $target->companies()->sync([$companyA->id, $companyB->id]);

        $scopedImporter = User::factory()->canImport()->forCompany($companyA)->create();

        // Drop the auto-generated location column: under strict FMCS, a
        // companied non-superuser can't create a new null-company Location
        // via the importer (fmcs_company rule on Location.company_id
        // rejects it), and the test isn't about that constraint.
        $importFileBuilder = ImportFileBuilder::new([
            'username' => $target->username,
            'companyName' => $companyA->name,
        ])->forget('location');
        // created_by must be the acting user or the process endpoint refuses
        // the request (ImportController security control that prevents an
        // import-permission holder from processing someone else's file).
        $import = Import::factory()->users()->create([
            'file_path' => $importFileBuilder->saveToImportsDirectory(),
            'created_by' => $scopedImporter->id,
        ]);

        $this->actingAsForApi($scopedImporter)
            ->importFileResponse(['import' => $import->id, 'import-update' => true])
            ->assertOk();

        $membershipIds = \DB::table('company_user')
            ->where('user_id', $target->id)
            ->pluck('company_id')
            ->map(fn ($id) => (int) $id)
            ->all();

        $this->assertEqualsCanonicalizing(
            [$companyA->id, $companyB->id],
            $membershipIds,
            'CSV re-import by a company-A-scoped operator must not strip the target from company B, which the operator cannot see.',
        );
    }

    public function test_importer_create_by_scoped_importer_still_works_for_own_company()
    {
        // Sanity: the fix must not break the legitimate create branch. A
        // scoped importer creating a new user with their own company on
        // the row should succeed. The invisible-to-editor merge is a
        // no-op on a create because a brand-new user has no prior pivot
        // rows to preserve.
        $this->settings->enableMultipleFullCompanySupport();
        $this->settings->disableFloaterMode();

        $companyA = Company::factory()->create();
        $scopedImporter = User::factory()->canImport()->forCompany($companyA)->create();

        $importFileBuilder = ImportFileBuilder::new([
            'companyName' => $companyA->name,
        ])->forget('location');
        $row = $importFileBuilder->firstRow();
        $import = Import::factory()->users()->create([
            'file_path' => $importFileBuilder->saveToImportsDirectory(),
            'created_by' => $scopedImporter->id,
        ]);

        $this->actingAsForApi($scopedImporter)
            ->importFileResponse(['import' => $import->id])
            ->assertOk();

        $newUser = User::where('username', $row['username'])->firstOrFail();
        $membershipIds = $newUser->companies->pluck('id')->map(fn ($id) => (int) $id)->all();

        $this->assertEqualsCanonicalizing([$companyA->id], $membershipIds);
    }
}
