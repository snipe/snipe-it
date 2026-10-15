<?php

namespace Tests\Unit\Models;

use App\Models\Accessory;
use App\Models\CheckoutRequest;
use App\Models\Component;
use App\Models\Consumable;
use App\Models\License;
use Tests\TestCase;

class CheckoutRequestTest extends TestCase
{
    public function test_checkout_request_soft_deleted_when_requested_asset_soft_deleted()
    {
        $checkoutRequest = CheckoutRequest::factory()->forAsset()->create();

        $requestedAsset = $checkoutRequest->requestedItem;

        $requestedAsset->delete();

        $this->assertSoftDeleted($checkoutRequest->fresh());
    }

    public function test_checkout_request_deleted_when_requested_asset_force_deleted()
    {
        $checkoutRequest = CheckoutRequest::factory()->forAsset()->create();

        $requestedAsset = $checkoutRequest->requestedItem;

        $requestedAsset->forceDelete();

        $this->assertDatabaseMissing('checkout_requests', ['id' => $checkoutRequest->id]);
    }

    public function test_checkout_request_soft_deleted_when_requested_model_soft_deleted()
    {
        $checkoutRequest = CheckoutRequest::factory()->forAssetModel()->create();

        $requestedAssetModel = $checkoutRequest->requestedItem;

        $requestedAssetModel->delete();

        $this->assertSoftDeleted($checkoutRequest->fresh());
    }

    public function test_checkout_request_deleted_when_requested_model_force_deleted()
    {
        $checkoutRequest = CheckoutRequest::factory()->forAssetModel()->create();

        $requestedAsset = $checkoutRequest->requestedItem;

        $requestedAsset->forceDelete();

        $this->assertDatabaseMissing('checkout_requests', ['id' => $checkoutRequest->id]);
    }

    public function test_checkout_request_soft_deleted_when_requesting_user_soft_deleted()
    {
        $checkoutRequest = CheckoutRequest::factory()->forAsset()->create();

        $requestingUser = $checkoutRequest->user;

        $requestingUser->delete();

        $this->assertSoftDeleted($checkoutRequest->fresh());
    }

    public function test_checkout_request_deleted_when_requesting_user_force_deleted()
    {
        $checkoutRequest = CheckoutRequest::factory()->forAsset()->create();

        $requestingUser = $checkoutRequest->user;

        $requestingUser->forceDelete();

        $this->assertDatabaseMissing('checkout_requests', ['id' => $checkoutRequest->id]);
    }

    public function test_name_property_access_does_not_trigger_relation_resolution()
    {
        // Regression: CalendarEventsTransformer::titleFor() falls through
        // to `$source->display_name ?? $source->name ?? ...` when the
        // source has no Presentable presenter. CheckoutRequest defines a
        // plain name() method that returns the requestable's display
        // string. Without an accessor, Eloquent's __get('name') routes
        // through getRelationValue('name') → getRelationshipFromMethod()
        // which calls name(), gets a string back instead of a Relation,
        // and throws `LogicException: name must return a relationship
        // instance`, taking down the calendar API for any install that
        // has a reservation-shape CheckoutRequest.
        $checkoutRequest = CheckoutRequest::factory()->forAsset()->create();

        $this->assertSame(
            $checkoutRequest->name(),
            $checkoutRequest->name,
            'Property access `->name` must return the accessor value, not throw when Eloquent misinterprets name() as a relation.'
        );
    }

    public function test_calendar_url_points_at_asset_checkout_with_request_id()
    {
        $checkoutRequest = CheckoutRequest::factory()->forAsset()->create();
        $asset = $checkoutRequest->requestedItem;

        $url = $checkoutRequest->calendarUrl();

        $this->assertStringContainsString(route('hardware.checkout.create', ['asset' => $asset->id]), $url);
        $this->assertStringContainsString('request_id='.$checkoutRequest->id, $url);
    }

    public function test_calendar_url_points_at_asset_model_fulfill_screen_with_request_id()
    {
        $checkoutRequest = CheckoutRequest::factory()->forAssetModel()->create();
        $model = $checkoutRequest->requestedItem;

        $url = $checkoutRequest->calendarUrl();

        $this->assertStringContainsString(route('models.fulfill-requests.create', ['model' => $model->id]), $url);
        $this->assertStringContainsString('request_id='.$checkoutRequest->id, $url);
    }

    public function test_calendar_url_points_at_component_checkout_with_request_id()
    {
        $component = Component::factory()->create();
        $checkoutRequest = CheckoutRequest::factory()->create([
            'requestable_type' => Component::class,
            'requestable_id' => $component->id,
        ]);

        $url = $checkoutRequest->calendarUrl();

        $this->assertStringContainsString(route('components.checkout.show', ['componentID' => $component->id]), $url);
        $this->assertStringContainsString('request_id='.$checkoutRequest->id, $url);
    }

    public function test_calendar_url_points_at_accessory_checkout_with_request_id()
    {
        $accessory = Accessory::factory()->create();
        $checkoutRequest = CheckoutRequest::factory()->create([
            'requestable_type' => Accessory::class,
            'requestable_id' => $accessory->id,
        ]);

        $url = $checkoutRequest->calendarUrl();

        $this->assertStringContainsString(route('accessories.checkout.show', ['accessory' => $accessory->id]), $url);
        $this->assertStringContainsString('request_id='.$checkoutRequest->id, $url);
    }

    public function test_calendar_url_points_at_consumable_checkout_with_request_id()
    {
        $consumable = Consumable::factory()->create();
        $checkoutRequest = CheckoutRequest::factory()->create([
            'requestable_type' => Consumable::class,
            'requestable_id' => $consumable->id,
        ]);

        $url = $checkoutRequest->calendarUrl();

        $this->assertStringContainsString(route('consumables.checkout.show', ['consumablesID' => $consumable->id]), $url);
        $this->assertStringContainsString('request_id='.$checkoutRequest->id, $url);
    }

    public function test_calendar_url_points_at_license_checkout_with_request_id()
    {
        $license = License::factory()->create();
        $checkoutRequest = CheckoutRequest::factory()->create([
            'requestable_type' => License::class,
            'requestable_id' => $license->id,
        ]);

        $url = $checkoutRequest->calendarUrl();

        $this->assertStringContainsString(route('licenses.checkout', ['license' => $license->id]), $url);
        $this->assertStringContainsString('request_id='.$checkoutRequest->id, $url);
    }
}
