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
            <div class="box">
                <div class="box-body">
                    {{ Form::open([
                      'method' => 'POST',
                      'route' => ['hardware/bulkedit'],
                      'class' => 'form-inline',
                       'id' => 'bulkForm']) }}
                    <div class="row">
                        <div class="col-md-12">

        @if ($requestedItems->count() > 0)
        <div class="table-responsive">
            <table
                    name="requestedAssets"
                    data-toolbar="#toolbar"
                    class="table table-striped snipe-table"
                    id="requestedAssets"
                    data-advanced-search="true"
                    data-search="true"
                    data-show-columns="true"
                    data-show-export="true"
                    data-pagination="true"
                    data-id-table="requestedAssets"
                    data-cookie-id-table="requestedAssets"
                    data-url="{{ route('api.consumables.index') }}"
                    data-export-options='{
                    "fileName": "export-assetrequests-{{ date('Y-m-d') }}",
                    "ignoreColumn": ["actions","image","change","checkbox","checkincheckout","icon"]
                    }'>
                <thead>
                    <tr role="row">
                        <th class="col-md-1">Image</th>
                        <th class="col-md-2">Item Name</th>
                        <th class="col-md-2" data-sortable="true">{{ trans('admin/hardware/table.location') }}</th>
                        <th class="col-md-2" data-sortable="true">{{ trans('admin/hardware/form.expected_checkin') }}</th>
                        <th class="col-md-3" data-sortable="true">Requesting User</th>
                        <th class="col-md-2">Requested Date</th>
                        <th class="col-md-1"></th>
                        <th class="col-md-1"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requestedItems as $request)

                        @if ($request->requestable)
                    <tr>
                            {{ csrf_field() }}
                            <td>
                                @if (($request->itemType() == "asset") && ($request->requestable))
                                    <a href="{{ $request->requestable->getImageUrl() }}" data-toggle="lightbox" data-type="image"><img src="{{ $request->requestable->getImageUrl() }}" style="max-height: {{ $snipeSettings->thumbnail_max_h }}px; width: auto;" class="img-responsive"></a>
                                @elseif (($request->itemType() == "asset_model") && ($request->requestable))
                                        <a href="{{ url('/') }}/uploads/models/{{ $request->requestable->image }}" data-toggle="lightbox" data-type="image"><img src="{{ url('/') }}/uploads/models/{{ $request->requestable->image }}" style="max-height: {{ $snipeSettings->thumbnail_max_h }}px; width: auto;" class="img-responsive"></a>
                                @endif


                            </td>
                            <td>

                            @if ($request->itemType() == "asset")
                            <a href="{{ url('/') }}/hardware/{{ $request->requestable->id }}">
                                {{ $request->name() }}
                            </a>
                            @elseif ($request->itemType() == "asset_model")
                                <a href="{{ url('/') }}/models/{{ $request->requestable->id }}">
                                    {{ $request->name() }}
                                </a>
                             @endif

                            </td>
                            @if ($request->location())
                            <td>{{ $request->location()->name }}</td>
                            @else
                            <td></td>
                            @endif

                            <td>
                            @if ($request->itemType() == "asset")
                                {{ App\Helpers\Helper::getFormattedDateObject($request->requestable->expected_checkin, 'datetime', false) }}
                            @endif
                            </td>
                            <td>
                                @if ($request->requestingUser())
                                <a href="{{ url('/') }}/users/{{ $request->requestingUser()->id }}">
                                    {{ $request->requestingUser()->present()->fullName() }}
                                </a>
                               @else
                                    (deleted user)
                                @endif
                            </td>
                            <td>{{ App\Helpers\Helper::getFormattedDateObject($request->created_at, 'datetime', false) }}</td>
                            <td>
                                @if ($request->itemType() == "asset")
                                    @if ($request->requestable->assigned_to=='')
                                        <a href="{{ url('/') }}/hardware/{{ $request->requestable->id }}/checkout" class="btn btn-sm bg-maroon" data-tooltip="true" title="Check this item out to a user">{{ trans('general.checkout') }}</a>
                                        @else
                                        <a href="{{ url('/') }}/hardware/{{ $request->requestable->id }}/checkin" class="btn btn-sm bg-purple" data-tooltip="true" title="Check this itemi">{{ trans('general.checkin') }}</a>
                                    @endif

                                @endif
                            </td>


                    </tr>
                    @endif
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- .col-md-12> -->
</div> <!-- .row -->
@stop

@section('moar_scripts')
    @include ('partials.bootstrap-table', [
        'exportFile' => 'requested-export',
        'search' => true,
        'clientSearch' => true,
    ])

@stop
