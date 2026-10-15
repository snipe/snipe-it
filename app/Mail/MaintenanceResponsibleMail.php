<?php

namespace App\Mail;

use App\Models\Maintenance;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

/**
 * Email untuk Responsible Party pada Maintenance.
 * event: created | assigned | updated | completed
 */
class MaintenanceResponsibleMail extends BaseMailable
{
    use Queueable, SerializesModels;

    /** Kolom yang dipantau => label di email */
    public const LABELS = [
        'name' => 'Nama',
        'maintenance_type_id' => 'Tipe',
        'start_date' => 'Tanggal Mulai',
        'expected_completion_date' => 'Perkiraan Selesai',
        'completed_at' => 'Selesai Pada',
        'supplier_id' => 'Supplier',
        'responsible_party_id' => 'Responsible Party',
        'is_warranty' => 'Warranty Improvement',
        'cost' => 'Biaya',
        'url' => 'URL',
        'notes' => 'Catatan',
    ];

    public function __construct(
        protected Maintenance $maintenance,
        protected User $recipient,
        protected string $event,
        protected array $changes = []
    ) {
    }

    protected function assetLabel(): string
    {
        $item = $this->maintenance->item ?? $this->maintenance->asset;

        return $item ? trim(($item->asset_tag ?? '').' '.($item->name ?? '')) : '-';
    }

    public function envelope(): Envelope
    {
        $prefix = [
            'created' => '[Maintenance Baru] ',
            'assigned' => '[Anda Ditugaskan] ',
            'updated' => '[Maintenance Diperbarui] ',
            'completed' => '[Maintenance Selesai] ',
        ][$this->event] ?? '[Maintenance] ';

        return new Envelope(
            from: new Address(config('mail.from.address'), config('mail.from.name')),
            subject: $prefix.$this->assetLabel().' - '.$this->maintenance->name,
        );
    }

    public function content(): Content
    {
        $m = $this->maintenance;
        $item = $m->item ?? $m->asset;

        $intro = [
            'created' => 'Ada maintenance baru dan Anda ditunjuk sebagai Responsible Party.',
            'assigned' => 'Anda ditunjuk sebagai Responsible Party untuk maintenance berikut.',
            'updated' => 'Ada perubahan pada maintenance yang menjadi tanggung jawab Anda.',
            'completed' => 'Maintenance yang menjadi tanggung jawab Anda telah ditandai selesai.',
        ][$this->event] ?? '';

        $diff = [];
        foreach ($this->changes as $key => $pair) {
            $diff[] = [
                'label' => self::LABELS[$key] ?? $key,
                'old' => $this->display($key, $pair['old'] ?? null),
                'new' => $this->display($key, $pair['new'] ?? null),
            ];
        }

        return new Content(
            markdown: 'mail.markdown.maintenance-responsible',
            with: [
                'recipient' => $this->recipient,
                'intro' => $intro,
                'assetLabel' => $this->assetLabel(),
                'maintenance' => $m,
                'typeName' => $m->maintenanceType?->name ?? $m->asset_maintenance_type,
                'supplierName' => $m->supplier?->name,
                'start' => $m->start_date?->format('d M Y H:i'),
                'expected' => $m->expected_completion_date?->format('d M Y H:i'),
                'completed' => $m->completed_at?->format('d M Y H:i'),
                'diff' => $diff,
                'maintenanceUrl' => route('maintenances.show', $m),
                'assetUrl' => ($item instanceof \App\Models\Asset) ? route('hardware.show', $item->id) : null,
            ],
        );
    }

    /** Ubah nilai mentah kolom menjadi teks yang mudah dibaca */
    protected function display(string $key, $value): string
    {
        if ($value === null || $value === '') {
            return '(kosong)';
        }

        return match ($key) {
            'supplier_id' => Supplier::withTrashed()->find($value)?->name ?? (string) $value,
            'maintenance_type_id' => \App\Models\MaintenanceType::find($value)?->name ?? (string) $value,
            'responsible_party_id' => User::withTrashed()->find($value)?->display_name ?? (string) $value,
            'is_warranty' => $value ? 'Ya' : 'Tidak',
            default => Str::limit((string) $value, 150),
        };
    }
}
