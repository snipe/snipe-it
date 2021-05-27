<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Assigned to {{ $location->present()->fullName() }} Location</title>
    <style>
        body {
            font-family: "Arial, Helvetica", sans-serif;
        }
        table.inventory {
            border: solid #000;
            border-width: 1px 1px 1px 1px;
            width: 100%;
        }

        @page {
            size: A4;
        }
        table.inventory th, table.inventory td {
            border: solid #000;
            border-width: 0 1px 1px 0;
            padding: 3px;
            font-size: 12px;
        }

        .print-logo {
            max-height: 40px;
        }

    </style>
</head>
<body>

@if ($snipeSettings->logo_print_assets=='1')
    @if ($snipeSettings->brand == '3')

        <h3>
        @if ($snipeSettings->logo!='')
            <img class="print-logo" src="{{ url('/') }}/uploads/{{ $snipeSettings->logo }}">
        @endif
        {{ $snipeSettings->site_name }}
        </h3>
    @elseif ($snipeSettings->brand == '2')
        @if ($snipeSettings->logo!='')
            <img class="print-logo" src="{{ url('/') }}/uploads/{{ $snipeSettings->logo }}">
        @endif
    @else
      <h3>{{ $snipeSettings->site_name }}</h3>
    @endif
@endif

<h2>Asset Management System</h2>
<b>Assigned To:</b> {{ $location->present()->fullName() }}
    @if ($parent)
        {{ $parent->present()->fullName() }}
    @endif
<br>
@if ($manager)
    <b>Manager:</b> {{ $manager->present()->fullName() }}<br>
@endif
<b>Current Date:</b> {{ date("d/m/Y h:i:s A") }}<br><br>

@if ($users->count() > 0)
    @php
        $counter = 1;
    @endphp
    <table class="inventory">
        <thead>
        <tr>
            <th colspan="6">{{ trans('general.users') }}</th>
        </tr>
        </thead>
        <thead>
            <tr>
            <th style="width: 5px;"></th>
            <th style="width: 25%;">Company</th>
            <th style="width: 25%;">User Name</th>
            <th style="width: 10%;">Employee No.</th>
	        <th style="width: 20%;">Department</th>
		    <th style="width: 20%;">Location</th>
            </tr>
        </thead>
    @foreach ($users as $user)

        <tr>
        <td>{{ $counter }}</td>
        <td>{{ (($user) && ($user->company)) ? $user->company->name : '' }}</td>
        <td>{{ ($user)  ? $user->first_name .' '. $user->last_name : '' }}</td>
        <td>{{ ($user)  ? $user->employee_num : '' }}</td>
        <td>{{ (($user) && ($user->department)) ? $user->department->name : '' }}</td>
        <td>{{ (($user) && ($user->location)) ? $user->location->name : '' }}</td>
        </tr>
            @php
                $counter++
            @endphp
    @endforeach
    </table>
@endif



@if ($assets->count() > 0)
    <br><br>
    <table class="inventory">
        <thead>
        <tr>
            <th colspan="10">{{ trans('general.assets') }}</th>
        </tr>
        </thead>
        <thead>
            <tr>
            <th style="width: 20px;"></th>
            <th style="width: 10%;">Asset Tag</th>
            <th style="width: 10%;">Name</th>
            <th style="width: 10%;">Category</th>
	    <th style="width: 10%;">Manufacturer</th>
            <th style="width: 15%;">Model</th>
            <th style="width: 15%;">Serial</th>
            <th style="width: 10%;">Location</th>
            <th style="width: 10%;">Checked Out</th>
            <th style="width: 10%;">Expected Checkin</th>
            </tr>
        </thead>
		@php
        	$counter = 1;
    	@endphp
    	
    	@foreach ($assets as $asset)

        <tr>
        <td>{{ $counter }}</td>
        <td>{{ $asset->asset_tag }}</td>
        <td>{{ $asset->name }}</td>
        <td>{{ (($asset->model) && ($asset->model->category)) ? $asset->model->category->name : '' }}</td>
        <td>{{ (($asset->model) && ($asset->model->manufacturer)) ? $asset->model->manufacturer->name : '' }}</td>
        <td>{{ ($asset->model) ? $asset->model->name : '' }}</td>
        <td>{{ $asset->serial }}</td>
        <td>{{ $asset->location->name }}</td>
        <td>{{ $asset->last_checkout }}</td>
        <td>{{ $asset->expected_checkin }}</td>
        </tr>
            @php
                $counter++
            @endphp
    @endforeach
    </table>
@endif

<br>
<br>
<br>
<table>
    <tr>
        <td>Signed By (Asset Auditor):</td>
        <td>___________________________</td>
        <td></td>
        <td>Date:</td>
        <td>____________________</td>
    </tr>
</table>
<br>
<br>
<br>
<table>
    <tr>
        <td>Signed By (Finance Asset Auditor):</td>
        <td>____________________</td>
        <td></td>
        <td>Date:</td>
        <td>____________________</td>
    </tr>
</table>
<br>
<br>
<br>
<table>
    <tr>
        <td>Signed By (Location Manager):</td>
        <td>_______________________</td>
        <td></td>
        <td>Date:</td>
        <td>____________________</td>
    </tr>
</table>


</body>
</html>
