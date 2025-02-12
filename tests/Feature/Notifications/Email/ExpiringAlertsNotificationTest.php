<?php

namespace Tests\Feature\Notifications\Email;

use App\Mail\ExpiringAssetsMail;
use App\Mail\ExpiringLicenseMail;
use App\Models\Asset;
use App\Models\License;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;


class ExpiringAlertsNotificationTest extends TestCase
{
     public function testExpiringAssetsEmailNotification()
     {
         $this->markIncompleteIfSqlite();
         Mail::fake();

         $this->settings->enableAlertEmail('admin@example.com');
         $this->settings->setAlertInterval(30);

         $alert_email = Setting::first()->alert_email;

         $expiringAsset = Asset::factory()->create([
             'purchase_date' => now()->subMonths(11)->format('Y-m-d'),
             'warranty_months' => 12,
             'archived' => 0,
             'deleted_at' => null,
         ]);

         $expiredAsset = Asset::factory()->create([
             'purchase_date' => now()->subMonths(13)->format('Y-m-d'),
             'warranty_months' => 12,
             'archived' => 0,
             'deleted_at' => null,
         ]);
         $notExpiringAsset = Asset::factory()->create([
             'purchase_date' => now()->subMonths(10)->format('Y-m-d'),
             'warranty_months' => 12,
             'archived' => 0,
             'deleted_at' => null,
         ]);

         $this->artisan('snipeit:expiring-alerts')->assertExitCode(0);

         Mail::assertSent(ExpiringAssetsMail::class, function($mail) use ($alert_email, $expiringAsset) {
             return $mail->hasTo($alert_email) && $mail->assets->contains($expiringAsset);
         });

         Mail::assertNotSent(ExpiringAssetsMail::class, function($mail) use ($expiredAsset, $notExpiringAsset) {
             return $mail->assets->contains($expiredAsset) || $mail->assets->contains($notExpiringAsset);
         });
     }

     public function testExpiringLicensesEmailNotification()
     {
         $this->markIncompleteIfSqlite();
         Mail::fake();
         $this->settings->enableAlertEmail('admin@example.com');
         $this->settings->setAlertInterval(60);

         $alert_email = Setting::first()->alert_email;

         $expiringLicense = License::factory()->create([
             'expiration_date' => now()->addDays(30)->format('Y-m-d'),
             'deleted_at' => null,
         ]);

         $expiredLicense = License::factory()->create([
             'expiration_date' => now()->subDays(10)->format('Y-m-d'),
             'deleted_at' => null,
         ]);
         $notExpiringLicense = License::factory()->create([
             'expiration_date' => now()->addMonths(3)->format('Y-m-d'),
             'deleted_at' => null,
         ]);

         $this->artisan('snipeit:expiring-alerts')->assertExitCode(0);

         Mail::assertSent(ExpiringLicenseMail::class, function($mail) use ($alert_email, $expiringLicense) {
             return $mail->hasTo($alert_email) && $mail->licenses->contains($expiringLicense);
         });

         Mail::assertNotSent(ExpiringLicenseMail::class, function($mail) use ($expiredLicense, $notExpiringLicense) {
             return $mail->licenses->contains($expiredLicense) || $mail->licenses->contains($notExpiringLicense);
         });
     }
}