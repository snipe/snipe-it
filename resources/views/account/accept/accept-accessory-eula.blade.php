<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
        }
    </style>
</head>
<body>

@if ($signature)
    <center>
        <img src="{{ $logo }}">
        <p>{{$company_name}}</p>
    </center>
@endif
<br>

<p>
    {{ trans('general.date') }}: {{ date($date_settings) }} <br>
    {{ trans('general.asset_tag') }}: {{ $item_tag }}<br>
    {{ trans('general.asset_model') }}: {{ $item_model }}<br>
    {{ trans('general.serial') }}: {{ $item_serial }}</p>


@if ($eula)
    <hr>
    {!!  $eula !!}
    <hr>
@endif


<p>
    Assigned on: {{$check_out_date}}<br>
    Assigned to: {{$assigned_to}}
</p>


@if ($signature)
    <div style="width: 60%; float:left">
        <img src="{{ $signature }}" style="max-width: 100%; border-bottom: black solid 1px;"><br>
        {{ trans('general.signature') }}: {{$accepted_date}}
    </div>
@endif
</body>
</html>