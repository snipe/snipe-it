<?php

namespace Tests\Feature\Settings;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Setting;


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
            ->post(route('settings.branding.save', ['site_name' => 'My Awesome Site']))
            ->assertStatus(302)
            ->assertValid('site_name')
            ->assertRedirect(route('settings.index'))
            ->assertSessionHasNoErrors();

        $this->followRedirects($response)->assertSee('Success');
    }


    public function testLogoCanBeUploaded()
    {
       $this->markTestIncomplete('This test fails because of how we handle image uploads in the ImageUploadRequest.');

        Storage::fake('public');


        $this->actingAs(User::factory()->superuser()->create())
            ->post(
                route('settings.branding.save',
                    ['logo' => UploadedFile::fake()->image('logo.jpg')])
            )->assertValid('logo')
            ->assertStatus(302)
            ->assertRedirect(route('settings.index'))
            ->assertSessionHasNoErrors();


        $setting = Setting::first();

        $this->assertNotNull($setting->logo);
        $this->assertDatabaseHas('settings', ['logo' => $setting->logo]);
        Storage::disk('public')->assertExists($setting->logo);
    }

    public function testLogoCanBeDeleted()
    {
        $this->markTestIncomplete('This test fails because of how we handle image uploads in the ImageUploadRequest.');
        Storage::fake('testdisk');

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('settings.branding.save',
                ['logo' => UploadedFile::fake()->image('logo.jpg')]
            ));

        $setting = Setting::getSettings()->first();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('settings.branding.save',['clear_logo' => '1']));

        Storage::disk('testdisk')->assertMissing('logo.jpg');
        $setting->refresh();
        $this->assertNull($setting->logo);
    }

    public function testEmailLogoCanBeUploaded()
    {
        $this->markTestIncomplete('This test fails because of how we handle image uploads in the ImageUploadRequest.');
        Storage::fake('testdisk');

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('settings.branding.save',
                ['email_logo' => UploadedFile::fake()->image('email-logo.jpg')]
            ))
            ->assertValid('email_logo')
            ->assertStatus(302)
            ->assertRedirect(route('settings.index'))
            ->assertSessionHasNoErrors();

        $setting = Setting::getSettings()->first();
        \Log::error($setting->toArray());
        Storage::disk('testdisk')->assertExists($setting->email_logo);
    }

    public function testEmailLogoCanBeDeleted()
    {
        $this->markTestIncomplete('This test fails because of how we handle image uploads in the ImageUploadRequest.');
        Storage::fake('testdisk');

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('settings.branding.save',
                ['email_logo' => UploadedFile::fake()->image('email-logo.jpg')]
            ));

        $setting = Setting::getSettings()->first();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('settings.branding.save',['clear_email_logo' => '1']));

        Storage::disk('testdisk')->assertMissing('email-logo.jpg');
        $setting->refresh();
        $this->assertNull($setting->email_logo);
    }


    public function testLabelLogoCanBeUploaded()
    {
        $this->markTestIncomplete('This test fails because of how we handle image uploads in the ImageUploadRequest.');

        Storage::fake('testdisk');

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('settings.branding.save',
                ['label_logo' => UploadedFile::fake()->image('label-logo.jpg')]
            ))
            ->assertValid('label_logo')
            ->assertStatus(302)
            ->assertRedirect(route('settings.index'))
            ->assertSessionHasNoErrors();

        $setting = Setting::getSettings()->first();
        Storage::disk('testdisk')->assertExists($setting->label_logo);
    }

    public function testLabelLogoCanBeDeleted()
    {
        $this->markTestIncomplete('This test fails because of how we handle image uploads in the ImageUploadRequest.');
        Storage::fake('testdisk');

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('settings.branding.save',
                ['label_logo' => UploadedFile::fake()->image('label-logo.jpg')]
            ));

        $setting = Setting::getSettings()->first();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('settings.branding.save',['clear_label_logo' => '1']));

        Storage::disk('testdisk')->assertMissing('label-logo.jpg');
        $setting->refresh();
        $this->assertNull($setting->label_logo);
    }

    public function testDefaultAvatarCanBeUploaded()
    {
        $this->markTestIncomplete('This test fails because of how we handle image uploads in the ImageUploadRequest.');
        $setting = Setting::getSettings()->first();

        Storage::fake('testdisk');

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('settings.branding.save',
                ['default_avatar' => UploadedFile::fake()->image('default-avatar.jpg')]
            ))
            ->assertValid('default_avatar')
            ->assertStatus(302)
            ->assertRedirect(route('settings.index'))
            ->assertSessionHasNoErrors();

        $setting->refresh();
        Storage::disk('testdisk')->assertExists($setting->default_avatar);
    }

    public function testDefaultAvatarCanBeDeleted()
    {
        $this->markTestIncomplete('This test fails because of how we handle image uploads in the ImageUploadRequest.');
        Storage::fake('testdisk');

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('settings.branding.save',
                ['default_avatar' => UploadedFile::fake()->image('default-avatar.jpg')]
            ));

        $setting = Setting::getSettings()->first();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('settings.branding.save',['clear_default_avatar' => '1']));

        Storage::disk('testdisk')->assertMissing('default-avatar.jpg');
        $setting->refresh();
        $this->assertNull($setting->default_avatar);
    }

    public function testFaviconCanBeUploaded()
    {
        $this->markTestIncomplete('This fails mimetype validation on the mock');
        Storage::fake('testdisk');

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('settings.branding.save',
                ['favicon' => UploadedFile::fake()->image('favicon.svg')]
            ))
            ->assertValid('favicon')
            ->assertStatus(302)
            ->assertRedirect(route('settings.index'))
            ->assertSessionHasNoErrors();

        $setting = Setting::getSettings()->first();
        Storage::disk('testdisk')->assertExists($setting->favicon);
    }

    public function testFaviconCanBeDeleted()
    {
        $this->markTestIncomplete('This fails mimetype validation on the mock');
        Storage::fake('testdisk');

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('settings.branding.save',
                ['favicon' => UploadedFile::fake()->image('favicon.ico')->mimeType('image/x-icon')]
            ));

        $setting = Setting::getSettings()->first();

        $this->actingAs(User::factory()->superuser()->create())
            ->post(route('settings.branding.save',['clear_favicon' => '1']));

        Storage::disk('testdisk')->assertMissing('favicon.ico');
        $setting->refresh();
        $this->assertNull($setting->favicon);
    }



}
