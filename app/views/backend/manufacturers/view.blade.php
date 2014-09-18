@extends('backend/layouts/default')

{{-- Page title --}}
@section('title')
@lang('base.manufacturer') : {{ $manufacturer->name }} ::
@parent
@stop

{{-- Page content --}}
@section('content')

<div class="row header">
    <div class="col-md-12">
        <a href="{{ route('update/manufacturer', $manufacturer->id) }}" class="btn btn-warning pull-right">@lang('actions.update')</a>
        <h3 class="name">@lang('base.manufacturer') :      
        {{{ $manufacturer->name }}} </h3>
    </div>
</div>

<div class="user-profile">
    <div class="row profile">
        <div class="col-md-9 bio">
            <!-- Tabs -->
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab-hardware" data-toggle="tab"><strong>Hardware</strong></a></li>
                <li><a href="#tab-software" data-toggle="tab"><strong>Software</strong></a></li>
            </ul>

            <!-- Tabs Content -->
            <div class="tab-content">
                <!-- Hardware tab -->
                <div class="tab-pane active" id="tab-hardware">
                    <br>
                    <!-- suppliers hardware asset list table -->
                    @if ($manufacturer->has_models() > 0)
                    <table id='pgtable1'>
                        <thead>
                            <tr role="row">
                                <th class="col-md-4">@lang('general.name')</th>
                                <th class="col-md-2">@lang('general.modelnumber')</th>
                                <th class="col-md-2">@lang('general.count')</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($manufacturer->models as $model)
                            <tr>
                                <td><a href="{{ route('view/model', $model->id) }}">{{{ $model->name }}}</a></td>
                                <td>{{{ $model->modelno }}}</td>  
                                <td>{{$model->has_assets()}}</td>  
                            </tr>
                            @endforeach


                        </tbody>
                    </table>

                    @else
                    <div class="col-md-10"><br>
                        <div class="alert alert-info alert-block">
                            <i class="icon-info-sign"></i>
                            @lang('general.no_results')
                        </div>
                    </div>
                    @endif

                    <!-- End of Hardware tab -->
                </div>

                <!-- Software tab -->
                <div class="tab-pane" id="tab-software">
                    <br>
                    <!-- suppliers hardware asset list table -->
                    @if ($manufacturer->has_licenses() > 0)
                    <table id='pgtable2'>
                        <thead>
                            <tr role="row">
                                <th class="col-md-3">@lang('general.name')</th>
                                <th class="col-md-3">@lang('general.serialnumber')</th>
                                <th class="col-md-3">@lang('base.licenseseats_shortname')</th>
                                <th class="col-md-3">@lang('base.family')</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($manufacturer->licenses as $licence)
                            <tr>
                                <td><a href="{{ route('view/license', $licence->id) }}">{{{ $licence->name }}}</a></td>
                                <td>{{{ $licence->serial }}}</td>
                                <td>{{{ $licence->seats }}}</td>
                                <td>
                                    @if($licence->family_id)
                                        {{ $licence->family->name }}
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                    <div class="col-md-10"><br>
                        <div class="alert alert-info alert-block">
                            <i class="icon-info-sign"></i>
                            @lang('general.no_results')
                        </div>
                    </div>
                    @endif

                    <!-- End of Software tab -->
                </div>
                <!-- End of tab content -->

            </div>
        </div> 

        <!-- side address column -->
        <div class="col-md-3 col-xs-12 address pull-right">
            <h4>@lang('base.manufacturer_about')</h4>
            <br>
            <p>@lang('admin/manufacturers/message.about') </p>

        </div>
                
    </div>
</div>
@stop
