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
                    <a href="#assets" data-toggle="tab" title="{{ trans('general.assets') }}">{{ trans('general.assets') }}
                        <badge class="badge badge-secondary"> {{ $assets->count()}}</badge>
                    </a>               
                </li>
                <li>
                    <a href="#models" data-toggle="tab" title="{{ trans('general.asset_models') }}">{{ trans('general.asset_models') }}
                        <badge class="badge badge-secondary"> {{ $models->count()}}</badge>
                    </a>                   
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="assets">
                    <div class="row">
                        <div class="col-md-12">
                                <div class="table-responsive">
                                    <table
                                        data-click-to-select="true"
                                        data-cookie-id-table="requestableAssetsListingTable"
                                        data-pagination="true"
                                        data-id-table="requestableAssetsListingTable"
                                        data-search="true"
                                        data-side-pagination="server"
                                        data-show-columns="true"
                                        data-show-export="false"
                                        data-show-footer="false"
                                        data-show-refresh="true"
                                        data-sort-order="asc"
                                        data-sort-name="name"
                                        data-toolbar="#toolbar"
                                        id="assetsListingTable"
                                        class="table table-striped snipe-table"
                                        data-url="{{ route('api.assets.requestable', ['requestable' => true]) }}">

                                        <thead>
                                            <tr>
                                                <th class="col-md-1" data-field="image" data-formatter="imageFormatter" data-sortable="true">{{ trans('general.image') }}</th>
                                                <th class="col-md-2" data-field="model" data-sortable="true">{{ trans('admin/hardware/table.asset_model') }}</th>
                                                <th class="col-md-2" data-field="model_number" data-sortable="true">{{ trans('admin/models/table.modelnumber') }}</th>
                                                <th class="col-md-2" data-field="name" data-sortable="true">{{ trans('admin/hardware/form.name') }}</th>
                                                <th class="col-md-3" data-field="serial" data-sortable="true">{{ trans('admin/hardware/table.serial') }}</th>
                                                <th class="col-md-2" data-field="location" data-sortable="true">{{ trans('admin/hardware/table.location') }}</th>
                                                <th class="col-md-2" data-field="status" data-sortable="true">{{ trans('admin/hardware/table.status') }}</th>
                                                <th class="col-md-2" data-field="expected_checkin" data-formatter="dateDisplayFormatter" data-sortable="true">{{ trans('admin/hardware/form.expected_checkin') }}</th>
                                                <th class="col-md-1" data-formatter="assetRequestActionsFormatter" data-field="actions" data-sortable="false">{{ trans('table.actions') }}</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                    </div>
                </div>
            </div>

                <div class="tab-pane fade" id="models">
                    <div class="row">
                        <div class="col-md-12">

                            @if ($models->count() > 0)
                            <h2>{{ trans('general.requestable_models') }}</h4>
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

                                        <th class="col-md-2 actions" data-sortable="false">{{ trans('table.actions') }}</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach($models as $requestableModel)
                                        <tr>

                                                <td>

                                                    @if ($requestableModel->image)
                                                        <a href="{{ url('/') }}/uploads/models/{{ $requestableModel->image }}" data-toggle="lightbox" data-type="image">
                                                            <img src="{{ url('/') }}/uploads/models/{{ $requestableModel->image }}" style="max-height: {{ $snipeSettings->thumbnail_max_h }}px; width: auto;" class="img-responsive">
                                                        </a>
                                                    @endif

                                                </td>

                                                <td>
                                                    @can('view', \App\Models\AssetModel::class)
                                                        <a href="{{ url('/') }}'/models/'.{{ $requestableModel->id }}) }}">{{ $requestableModel->name }}</a>
                                                    @else
                                                        {{ $requestableModel->name }}
                                                    @endcan
                                                </td>

                                                <td>{{$requestableModel->assets->where('requestable', '1')->count()}}</td>

                                                <td>
                                                    <form  action="{{ route('account/request-item', ['itemType' => 'asset_model', 'itemId' => $requestableModel->id])}}" method="POST" accept-charset="utf-8">
                                                        {{ csrf_field() }}
                                                    <input type="text" style="width: 70px; margin-right: 10px;" class="form-control pull-left" name="request-quantity" value="" placeholder="{{ trans('general.qty') }}">
                                                    @if ($requestableModel->isRequestedBy(Auth::user()))
                                                        {{ Form::submit(trans('button.cancel'), ['class' => 'btn btn-danger btn-sm'])}}
                                                    @else
                                                        {{ Form::submit(trans('button.request'), ['class' => 'btn btn-primary btn-sm'])}}
                                                    @endif
                                                    </form>
                                                </td>
                                        </tr>

                                    @endforeach
                                </tbody>
                            </table>

                            @else
                                <div class="alert alert-info alert-block">
                                    <i class="fas fa-info-circle"></i>
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


