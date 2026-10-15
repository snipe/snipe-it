<?php

namespace Tests\Feature\Accessories\Api;

use App\Enums\ActionType;
use App\Models\Accessory;
use App\Models\AccessoryCheckout;
use App\Models\Actionlog;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdjustAccessoryQuantityApiTest extends TestCase
{
    public function test_requires_edit_permission()
    {
        $accessory = Accessory::factory()->create(['qty' => 5]);

        $this->actingAsForApi(User::factory()->create())
            ->postJson(route('api.accessories.adjust-quantity', $accessory), [
                'amount' => 3,
                'note' => 'restock',
            ])
            ->assertForbidden();
    }

    public function test_signed_amount_writes_quantity_adjust_log()
    {
        $actor = User::factory()->editAccessories()->create();
        $accessory = Accessory::factory()->create(['qty' => 5]);

        $this->actingAsForApi($actor)
            ->postJson(route('api.accessories.adjust-quantity', $accessory), [
                'amount' => 3,
                'note' => 'restock from PO',
                'order_number' => 'PO-API-1',
            ])
            ->assertOk();

        $this->assertSame(8, (int) $accessory->fresh()->qty);

        $log = Actionlog::where('item_type', Accessory::class)
            ->where('item_id', $accessory->id)
            ->where('action_type', ActionType::QuantityAdjust->value)
            ->latest('id')
            ->firstOrFail();

        $this->assertSame(3, (int) $log->quantity);
        $this->assertSame('restock from PO', $log->note);
        // order_number moved off the log row to the Orders table — the
        // log carries order_id pointing at the newly-created Order.
        $order = $log->orderItem->order;
        $this->assertSame('PO-API-1', $order->order_number);
        $this->assertSame($actor->id, (int) $log->created_by);
    }

    public function test_negative_amount_decrements()
    {
        $actor = User::factory()->editAccessories()->create();
        $accessory = Accessory::factory()->create(['qty' => 10]);

        $this->actingAsForApi($actor)
            ->postJson(route('api.accessories.adjust-quantity', $accessory), [
                'amount' => -4,
                'note' => 'damaged units removed',
            ])
            ->assertOk();

        $this->assertSame(6, (int) $accessory->fresh()->qty);
    }

    public function test_note_is_required()
    {
        // Snipe-IT convention: FormRequest validation errors on API
        // endpoints return 200 with a status:error body via
        // formatStandardApiResponse (Exceptions\Handler shapes this
        // globally). Below-in-use is different — that one is a
        // controller-level DomainException and returns 422 explicitly.
        $accessory = Accessory::factory()->create(['qty' => 5]);

        $this->actingAsForApi(User::factory()->editAccessories()->create())
            ->postJson(route('api.accessories.adjust-quantity', $accessory), ['amount' => 2])
            ->assertOk()
            ->assertJsonPath('status', 'error')
            ->assertJsonPath('messages.note.0', 'The note field is required.');
    }

    public function test_zero_amount_writes_audit_log_without_changing_qty()
    {
        // Zero delta is an audit-only submission: user counted the shelf
        // and confirmed it still matches the DB, so we record the
        // QuantityAdjust log entry (with quantity=0) for provenance but
        // do not touch the on-hand column.
        $accessory = Accessory::factory()->create(['qty' => 5]);

        $this->actingAsForApi(User::factory()->editAccessories()->create())
            ->postJson(route('api.accessories.adjust-quantity', $accessory), [
                'amount' => 0,
                'note' => 'shelf count matches',
            ])
            ->assertOk()
            ->assertJsonPath('status', 'success');

        $this->assertSame(5, (int) $accessory->fresh()->qty);

        $log = Actionlog::where('item_type', Accessory::class)
            ->where('item_id', $accessory->id)
            ->where('action_type', ActionType::QuantityAdjust->value)
            ->latest('id')
            ->firstOrFail();

        $this->assertSame(0, (int) $log->quantity);
        $this->assertSame('shelf count matches', $log->note);
    }

    public function test_decrement_below_currently_checked_out_returns_422()
    {
        $accessory = Accessory::factory()->create(['qty' => 10]);
        AccessoryCheckout::factory()->count(4)->create([
            'accessory_id' => $accessory->id,
            'assigned_type' => User::class,
            'assigned_to' => User::factory()->create()->id,
        ]);

        $this->actingAsForApi(User::factory()->editAccessories()->create())
            ->postJson(route('api.accessories.adjust-quantity', $accessory), [
                'amount' => -7, // would leave qty=3, below the 4 in use
                'note' => 'oops',
            ])
            ->assertStatus(422);

        $this->assertSame(10, (int) $accessory->fresh()->qty);
    }

    public function test_receipt_attaches_to_the_same_log_row_and_surfaces_in_files_tab()
    {
        Storage::fake();

        $accessory = Accessory::factory()->create(['qty' => 5]);
        $uploadsBefore = $accessory->uploads()->count();

        $this->actingAsForApi(User::factory()->editAccessories()->create())
            ->postJson(route('api.accessories.adjust-quantity', $accessory), [
                'amount' => 3,
                'note' => 'restock with invoice',
                'order_number' => 'PO-API-2',
                'file' => UploadedFile::fake()->create('invoice-api.pdf', 32, 'application/pdf'),
            ])
            ->assertOk();

        $log = Actionlog::where('item_type', Accessory::class)
            ->where('item_id', $accessory->id)
            ->where('action_type', ActionType::QuantityAdjust->value)
            ->latest('id')
            ->firstOrFail();

        $this->assertNotNull($log->filename);
        $this->assertStringEndsWith('.pdf', $log->filename);
        $this->assertSame(0, Actionlog::where('item_type', Accessory::class)
            ->where('item_id', $accessory->id)
            ->where('action_type', 'uploaded')
            ->count(), 'No separate uploaded log entry should have been created.');
        $this->assertSame($uploadsBefore + 1, $accessory->uploads()->count());
    }

    // Order + OrderItem-side behavior of this endpoint (dedup, blank
    // order_number splitting, audit-vs-purchase decision) lives in the
    // sibling AdjustAccessoryOrderRecordingTest so both classes stay
    // under Codacy's 10-method-per-class ceiling and each is coherent
    // about the concern it covers.
}
