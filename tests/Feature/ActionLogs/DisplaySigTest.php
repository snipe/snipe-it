<?php

namespace Tests\Feature\ActionLogs;

use App\Models\Actionlog;
use App\Models\Asset;
use App\Models\License;
use App\Models\User;
use Tests\TestCase;

class DisplaySigTest extends TestCase
{
    public function test_requires_authentication(): void
    {
        $actionlog = Actionlog::factory()->acceptedSignature()->create();

        $this->get(route('log.signature.view', ['filename' => $actionlog->accept_signature]))
            ->assertRedirect(route('login'));
    }

    public function test_nonexistent_filename_redirects_with_error(): void
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('log.signature.view', ['filename' => 'does-not-exist.png']))
            ->assertRedirect(route('home'));
    }

    public function test_user_without_view_permission_cannot_view_asset_signature(): void
    {
        $actionlog = Actionlog::factory()->acceptedSignature()->create();

        $this->actingAs(User::factory()->create())
            ->get(route('log.signature.view', ['filename' => $actionlog->accept_signature]))
            ->assertForbidden();
    }

    public function test_user_with_asset_view_permission_can_view_asset_signature(): void
    {
        $asset = Asset::factory()->create();
        $actionlog = Actionlog::factory()->create([
            'action_type' => 'accepted',
            'item_id' => $asset->id,
            'item_type' => Asset::class,
            'accept_signature' => 'test-asset-sig-'.uniqid().'.png',
        ]);

        $this->actingAs(User::factory()->viewAssets()->create())
            ->get(route('log.signature.view', ['filename' => $actionlog->accept_signature]))
            ->assertOk();
    }

    public function test_user_with_asset_view_permission_cannot_view_license_signature(): void
    {
        $license = License::factory()->create();
        $actionlog = Actionlog::factory()->create([
            'action_type' => 'accepted',
            'item_id' => $license->id,
            'item_type' => License::class,
            'accept_signature' => 'test-license-sig-'.uniqid().'.png',
        ]);

        $this->actingAs(User::factory()->viewAssets()->create())
            ->get(route('log.signature.view', ['filename' => $actionlog->accept_signature]))
            ->assertForbidden();
    }

    public function test_user_with_license_view_permission_can_view_license_signature(): void
    {
        $license = License::factory()->create();
        $actionlog = Actionlog::factory()->create([
            'action_type' => 'accepted',
            'item_id' => $license->id,
            'item_type' => License::class,
            'accept_signature' => 'test-license-sig-'.uniqid().'.png',
        ]);

        $this->actingAs(User::factory()->viewLicenses()->create())
            ->get(route('log.signature.view', ['filename' => $actionlog->accept_signature]))
            ->assertOk();
    }
}
