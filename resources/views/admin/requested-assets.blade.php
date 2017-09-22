@extends('layouts/default')

@section('title0')
  {{ trans('admin/hardware/general.requested') }}
  {{ trans('general.assets') }}
@stop

{{-- Page title --}}
@section('title')
    @yield('title0')  @parent
@stop

{{-- Page content --}}
@section('content')

<div class="row">
    <div class="col-md-12">

        @if ($requestedItems->count() > 0)
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr role="row">
                        <th class="col-md-1">Item Type</th>
                        <th class="col-md-1">Item Name</th>
                        <th class="col-md-1" bSortable="true">{{ trans('admin/hardware/table.location') }}</th>
                        <th class="col-md-1" bSortable="true">{{ trans('admin/hardware/form.expected_checkin') }}</th>
                        <th class="col-md-1" bSortable="true">Requesting User</th>
                        <th class="col-md-1">Requested Date</th>
                        <th class="col-md-1 actions" bSortable="false">{{ trans('table.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requestedItems as $request)
                    <tr>
                        <form action="#" method="POST" accept-charset="utf-8">
                            {{ csrf_field() }}
                            <td>{{ $request->itemType() }}</td>
                            <td>{{ $request->name() }}</td>
                            @if ($request->location())
                            <td>{{ $request->location()->name }}</td>
                            @else
                            <td></td>
                            @endif

                            <td>
                            @if ($request->itemType() == "asset") 
                                {{ $request->itemRequested()->expected_checkin }}
                            @else
                                "N/A"
                            @endif
                            </td>
                            <td>{{ $request->requestingUser()->present()->fullName() }}</td>
                            <td>{{$request->created_at}}</td>
                            <td>
                            </td>
                        </form>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @else
        <div class="col-md-12">
            <div class="alert alert-info alert-block">
                <i class="fa fa-info-circle"></i>
                {{ trans('general.no_results') }}
            </div>
        </div>
        @endif
    </div> <!-- .col-md-12> -->
</div> <!-- .row -->
@stop
