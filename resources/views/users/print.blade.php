<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Assigned to {{ $user->present()->fullName() }}</title>
    <style>
        body {
            font-family: "Arial, Helvetica", sans-serif;
        }
        table {
            border: solid #000;
            border-width: 1px 0 0 1px;
            width: 100%;
        }

        @page {
            size: A4;
        }
        th, td {
            border: solid #000;
            border-width: 0 1px 1px 0;
            padding: 3px;
            font-size: 14px;
        }
    </style>
</head>
<body>
<h3>Assigned to {{ $user->present()->fullName() }}</h3>

@if ($assets->count() > 0)
    @php
        $counter = 1;
    @endphp
    <h4>Assets</h4>
    <table>
        <th></th>
        <th>Asset Tag</th>
        <th>Name</th>
        <th>Category</th>
        <th>Model</th>
        <th>Checked Out</th>
    @foreach ($assets as $asset)

        <tr>
            <td>{{ $counter }}</td>
            <td>{{ $asset->asset_tag }}</td>
            <td>{{ $asset->name }}</td>
            <td>{{ $asset->model->category->name }}</td>
            <td>{{ $asset->model->name }}</td>
            <td>
                {{ $asset->last_checkout }}</td>
        </tr>
            @php
                $counter++
            @endphp
    @endforeach
    </table>
@endif

@if ($licenses->count() > 0)
    <h4>Licenses</h4>
    <table>
        <th></th>
        <th>Name</th>
        <th>Checked Out</th>
        @php
        $lcounter = 1;
        @endphp

        @foreach ($licenses as $license)

            <tr>
                <td>{{ $lcounter }}</td>
                <td>{{ $license->name }}</td>
                <td>{{  $license->created_at }}</td>
            </tr>
            @php
                $lcounter++
            @endphp
        @endforeach
    </table>
@endif


</body>
</html>
