<?php

namespace Tests\Feature\Licenses\Ui;

use App\Models\Actionlog;
use App\Models\Category;
use App\Models\License;
use App\Models\User;
use Tests\TestCase;

class UpdateLicenseTest extends TestCase
{
    public function test_page_renders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('licenses.edit', License::factory()->create()->id))
            ->assertOk();
    }

    public function test_can_update_license_seats()
    {
        $admin = User::factory()->superuser()->create();
        $license_category = Category::factory()->forLicenses()->create()->id;
        $response = $this->actingAs($admin)
            ->from(route('licenses.create'))
            ->post(route('licenses.store'), [
                'name' => 'Test Update License',
                'seats' => '9999',
                'category_id' => $license_category,
            ]);
        $response->assertStatus(302);
        $license = License::where('name', 'Test Update License')->sole();
        $this->assertNotNull($license);

        $this->actingAs($admin)
            ->put(route('licenses.update', $license->id), [
                'name' => 'Test Update License',
                'seats' => '19999',
                'category_id' => $license_category,
            ])
            ->assertStatus(302);

        $license->refresh();
        $this->assertEquals($license->licenseseats()->count(), $license->seats);
        $this->assertEquals($license->licenseseats()->count(), 19999);
    }

    public function test_cannot_update_license_seats_too_much()
    {
        $admin = User::factory()->superuser()->create();
        $license_category = Category::factory()->forLicenses()->create()->id;
        $response = $this->actingAs($admin)
            ->from(route('licenses.create'))
            ->post(route('licenses.store'), [
                'name' => 'Test Update License',
                'seats' => '9999',
                'category_id' => $license_category,
            ]);
        $response->assertStatus(302);
        $license = License::where('name', 'Test Update License')->sole();
        $this->assertNotNull($license);

        $this->actingAs($admin)
            ->put(route('licenses.update', $license->id), [
                'name' => 'Test Update License',
                'seats' => '29999',
                'category_id' => $license_category,
            ])
            ->assertStatus(302);

        $license->refresh();
        $this->assertEquals($license->licenseseats()->count(), $license->seats);
        $this->assertEquals($license->licenseseats()->count(), 9999);
    }

    public function test_can_remove_license_seats()
    {
        $admin = User::factory()->superuser()->create();
        $license_category = Category::factory()->forLicenses()->create()->id;
        $response = $this->actingAs($admin)
            ->from(route('licenses.create'))
            ->post(route('licenses.store'), [
                'name' => 'Test Remove License Seats',
                'seats' => '9999',
                'category_id' => $license_category,
            ]);
        $response->assertStatus(302);
        $license = License::where('name', 'Test Remove License Seats')->sole();
        $this->assertNotNull($license);

        $this->actingAs($admin)
            ->put(route('licenses.update', $license->id), [
                'name' => 'Test Remove License Seats',
                'seats' => '5000',
                'category_id' => $license_category,
            ])
            ->assertStatus(302);

        $license->refresh();
        $this->assertEquals($license->licenseseats()->count(), $license->seats);
        $this->assertEquals($license->licenseseats()->count(), 5000);
    }

    public function test_update_logs_changed_fields_in_log_meta()
    {
        $license = License::factory()->create(['name' => 'Old Name', 'seats' => 5]);

        $this->actingAs(User::factory()->editLicenses()->create())
            ->put(route('licenses.update', $license), [
                'name' => 'New Name',
                'seats' => 10,
                'category_id' => $license->category_id,
            ]);

        $log = Actionlog::where('item_type', License::class)
            ->where('item_id', $license->id)
            ->where('action_type', 'update')
            ->latest()
            ->first();

        $this->assertNotNull($log, 'No update log entry was created');
        $this->assertNotNull($log->log_meta, 'log_meta was not stored');

        $meta = json_decode($log->log_meta, true);
        $this->assertEquals('Old Name', $meta['name']['old']);
        $this->assertEquals('New Name', $meta['name']['new']);
    }

    public function test_edit_page_renders_date_fields_in_ymd_format(): void
    {
        // Regression for the "editing a license wipes its dates" bug that
        // shipped in 8.7.0. `x-form.row type="datepicker"` was passing the
        // raw model attribute as the input value, which for License's date
        // fields (all cast to `date`) meant Carbon objects stringified as
        // "Y-m-d H:i:s". The datepicker JS couldn't parse that, rendered
        // blank, and submitting the form wiped the DB field.
        //
        // Guarantee here: all three date inputs on the edit page must
        // render with value="Y-m-d" so the picker parses correctly and a
        // no-op resubmit preserves the field.
        $license = License::factory()->create([
            'purchase_date' => '2026-01-15',
            'expiration_date' => '2027-06-30',
            'termination_date' => '2028-12-31',
        ]);

        $response = $this->actingAs(User::factory()->superuser()->create())
            ->get(route('licenses.edit', $license->id))
            ->assertOk();

        foreach (['purchase_date' => '2026-01-15', 'expiration_date' => '2027-06-30', 'termination_date' => '2028-12-31'] as $name => $expected) {
            $response->assertSee('name="'.$name.'"', false);
            $response->assertSee('value="'.$expected.'"', false);
            // The old bug shape: value contained the trailing time component
            // because the raw Carbon was rendered directly.
            $response->assertDontSee('value="'.$expected.' 00:00:00"', false);
        }
    }

    public function test_update_with_unchanged_date_fields_preserves_them(): void
    {
        // End-to-end regression: simulate what happens when an operator
        // opens the edit page and clicks Save without changing anything.
        // In the 8.7.0 bug, the blank-rendered pickers submitted empty
        // strings for the three date fields, and the update silently
        // wiped them. This asserts they survive a form roundtrip.
        $license = License::factory()->create([
            'purchase_date' => '2026-01-15',
            'expiration_date' => '2027-06-30',
            'termination_date' => '2028-12-31',
        ]);

        $editResponse = $this->actingAs(User::factory()->superuser()->create())
            ->get(route('licenses.edit', $license->id))
            ->assertOk();

        // Extract each date input value from the rendered edit page and
        // resubmit them, mimicking a no-op save.
        $html = $editResponse->getContent();
        $extract = function (string $name) use ($html): ?string {
            $q = preg_quote($name, '/');
            if (preg_match('/name="'.$q.'"[^>]*value="([^"]*)"/s', $html, $m)) {
                return $m[1];
            }
            if (preg_match('/value="([^"]*)"[^>]*name="'.$q.'"/s', $html, $m)) {
                return $m[1];
            }

            return null;
        };

        $this->actingAs(User::factory()->superuser()->create())
            ->put(route('licenses.update', $license->id), [
                'name' => $license->name,
                'seats' => $license->seats,
                'category_id' => $license->category_id,
                'purchase_date' => $extract('purchase_date'),
                'expiration_date' => $extract('expiration_date'),
                'termination_date' => $extract('termination_date'),
            ])
            ->assertStatus(302);

        $license->refresh();
        $this->assertEquals('2026-01-15', $license->purchase_date->format('Y-m-d'));
        $this->assertEquals('2027-06-30', $license->expiration_date->format('Y-m-d'));
        $this->assertEquals('2028-12-31', $license->termination_date->format('Y-m-d'));
    }

    public function test_no_op_update_does_not_create_log_entry()
    {
        $license = License::factory()->create([
            'name' => 'Same Name',
            'seats' => 5,
            'expiration_date' => null,
            'license_email' => null,
            'notes' => null,
            'order_number' => null,
            'purchase_date' => null,
            'reassignable' => 0,
            'serial' => null,
            'supplier_id' => null,
        ]);

        $before = Actionlog::where('item_type', License::class)
            ->where('item_id', $license->id)
            ->where('action_type', 'update')
            ->count();

        $this->actingAs(User::factory()->editLicenses()->create())
            ->put(route('licenses.update', $license), [
                'name' => 'Same Name',
                'seats' => 5,
                'category_id' => $license->category_id,
            ]);

        $after = Actionlog::where('item_type', License::class)
            ->where('item_id', $license->id)
            ->where('action_type', 'update')
            ->count();

        $this->assertEquals($before, $after, 'A spurious log entry was created for a no-op update');
    }
}
