<?php

namespace Tests\Feature\Settings;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;


class BrandingSettingsTest extends TestCase
{
    public function testSiteNameIsRequired()
    {
        $response = $this->actingAs(User::factory()->superuser()->create())
            ->from(route('settings.branding.index'))
            ->post(route('settings.branding.save', ['site_name' => '']))
            ->assertSessionHasErrors(['site_name'])
            ->assertInvalid(['site_name'])
            ->assertStatus(302)
            ->assertRedirect(route('settings.branding.index'));

        $this->followRedirects($response)->assertSee(trans('general.error'));
    }

    public function testSiteNameCanBeSaved()
    {
        $response = $this->actingAs(User::factory()->superuser()->create())
            ->post(route('settings.branding.save', ['site_name' => 'MyAwesomeSite']))
            ->assertStatus(302)
            ->assertValid('site_name')
            ->assertRedirect(route('settings.index'))
            ->assertSessionHasNoErrors();

        $this->followRedirects($response)->assertSee('Success');
    }


    public function testLogoCanBeUploaded()
    {
        Storage::fake('logo');

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('settings.branding.save',
                ['logo' => UploadedFile::fake()->image('logo.jpg')]
            ))
            ->assertStatus(302);

        Storage::disk('logo')->assertExists('logo.jpg');
    }
//
//
//    public function testLogoCanBeDeleted()
//    {
//        Storage::fake('logo');
//        UploadedFile::fake()->image('logo.jpg');
//        Storage::disk('logo')->assertExists('logo.jpg');
//
//        $this->actingAs(User::factory()->superuser()->create())
//            ->post(route('settings.branding.save',
//                ['clear_logo' => '1'
//                ]));
//
//        Storage::disk('logo')->assertMissing('logo.jpg');
//    }

}
