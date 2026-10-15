<?php

namespace Tests\Feature\Accessories\Ui;

use App\Enums\ActionType;
use App\Models\Accessory;
use App\Models\AccessoryCheckout;
use App\Models\Actionlog;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdjustAccessoryQuantityTest extends TestCase
{
    public function test_requires_edit_permission()
    {
        $accessory = Accessory::factory()->create(['qty' => 5]);

        $this->actingAs(User::factory()->create())
            ->post(route('accessories.adjust-quantity', $accessory), [
                'amount' => 3,
                'note' => 'restock',
            ])
            ->assertForbidden();

        $this->assertSame(5, (int) $accessory->fresh()->qty);
    }

    public function test_replenish_increments_qty_and_logs()
    {
        $actor = User::factory()->editAccessories()->create();
        $accessory = Accessory::factory()->create(['qty' => 5]);

        $this->actingAs($actor)
            ->post(route('accessories.adjust-quantity', $accessory), [
                'amount' => 3,
                'note' => 'restock from PO',
                'order_number' => 'PO-42',
            ])
            ->assertRedirect();

        $this->assertSame(8, (int) $accessory->fresh()->qty);

        $log = Actionlog::where('item_type', Accessory::class)
            ->where('item_id', $accessory->id)
            ->where('action_type', ActionType::QuantityAdjust->value)
            ->latest('id')
            ->first();

        $this->assertNotNull($log);
        $this->assertSame(3, (int) $log->quantity);
        $this->assertSame('restock from PO', $log->note);
        $this->assertSame('PO-42', $log->orderItem->order->order_number);
        $this->assertSame($actor->id, (int) $log->created_by);
    }

    public function test_decrement_reduces_qty_and_logs_negative_quantity()
    {
        $actor = User::factory()->editAccessories()->create();
        $accessory = Accessory::factory()->create(['qty' => 10]);

        $this->actingAs($actor)
            ->post(route('accessories.adjust-quantity', $accessory), [
                'amount' => -4,
                'note' => 'damaged units removed',
            ])
            ->assertRedirect();

        $this->assertSame(6, (int) $accessory->fresh()->qty);

        $log = Actionlog::where('item_type', Accessory::class)
            ->where('item_id', $accessory->id)
            ->where('action_type', ActionType::QuantityAdjust->value)
            ->latest('id')
            ->first();

        $this->assertSame(-4, (int) $log->quantity);
        $this->assertNull($log->order_item_id);
    }

    public function test_decrement_below_zero_is_rejected()
    {
        $actor = User::factory()->editAccessories()->create();
        $accessory = Accessory::factory()->create(['qty' => 2]);

        $this->actingAs($actor)
            ->from(route('accessories.show', $accessory))
            ->post(route('accessories.adjust-quantity', $accessory), [
                'amount' => -5,
                'note' => 'oops',
            ])
            ->assertRedirect(route('accessories.show', $accessory))
            ->assertSessionHas('error');

        $this->assertSame(2, (int) $accessory->fresh()->qty);
        $this->assertDatabaseMissing('action_logs', [
            'item_type' => Accessory::class,
            'item_id' => $accessory->id,
            'action_type' => ActionType::QuantityAdjust->value,
        ]);
    }

    public function test_decrement_below_currently_checked_out_is_rejected()
    {
        $actor = User::factory()->editAccessories()->create();
        $accessory = Accessory::factory()->create(['qty' => 10]);
        AccessoryCheckout::factory()->count(4)->create([
            'accessory_id' => $accessory->id,
            'assigned_type' => User::class,
            'assigned_to' => User::factory()->create()->id,
        ]);

        $this->actingAs($actor)
            ->from(route('accessories.show', $accessory))
            ->post(route('accessories.adjust-quantity', $accessory), [
                'amount' => -7, // would leave qty=3, below the 4 in use
                'note' => 'oops',
            ])
            ->assertSessionHas('error');

        $this->assertSame(10, (int) $accessory->fresh()->qty);
    }

    public function test_note_is_required()
    {
        $actor = User::factory()->editAccessories()->create();
        $accessory = Accessory::factory()->create(['qty' => 5]);

        $this->actingAs($actor)
            ->post(route('accessories.adjust-quantity', $accessory), [
                'amount' => 2,
            ])
            ->assertSessionHasErrors('note');

        $this->assertSame(5, (int) $accessory->fresh()->qty);
    }

    public function test_zero_amount_writes_audit_log_without_changing_qty()
    {
        // Zero delta is an audit-only submission: the user counted the
        // shelf, it matches the DB, and they recorded that fact. We
        // write a QuantityAdjust log entry (with quantity=0) for
        // provenance but do not touch the on-hand column.
        $actor = User::factory()->editAccessories()->create();
        $accessory = Accessory::factory()->create(['qty' => 5]);

        $this->actingAs($actor)
            ->post(route('accessories.adjust-quantity', $accessory), [
                'amount' => 0,
                'note' => 'shelf count matches',
            ])
            ->assertSessionHasNoErrors()
            ->assertSessionHas('success');

        $this->assertSame(5, (int) $accessory->fresh()->qty);

        $log = \App\Models\Actionlog::where('item_type', Accessory::class)
            ->where('item_id', $accessory->id)
            ->where('action_type', \App\Enums\ActionType::QuantityAdjust->value)
            ->latest('id')
            ->firstOrFail();

        $this->assertSame(0, (int) $log->quantity);
        $this->assertSame('shelf count matches', $log->note);
    }

    public function test_uploaded_receipt_attaches_to_the_same_log_row_and_surfaces_in_files_tab()
    {
        Storage::fake();

        $actor = User::factory()->editAccessories()->create();
        $accessory = Accessory::factory()->create(['qty' => 5]);
        $uploadsBefore = $accessory->uploads()->count();

        $this->actingAs($actor)
            ->post(route('accessories.adjust-quantity', $accessory), [
                'amount' => 3,
                'note' => 'restock with invoice',
                'order_number' => 'PO-99',
                'file' => UploadedFile::fake()->create('invoice-99.pdf', 32, 'application/pdf'),
            ])
            ->assertRedirect();

        $log = Actionlog::where('item_type', Accessory::class)
            ->where('item_id', $accessory->id)
            ->where('action_type', ActionType::QuantityAdjust->value)
            ->latest('id')
            ->firstOrFail();

        // Attachment lives on the QuantityAdjust log, not a separate
        // 'uploaded' entry (so the history table shows one consolidated line).
        $this->assertNotNull($log->filename, 'Uploaded receipt filename must be attached to the QuantityAdjust log row.');
        $this->assertStringEndsWith('.pdf', $log->filename);
        $this->assertSame(0, Actionlog::where('item_type', Accessory::class)
            ->where('item_id', $accessory->id)
            ->where('action_type', 'uploaded')
            ->count(), 'No separate uploaded log entry should have been created.');

        // And the same log row surfaces in uploads() so the Files tab shows it.
        $this->assertSame($uploadsBefore + 1, $accessory->uploads()->count());
        $this->assertTrue($accessory->uploads()->where('id', $log->id)->exists());
    }
}
