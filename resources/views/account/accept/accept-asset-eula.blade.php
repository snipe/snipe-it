<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
</head>
<body>

@if ($signature)
    <center>
        <img src="{{ $logo }}">
        <p>{{$company_name}}</p>
    </center>
@endif
<br>

<p>Date: {{ date($date_settings) }} </p><br>
<p>Asset Tag: {{ $item_tag }}</p>
<p>Asset Model: {{ $item_model }}</p>
<p>Asset Serial: {{ $item_serial }}</p><br>
@if ($eula)
    {!!  $eula !!}
@endif

<br>

<p>Assigned on: {{$check_out_date}}</p>
<p>Accepted on: {{$accepted_date}}</p>
<p>Assigned to: {{$assigned_to}}</p>
@if ($signature)
    <center>
        <img src="{{ $signature }}" style="max-width: 50%">
    </center>
@endif
</body>
</html>