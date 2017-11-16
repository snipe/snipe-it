@extends('layouts/default')

@section('title0')
  {{ trans('admin/hardware/general.requestable') }}
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

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#assets" data-toggle="tab" title="{{ trans('general.assets') }}">{{ trans('general.assets') }}</a>
                </li>
                <li>
                    <a href="#models" data-toggle="tab" title="{{ trans('general.asset_models') }}">{{ trans('general.asset_models') }}</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="assets">
                    <div class="row">
                        <div class="col-md-12">

                                @if ($assets->count() > 0)

                                <div class="table-responsive">
                                    <table
                                            name="requested-assets"
                                            data-toolbar="#toolbar"
                                            class="table table-striped snipe-table"
                                            id="table"
                                            data-advanced-search="true"
                                            data-id-table="advancedTable"
                                            data-cookie-id-table="requestableAssets">
                                        <thead>
                                            <tr role="row">
                                                <th class="col-md-1" data-sortable="true">{{ trans('general.image') }}</th>
                                                <th class="col-md-2" data-sortable="true">{{ trans('admin/hardware/table.asset_model') }}</th>
                                                <th class="col-md-2" data-sortable="true">{{ trans('admin/models/table.modelnumber') }}</th>
                                                @if ($snipeSettings->display_asset_name)
                                                <th class="col-md-2" data-sortable="true">{{ trans('admin/hardware/form.name') }}</th>
                                                @endif
                                                <th class="col-md-3" data-sortable="true">{{ trans('admin/hardware/table.serial') }}</th>
                                                <th class="col-md-2" data-sortable="true">{{ trans('admin/hardware/table.location') }}</th>
                                                <th class="col-md-2" data-sortable="true">{{ trans('admin/hardware/table.status') }}</th>
                                                <th class="col-md-2" data-sortable="true">{{ trans('admin/hardware/form.expected_checkin') }}</th>
                                                <th class="col-md-1 actions" data-sortable="false">{{ trans('table.actions') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($assets as $asset)

                                            <tr>

                                                    <td>
                                                        @if ($asset->getImageUrl())
                                                            <a href="{{ $asset->getImageUrl() }}" data-toggle="lightbox" data-type="image">
                                                                <img src="{{ $asset->getImageUrl() }}" style="max-height: {{ $snipeSettings->thumbnail_max_h }}px; width: auto;" class="img-responsive">
                                                            </a>
                                                        @endif

                                                    </td>
                                                    <td>{{ $asset->model->name }}

                                                    </td>
                                                    <td>
                                                        {{ $asset->model->model_number }}
                                                    </td>

                                                    @if ($snipeSettings->display_asset_name)
                                                    <td>{{ $asset->name }}</td>
                                                    @endif

                                                    <td>{{ $asset->serial }}</td>

                                                    <td>
                                                        @if ($asset->location)
                                                        {{ $asset->location->name }}
                                                        @endif
                                                    </td>
                                                    @if ($asset->assigned_to != '' && $asset->assigned_to > 0)
                                                        <td>Checked out</td>
                                                    @else
                                                        <td>{{ trans('admin/hardware/general.requestable') }}</td>
                                                    @endif

                                                    <td>{{ $asset->expected_checkin }}</td>
                                                    <td>
                                                        <form action="{{route('account/request-item', ['itemType' => 'asset', 'itemId' => $asset->id])}}" method="POST" accept-charset="utf-8">
                                                        {{ csrf_field() }}
                                                        @if ($asset->isRequestedBy(Auth::user()))
                                                            {{Form::submit(trans('button.cancel'), ['class' => 'btn btn-danger btn-sm'])}}
                                                        @else
                                                            {{Form::submit(trans('button.request'), ['class' => 'btn btn-primary btn-sm'])}}
                                                        @endif
                                                        </form>
                                                    </td>

                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                @else

                                    <div class="alert alert-info alert-block">
                                        <i class="fa fa-info-circle"></i>
                                        {{ trans('general.no_results') }}
                                    </div>

                                @endif

                    </div>
                </div>
            </div>

                <div class="tab-pane fade" id="models">
                    <div class="row">
                        <div class="col-md-12">

                            @if ($models->count() > 0)
                            <h4>Requestable Models</h4>
                                <table
                                        name="requested-assets"
                                        data-toolbar="#toolbar"
                                        class="table table-striped snipe-table"
                                        id="table"
                                        data-advanced-search="true"
                                        data-id-table="advancedTable"
                                        data-cookie-id-table="requestableAssets">
                                <thead>
                                    <tr role="row">
                                        <th class="col-md-1" data-sortable="true">{{ trans('general.image') }}</th>
                                        <th class="col-md-6" data-sortable="true">{{ trans('admin/hardware/table.asset_model') }}</th>
                                        <th class="col-md-3" data-sortable="true">{{ trans('admin/accessories/general.remaining') }}</th>
                                        <th class="col-md-2" data-sortable="true">{{ trans('general.quantity') }}</th>
                                        <th class="col-md-1 actions" data-sortable="false">{{ trans('table.actions') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($models as $requestableModel)
                                        <tr>
                                            <form  action="{{route('account/request-item', ['itemType' => 'asset_model', 'itemId' => $requestableModel->id])}}"
                                                    method="POST"
                                                    accept-charset="utf-8">
                                                {{ csrf_field() }}
                                                <td>
                                                    @if ($requestableModel->image)
                                                        <a href="{{ url('/') }}/uploads/models/{{ $requestableModel->image }}" data-toggle="lightbox" data-type="image">
                                                            <img src="{{ url('/') }}/uploads/models/{{ $requestableModel->image }}" style="max-height: {{ $snipeSettings->thumbnail_max_h }}px; width: auto;" class="img-responsive">
                                                        </a>
                                                    @endif

                                                </td>


                                                <td>{{$requestableModel->name}}</td>
                                                <td>{{$requestableModel->assets->where('requestable', '1')->count()}}</td>
                                                <td><input type="text" name="request-quantity" value=""></td>
                                                <td>
                                                    @if ($requestableModel->isRequestedBy(Auth::user()))
                                                        {{Form::submit(trans('button.cancel'), ['class' => 'btn btn-danger btn-sm'])}}
                                                    @else
                                                        {{Form::submit(trans('button.request'), ['class' => 'btn btn-primary btn-sm'])}}
                                                    @endif
                                                </td>
                                            </form>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            @else
                                <div class="alert alert-info alert-block">
                                    <i class="fa fa-info-circle"></i>
                                    {{ trans('general.no_results') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

            </div> <!-- .tab-content-->
        </div> <!-- .nav-tabs-custom -->
    </div> <!-- .col-md-12> -->
</div> <!-- .row -->
@stop


@section('moar_scripts')
    @include ('partials.bootstrap-table', [
        'exportFile' => 'requested-export',
        'search' => true,
        'clientSearch' => true,
    ])


    <script nonce="{{ csrf_token() }}">

    $( "a[name='Request']").click(function(event) {
        // event.preventDefault();
        quantity = $(this).closest('td').siblings().find('input').val();
        currentUrl = $(this).attr('href');
        // $(this).attr('href', currentUrl + '?quantity=' + quantity);
        // alert($(this).attr('href'));
    });
</script>
@stop


