<?php

namespace Tests\Feature\Components\Ui;

use App\Enums\ActionType;
use App\Models\Actionlog;
use App\Models\Component;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdjustComponentQuantityTest extends TestCase
{
    public function test_requires_edit_permission()
    {
        $component = Component::factory()->create(['qty' => 5]);

        $this->actingAs(User::factory()->create())
            ->post(route('components.adjust-quantity', $component), [
                'amount' => 3,
                'note' => 'restock',
            ])
            ->assertForbidden();

        $this->assertSame(5, (int) $component->fresh()->qty);
    }

    public function test_replenish_increments_qty_and_logs()
    {
        $actor = User::factory()->editComponents()->create();
        $component = Component::factory()->create(['qty' => 12]);

        $this->actingAs($actor)
            ->post(route('components.adjust-quantity', $component), [
                'amount' => 8,
                'note' => 'new shipment',
                'order_number' => 'PO-88',
            ])
            ->assertRedirect();

        $this->assertSame(20, (int) $component->fresh()->qty);

        $log = Actionlog::where('item_type', Component::class)
            ->where('item_id', $component->id)
            ->where('action_type', ActionType::QuantityAdjust->value)
            ->latest('id')
            ->first();

        $this->assertSame(8, (int) $log->quantity);
        $this->assertSame('PO-88', $log->orderItem->order->order_number);
    }

    public function test_decrement_below_zero_is_rejected()
    {
        $actor = User::factory()->editComponents()->create();
        $component = Component::factory()->create(['qty' => 4]);

        $this->actingAs($actor)
            ->from(route('components.show', $component))
            ->post(route('components.adjust-quantity', $component), [
                'amount' => -100,
                'note' => 'oops',
            ])
            ->assertSessionHas('error');

        $this->assertSame(4, (int) $component->fresh()->qty);
    }

    public function test_uploaded_receipt_attaches_to_the_same_log_row_and_surfaces_in_files_tab()
    {
        Storage::fake();

        $actor = User::factory()->editComponents()->create();
        $component = Component::factory()->create(['qty' => 5]);
        $uploadsBefore = $component->uploads()->count();

        $this->actingAs($actor)
            ->post(route('components.adjust-quantity', $component), [
                'amount' => 3,
                'note' => 'restock with invoice',
                'order_number' => 'PO-99',
                'file' => UploadedFile::fake()->create('invoice-99.pdf', 32, 'application/pdf'),
            ])
            ->assertRedirect();

        $log = Actionlog::where('item_type', Component::class)
            ->where('item_id', $component->id)
            ->where('action_type', ActionType::QuantityAdjust->value)
            ->latest('id')
            ->firstOrFail();

        $this->assertNotNull($log->filename, 'Uploaded receipt filename must be attached to the QuantityAdjust log row.');
        $this->assertStringEndsWith('.pdf', $log->filename);
        $this->assertSame(0, Actionlog::where('item_type', Component::class)
            ->where('item_id', $component->id)
            ->where('action_type', 'uploaded')
            ->count(), 'No separate uploaded log entry should have been created.');

        $this->assertSame($uploadsBefore + 1, $component->uploads()->count());
        $this->assertTrue($component->uploads()->where('id', $log->id)->exists());
    }
}
