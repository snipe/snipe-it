<?php

namespace Tests\Feature\Users\Api;

use App\Models\License;
use App\Models\LicenseSeat;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserLicensesListTest extends TestCase
{
    public function test_endpoint_requires_view_permission(): void
    {
        $user = User::factory()->create();

        $this->actingAsForApi(User::factory()->create())
            ->getJson(route('api.users.licenselist', ['user' => $user->id]))
            ->assertForbidden();
    }

    public function test_endpoint_returns_one_row_per_seat_assignment(): void
    {
        $user = User::factory()->create();
        $officeSuite = License::factory()->create(['name' => 'Office Suite', 'seats' => 5]);
        $editor = License::factory()->create(['name' => 'Editor', 'seats' => 5]);

        LicenseSeat::factory()->count(2)->for($officeSuite)->assignedToUser($user)->create();
        LicenseSeat::factory()->for($editor)->assignedToUser($user)->create();

        $response = $this->actingAsForApi(User::factory()->viewUsers()->viewLicenses()->create())
            ->getJson(route('api.users.licenselist', ['user' => $user->id]))
            ->assertOk()
            ->json();

        $this->assertSame(3, $response['total']);
        $this->assertCount(3, $response['rows']);
    }

    public function test_endpoint_paginates_and_reports_metadata(): void
    {
        $user = User::factory()->create();
        $license = License::factory()->create(['seats' => 20]);
        LicenseSeat::factory()->count(5)->for($license)->assignedToUser($user)->create();

        $response = $this->actingAsForApi(User::factory()->viewUsers()->viewLicenses()->create())
            ->getJson(route('api.users.licenselist', ['user' => $user->id, 'limit' => 2, 'page' => 2]))
            ->assertOk()
            ->json();

        $this->assertSame(5, $response['total']);
        $this->assertCount(2, $response['rows']);
        $this->assertSame(2, $response['per_page']);
        $this->assertSame(2, $response['current_page']);
        $this->assertSame(3, $response['total_pages']);
    }

    public function test_row_shape_exposes_seat_id_and_license_metadata(): void
    {
        $user = User::factory()->create();
        $license = License::factory()->create([
            'name' => 'Adobe Creative Cloud',
            'purchase_cost' => '600.00',
            'purchase_order' => 'PO-77',
            'order_number' => 'ORDER-42',
            'seats' => 3,
        ]);
        $seat = LicenseSeat::factory()->for($license)->assignedToUser($user)->create();

        $response = $this->actingAsForApi(User::factory()->viewUsers()->viewLicenses()->create())
            ->getJson(route('api.users.licenselist', ['user' => $user->id]))
            ->assertOk()
            ->json();

        $row = $response['rows'][0];
        $this->assertSame((int) $seat->id, $row['id']);
        $this->assertSame((int) $license->id, $row['license']['id']);
        $this->assertSame('Adobe Creative Cloud', $row['license']['name']);
        $this->assertSame('PO-77', $row['purchase_order']);
        $this->assertSame('ORDER-42', $row['order_number']);
    }

    public function test_search_matches_license_name_purchase_order_and_order_number(): void
    {
        $user = User::factory()->create();
        $adobe = License::factory()->create(['name' => 'Adobe CC', 'purchase_order' => 'PO-ADOBE-1', 'order_number' => 'ADOBE-ORD-42', 'seats' => 3]);
        $office = License::factory()->create(['name' => 'MS Office', 'purchase_order' => 'PO-MS-2', 'order_number' => 'MS-ORD-99', 'seats' => 3]);

        LicenseSeat::factory()->for($adobe)->assignedToUser($user)->create();
        LicenseSeat::factory()->for($office)->assignedToUser($user)->create();

        $caller = User::factory()->viewUsers()->viewLicenses()->create();

        $byName = $this->actingAsForApi($caller)
            ->getJson(route('api.users.licenselist', ['user' => $user->id, 'search' => 'Adobe']))
            ->assertOk()
            ->json();
        $this->assertSame(1, $byName['total']);

        $byPO = $this->actingAsForApi($caller)
            ->getJson(route('api.users.licenselist', ['user' => $user->id, 'search' => 'PO-MS']))
            ->assertOk()
            ->json();
        $this->assertSame(1, $byPO['total']);

        $byOrder = $this->actingAsForApi($caller)
            ->getJson(route('api.users.licenselist', ['user' => $user->id, 'search' => 'ADOBE-ORD']))
            ->assertOk()
            ->json();
        $this->assertSame(1, $byOrder['total']);
    }

    public function test_search_includes_serial_only_for_callers_with_view_keys(): void
    {
        $user = User::factory()->create();
        $license = License::factory()->create(['name' => 'Adobe CC', 'serial' => 'SECRET-KEY-ABC', 'seats' => 3]);
        LicenseSeat::factory()->for($license)->assignedToUser($user)->create();

        $withoutKeys = User::factory()->viewUsers()->viewLicenses()->create();
        $withoutKeysResult = $this->actingAsForApi($withoutKeys)
            ->getJson(route('api.users.licenselist', ['user' => $user->id, 'search' => 'SECRET-KEY']))
            ->assertOk()
            ->json();
        $this->assertSame(0, $withoutKeysResult['total'], 'Callers without viewKeys must not be able to filter licenses by serial via search');

        $withKeys = User::factory()->superuser()->create();
        $withKeysResult = $this->actingAsForApi($withKeys)
            ->getJson(route('api.users.licenselist', ['user' => $user->id, 'search' => 'SECRET-KEY']))
            ->assertOk()
            ->json();
        $this->assertSame(1, $withKeysResult['total']);
    }

    public function test_endpoint_ignores_seats_assigned_to_other_users(): void
    {
        $target = User::factory()->create();
        $bystander = User::factory()->create();
        $license = License::factory()->create(['seats' => 5]);

        LicenseSeat::factory()->for($license)->assignedToUser($target)->create();
        LicenseSeat::factory()->count(3)->for($license)->assignedToUser($bystander)->create();
        DB::table('license_seats')->insert([
            'license_id' => $license->id,
            'assigned_to' => null,
            'asset_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->actingAsForApi(User::factory()->viewUsers()->viewLicenses()->create())
            ->getJson(route('api.users.licenselist', ['user' => $target->id]))
            ->assertOk()
            ->json();

        $this->assertSame(1, $response['total']);
    }
}
