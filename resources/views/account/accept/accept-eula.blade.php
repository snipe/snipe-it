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
    </center>
@endif
<br>

<p>Date: {{ date($date_settings) }} </p><br>
<p>Asset Tag: {{ $item_tag }}</p>
<p>Asset Model: {{ $item_model }}</p>
<p>Asset Tag: {{ $item_serial }}</p><br>
@if ($eula)
    {!!  $eula !!}
@endif

<br><br>
<p> On {{$check_out_date}} {{$company_name}} is assigning item {{$item_tag}} to {{$assigned_to}}. <br>
    They accept responsibility of said item until it is returned.</p><br>
<p>Assigned on: {{$check_out_date}}</p>
<p>Accepted on: {{$accepted_date}}</p><br>
<p>Assigned to: {{$assigned_to}}</p>
@if ($signature)
    <center>
        <img src="{{ $signature }}" style="max-width: 50%">
    </center>
@endif
</body>
</html>