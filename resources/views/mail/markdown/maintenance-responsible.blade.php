@component('mail::message')
# Halo {{ $recipient->display_name }},

{{ $intro }}

@component('mail::table')
|        |          |
| ------------- | ------------- |
| **Aset** | {{ $assetLabel }} |
| **Nama** | {{ $maintenance->name }} |
@if ($typeName)
| **Tipe** | {{ $typeName }} |
@endif
@if ($start)
| **Tanggal Mulai** | {{ $start }} |
@endif
@if ($expected)
| **Perkiraan Selesai** | {{ $expected }} |
@endif
| **Selesai Pada** | {{ $completed ?: 'Belum selesai' }} |
@if ($supplierName)
| **Supplier** | {{ $supplierName }} |
@endif
@if ($maintenance->notes)
| **Catatan** | {{ \Illuminate\Support\Str::limit($maintenance->notes, 300) }} |
@endif
@endcomponent

@if (!empty($diff))
**Yang berubah:**

@component('mail::table')
| Kolom | Sebelumnya | Sekarang |
| ------------- | ------------- | ------------- |
@foreach ($diff as $row)
| {{ $row['label'] }} | {{ $row['old'] }} | {{ $row['new'] }} |
@endforeach
@endcomponent
@endif

@component('mail::button', ['url' => $maintenanceUrl])
Lihat Maintenance
@endcomponent

@if ($assetUrl)
[Lihat Aset]({{ $assetUrl }})
@endif

Terima kasih,

{{ $snipeSettings->site_name }}

@endcomponent
