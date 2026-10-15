<?php

namespace App\Observers;

use App\Mail\MaintenanceResponsibleMail;
use App\Models\Maintenance;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Kirim email ke Responsible Party saat maintenance dibuat / diubah.
 * Dipisah dari MaintenanceObserver bawaan agar tidak mengubah file inti.
 */
class MaintenanceResponsibleObserver
{
    public function created(Maintenance $maintenance): void
    {
        $this->send($maintenance, 'created');
    }

    public function updated(Maintenance $maintenance): void
    {
        // Hanya kolom yang dipantau (abaikan updated_at, kolom teknis, dll)
        $changes = collect($maintenance->getChanges())
            ->only(array_keys(MaintenanceResponsibleMail::LABELS));

        if ($changes->isEmpty()) {
            return;
        }

        if ($changes->has('responsible_party_id')) {
            // Responsible Party baru/diganti: orang barunya dapat email lengkap
            $this->send($maintenance, 'assigned');

            return;
        }

        $diff = $changes->mapWithKeys(fn ($new, $key) => [
            $key => ['old' => $maintenance->getRawOriginal($key), 'new' => $new],
        ])->all();

        $completedNow = $changes->has('completed_at') && $maintenance->completed_at !== null;

        $this->send($maintenance, $completedNow ? 'completed' : 'updated', $diff);
    }

    private function send(Maintenance $maintenance, string $event, array $changes = []): void
    {
        // Responsible Party kosong (termasuk sengaja dikosongkan) = tidak ada email
        if (! $maintenance->responsible_party_id) {
            return;
        }

        try {
            $user = User::find($maintenance->responsible_party_id);

            if (! $user || ! $user->email) {
                return;
            }

            Mail::to($user->email)->send(
                new MaintenanceResponsibleMail($maintenance, $user, $event, $changes)
            );
        } catch (\Throwable $e) {
            // Kegagalan SMTP tidak boleh menggagalkan penyimpanan data
            Log::error('Gagal kirim email maintenance (ID '.$maintenance->id.'): '.$e->getMessage());
        }
    }
}
