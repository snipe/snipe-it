<?php

namespace Tests\Feature\Suppliers\Ui;

use App\Models\Supplier;
use App\Models\User;
use Tests\TestCase;

class UpdateSupplierTest extends TestCase
{
    public function testPageRenders()
    {
        $this->actingAs(User::factory()->superuser()->create())
            ->get(route('suppliers.edit', Supplier::factory()->create()->id))
            ->assertOk();
    }

    public function testUserCanEditSuppliers()
    {
        $supplier = Supplier::factory()->create(['name' => 'Test Supplier']);
        $this->assertTrue(Supplier::where('name', 'Test Supplier')->exists());

        $response = $this->actingAs(User::factory()->superuser()->create())
            ->put(route('suppliers.update', ['supplier' => $supplier]), [
                'name' => 'Test Supplier Edited',
                'notes' => 'Test Note Edited',
                'latitude' => '38.7532',
                'longitude' => '-77.1969'
            ])
            ->assertStatus(302)
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('suppliers.index'));

        $this->followRedirects($response)->assertSee('Success');
        $this->assertTrue(
            Supplier::where('name', 'Test Supplier Edited')
                ->where('notes', 'Test Note Edited')
                // ->where('latitude', 38.7532)
                // ->where('longitude', -77.1969)
                ->exists()
        );
    }
}
