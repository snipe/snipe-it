<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\Models\User;
use App\Models\Asset;
use Illuminate\Support\Facades\Hash;

class CreateAssetTest extends DuskTestCase
{

    public function testUserCanCreateAnAsset(): void
    {
        $asset = Asset::factory()->make([
        ]);

        $user = User::factory()->createAssets()->create([
            'password' => Hash::make('password'),
        ]);

        $this->browse(function (Browser $browser) use ($user, $asset) {
            $browser->logout();

            $browser->visit('/login')
                ->type('username', $user->username)
                ->type('password', 'password')
                ->press('Login')
                ->visit('/hardware/create')
                ->type('asset_tags[1]', $asset->asset_tag)
                ->select2('#model_select_id', 'Macbook')
                ->waitForText('Macbook Pro')
                ->click('label:first-child') // close the previous select
                ->select2('#status_select_id')
                ->waitForText('Ready to Deploy')
                ->click('label:first-child') // close the previous select
                ->press('Save')
                ->assertPresent('.alert-success')
                ->assertNotPresent('.alert-msg');

            $browser->logout();
        });
    }

}
