<?php

namespace Tests\Feature\Consumables\Ui;

use App\Enums\ActionType;
use App\Models\Actionlog;
use App\Models\Consumable;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdjustConsumableQuantityTest extends TestCase
{
    public function test_requires_edit_permission()
    {
        $consumable = Consumable::factory()->create(['qty' => 5]);

        $this->actingAs(User::factory()->create())
            ->post(route('consumables.adjust-quantity', $consumable), [
                'amount' => 3,
                'note' => 'restock',
            ])
            ->assertForbidden();

        $this->assertSame(5, (int) $consumable->fresh()->qty);
    }

    public function test_replenish_increments_qty_and_logs()
    {
        $actor = User::factory()->editConsumables()->create();
        $consumable = Consumable::factory()->create(['qty' => 20]);

        $this->actingAs($actor)
            ->post(route('consumables.adjust-quantity', $consumable), [
                'amount' => 15,
                'note' => 'PO arrived',
                'order_number' => 'PO-77',
            ])
            ->assertRedirect();

        $this->assertSame(35, (int) $consumable->fresh()->qty);

        $log = Actionlog::where('item_type', Consumable::class)
            ->where('item_id', $consumable->id)
            ->where('action_type', ActionType::QuantityAdjust->value)
            ->latest('id')
            ->first();

        $this->assertSame(15, (int) $log->quantity);
        $this->assertSame('PO arrived', $log->note);
        $this->assertSame('PO-77', $log->orderItem->order->order_number);
    }

    public function test_decrement_below_zero_is_rejected()
    {
        $actor = User::factory()->editConsumables()->create();
        $consumable = Consumable::factory()->create(['qty' => 3]);

        $this->actingAs($actor)
            ->from(route('consumables.show', $consumable))
            ->post(route('consumables.adjust-quantity', $consumable), [
                'amount' => -10,
                'note' => 'oops',
            ])
            ->assertSessionHas('error');

        $this->assertSame(3, (int) $consumable->fresh()->qty);
    }

    public function test_note_is_required()
    {
        $actor = User::factory()->editConsumables()->create();
        $consumable = Consumable::factory()->create(['qty' => 5]);

        $this->actingAs($actor)
            ->post(route('consumables.adjust-quantity', $consumable), [
                'amount' => 2,
            ])
            ->assertSessionHasErrors('note');
    }

    public function test_uploaded_receipt_attaches_to_the_same_log_row_and_surfaces_in_files_tab()
    {
        Storage::fake();

        $actor = User::factory()->editConsumables()->create();
        $consumable = Consumable::factory()->create(['qty' => 5]);
        $uploadsBefore = $consumable->uploads()->count();

        $this->actingAs($actor)
            ->post(route('consumables.adjust-quantity', $consumable), [
                'amount' => 3,
                'note' => 'restock with invoice',
                'order_number' => 'PO-99',
                'file' => UploadedFile::fake()->create('invoice-99.pdf', 32, 'application/pdf'),
            ])
            ->assertRedirect();

        $log = Actionlog::where('item_type', Consumable::class)
            ->where('item_id', $consumable->id)
            ->where('action_type', ActionType::QuantityAdjust->value)
            ->latest('id')
            ->firstOrFail();

        $this->assertNotNull($log->filename, 'Uploaded receipt filename must be attached to the QuantityAdjust log row.');
        $this->assertStringEndsWith('.pdf', $log->filename);
        $this->assertSame(0, Actionlog::where('item_type', Consumable::class)
            ->where('item_id', $consumable->id)
            ->where('action_type', 'uploaded')
            ->count(), 'No separate uploaded log entry should have been created.');

        $this->assertSame($uploadsBefore + 1, $consumable->uploads()->count());
        $this->assertTrue($consumable->uploads()->where('id', $log->id)->exists());
    }
}
