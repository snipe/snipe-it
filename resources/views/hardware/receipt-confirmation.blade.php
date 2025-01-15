@extends('layouts/receipt-confirmation')

{{-- Page title --}}
@section('title')
    {{ trans('admin/hardware/general.view') }} {{ $asset->asset_tag }}
    @parent
@stop

{{-- Page content --}}
@section('content')
<style>
    header{
        color:saddlebrown;
        font-family: sans-serif;
        float: right;
    }
    .hamm-logo{
        transform: matrix(4.12,0,0,3,60,0);
        font-family:Century Gothic,serif;
        display: inline-block;
        margin-bottom: 0.3rem;
    }
    body{
        width: 21cm;
        height: 29.7cm;
        margin: 5rem 5rem;
        font-family: sans-serif;
    }
    body:last-child {
        page-break-after: auto;
    }
    table{
        width: 100%;
        table-layout:fixed;
    }
    table, td {
        border: 1px solid black;
        border-collapse: collapse;
        padding: 10px;
    }
    input{ border: none; width: 100%}
    hr{
        margin:0;
    }
    .space-between{
        display: flex;
        justify-content: space-between;
        margin: 100px 0;
    }
    footer{
        font-size: small;
        color: grey;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: fixed;
        bottom: 0;
        border-top: 1px solid grey;
        width: 21cm;
    }
    @media print {
        body{
            margin: 5rem 0;
            height: 0;
        }
    }
</style>
<header>
    <span class="hamm-logo" style="color: saddlebrown !important;">hamm</span>
    <br>
    <span style="font-size: x-small; color: saddlebrown !important;">market solution for branded footwear</span>
</header>
<br>
<div style="margin: 100px 0;">
    <h3 class="heading">Bestätigung des Erhalts für Endgeräte</h3>
    <br>
    <br>
    <br>
    <h4>Anlage @if (($asset->assignedTo) && ($asset->deleted_at=='')) {!!  $asset->assignedTo->present()->nameUrl() !!} @endif @if ($asset->model) {{ $asset->model->name }} @endif</h4>
    <p>Hiermit bestätige ich, folgendes Endgerät und weiteres Zubehör erhalten zu haben:</p>
    <!--Oberen Bereich-->
    <table>
        <tr>
            <td>Bezeichnung / Gerät / Typ:</td>
            <td>@if ($asset->name) {{ $asset->name }} @else <input placeholder="Hier wert eingeben oder Leertaste drucken"></input> @endif</td>
        </tr>
        <tr>
            <td>Inventar Nr.</td>
            <td>@if ($asset->asset_tag) {{ $asset->asset_tag }} @else <input placeholder="Hier wert eingeben oder Leertaste drucken"></input> @endif</td>
        </tr>
    </table>
    <br>
    <br>
    <!--unteren Bereich-->
    <table>
        <tr>
            <td>Zubehör:</td>
            <td><input placeholder="Zubehör hier eingeben oder Leertaste drucken"></td>
        </tr>
        <tr>
            <td><input placeholder="Zubehör II:"></td>
            <td><input placeholder="Zubehör hier eingeben oder Leertaste drucken"></td>
        </tr>
        <tr>
            <td><input placeholder="Zubehör III:"></td>
            <td><input placeholder="Zubehör hier eingeben oder Leertaste drucken"></td>
        </tr>
    </table>
</div>
<div class="w-50">
    Osnabrück, den
    @php $today = Carbon\Carbon::now();
    echo Carbon\Carbon::parse($today)->format('d.m.Y');
    @endphp
    <hr>
    Ort, Datum
</div>
<div class="space-between">
    <div>
    </div>
    <div>
        <hr>
        Unterschrift Mitarbeiter(in)
    </div>
</div>
<br>
<footer>
    <div style="color: grey !important;">Hamm Footwear GmbH</div>
    <div style="color: grey !important;">
        @php setlocale (LC_ALL, 'de_DE@euro', 'de_DE', 'de', 'ge'); @endphp
        {{strftime("%B %G", strtotime("now"))}}
    </div>
    <div style="color: grey !important;">Seite 1 von 1</div>
</footer>
@stop
