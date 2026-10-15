<?php

namespace Tests\Feature\Licenses\Ui;

use App\Models\License;
use App\Models\User;
use Tests\TestCase;

class ExportLicensesCsvTest extends TestCase
{
    public function test_csv_export_masks_serial_for_users_without_view_keys_permission(): void
    {
        $license = License::factory()->create([
            'name' => 'Definitely a real license',
            'serial' => 'SECRET-PRODUCT-KEY-DO-NOT-LEAK',
        ]);

        $viewOnly = User::factory()->viewLicenses()->create();

        $this->actingAs($viewOnly)
            ->get(route('licenses.export'))
            ->assertOk()
            ->assertSeePairsInStreamedResponse([
                'Name' => $license->name,
                // League CSV's EscapeFormula prepends a backtick to values starting with
                // characters Excel would parse as formula triggers (=+-@). The mask itself
                // is License::PRODUCT_KEY_MASK ("------------"), which trips the leading-`-`
                // rule, so what actually lands in the CSV cell is "`------------".
                'Serial Number' => '`'.License::PRODUCT_KEY_MASK,
            ])
            ->assertDontSeeTextInStreamedResponse('SECRET-PRODUCT-KEY-DO-NOT-LEAK');
    }

    public function test_csv_export_emits_real_serial_for_users_with_view_keys_permission(): void
    {
        $license = License::factory()->create([
            'name' => 'Definitely a real license',
            'serial' => 'SECRET-PRODUCT-KEY-VISIBLE',
        ]);

        $keyHolder = User::factory()->viewLicenses()->viewKeysLicenses()->create();

        $this->actingAs($keyHolder)
            ->get(route('licenses.export'))
            ->assertOk()
            ->assertSeePairsInStreamedResponse([
                'Name' => $license->name,
                'Serial Number' => 'SECRET-PRODUCT-KEY-VISIBLE',
            ]);
    }

    public function test_csv_export_emits_real_serial_for_users_with_edit_permission(): void
    {
        // viewKeys grants on any of licenses.keys, licenses.create, or licenses.edit,
        // so this branch has to be pinned too. Otherwise a future refactor could
        // regress `edit` users into the masked branch.
        $license = License::factory()->create([
            'name' => 'Real license',
            'serial' => 'EDIT-USER-SHOULD-SEE-THIS',
        ]);

        $editor = User::factory()->viewLicenses()->editLicenses()->create();

        $this->actingAs($editor)
            ->get(route('licenses.export'))
            ->assertOk()
            ->assertSeePairsInStreamedResponse([
                'Name' => $license->name,
                'Serial Number' => 'EDIT-USER-SHOULD-SEE-THIS',
            ]);
    }

    public function test_csv_export_emits_real_serial_for_superuser(): void
    {
        $license = License::factory()->create([
            'name' => 'Real license',
            'serial' => 'SUPERUSER-SHOULD-SEE-THIS',
        ]);

        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('licenses.export'))
            ->assertOk()
            ->assertSeePairsInStreamedResponse([
                'Name' => $license->name,
                'Serial Number' => 'SUPERUSER-SHOULD-SEE-THIS',
            ]);
    }
}
