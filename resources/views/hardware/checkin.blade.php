@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/hardware/general.checkin') }}
    @parent
@stop

{{-- Page content --}}
@section('content')
    <style>

        .input-group {
            padding-left: 0px !important;
        }
    </style>


    <div class="row">
        <!-- left column -->
        <div class="col-md-9">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h2 class="box-title">{{ trans('admin/hardware/form.tag') }} {{ $asset->asset_tag }}</h2>
                </div><!-- /.box-header -->

                <div class="box-body">
                    <div class="col-md-12">
                        @if ($backto=='user')
                            <form class="form-horizontal" method="post"
                                  action="{{ route('checkin/hardware', array('assetId'=> $asset->id, 'backto'=>'user')) }}"
                                  autocomplete="off">
                                @else
                                    <form class="form-horizontal" method="post"
                                          action="{{ route('checkin/hardware', $asset->id) }}" autocomplete="off">
                                    @endif
                                    {{csrf_field()}}

                                    <!-- AssetModel name -->
                                        <div class="form-group">
                                            {{ Form::label('model', trans('admin/hardware/form.model'), array('class' => 'col-md-3 control-label')) }}
                                            <div class="col-md-8">
                                                <p class="form-control-static">
                                                    @if (($asset->model) && ($asset->model->name))
                                                        {{ $asset->model->name }}

                                                    @else
                                                        <span class="text-danger text-bold">
                      <i class="fa fa-exclamation-triangle"></i>This asset's model is invalid!
                      The asset <a href="{{ route('hardware.edit', $asset->id) }}">should be edited</a> to correct this before attempting to check it in or out.</span>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>


                                        <!-- Asset Name -->
                                        <div class="form-group {{ $errors->has('name') ? 'error' : '' }}">
                                            {{ Form::label('name', trans('admin/hardware/form.name'), array('class' => 'col-md-3 control-label')) }}
                                            <div class="col-md-8">
                                                <input class="form-control" type="text" name="name" aria-label="name"
                                                       id="name"
                                                       value="{{ Input::old('name', $asset->name) }}"/>
                                                {!! $errors->first('name', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
                                            </div>
                                        </div>

                                        <!-- Status -->
                                        <div class="form-group {{ $errors->has('status_id') ? 'error' : '' }}">
                                            {{ Form::label('status_id', trans('admin/hardware/form.status'), array('class' => 'col-md-3 control-label')) }}
                                            <div class="col-md-7 required">
                                                {{ Form::select('status_id', $statusLabel_list, '', array('class'=>'select2', 'style'=>'width:100%','id' =>'modal-statuslabel_types', 'aria-label'=>'status_id')) }}
                                                {!! $errors->first('status_id', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
                                            </div>
                                        </div>

                                    @include ('partials.forms.edit.location-select', ['translated_name' => trans('general.location'), 'fieldname' => 'location_id', 'help_text' => ($asset->defaultLoc) ? 'You can choose to check this asset in to a location other than the default location of '.$asset->defaultLoc->name.' if one is set.' : null])

                                    <!-- Checkout/Checkin Date -->
                                        <div class="form-group{{ $errors->has('checkin_at') ? ' has-error' : '' }}">
                                            {{ Form::label('checkin_at', trans('admin/hardware/form.checkin_date'), array('class' => 'col-md-3 control-label')) }}
                                            <div class="col-md-8">
                                                <div class="input-group col-md-5 required">
                                                    <div class="input-group date" data-provide="datepicker"
                                                         data-date-format="yyyy-mm-dd" data-autoclose="true">
                                                        <input type="text" class="form-control"
                                                               placeholder="{{ trans('general.select_date') }}"
                                                               name="checkin_at" id="checkin_at"
                                                               value="{{ Input::old('checkin_at', date('Y-m-d')) }}">
                                                        <span class="input-group-addon"><i class="fa fa-calendar"
                                                                                           aria-hidden="true"></i></span>
                                                    </div>
                                                    {!! $errors->first('checkin_at', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Purchase Cost -->
                                        <style>
                                            @import 'star-rating';

                                            :root {
                                                --gl-star-empty: url(/img/star-empty.svg);
                                                --gl-star-full: url(/img/star-full.svg);
                                                --gl-star-size: 32px;
                                            }
                                        </style>
                                        <div class="form-group {{ $errors->has('quality') ? ' has-error' : '' }}">
                                            <label for="quality" class="col-md-3 control-label">Состояние</label>
                                            <div class="col-md-9">
                                                <div class="input-group col-md-4" style="padding-left: 0px;">
                                                    <select class="star-rating" name="quality" id="quality">
                                                        @if ($quality = Input::old('quality', (isset($asset)) ? $asset->quality : ''))
                                                            @if ($quality == 1)
                                                                <option value="">Оцените состояние</option>
                                                                <option value="5">Новое запакованное</option>
                                                                <option value="4">В отличном состоянии, но использовалось</option>
                                                                <option value="3">Рабочее, но с небольшими следами повреждений, небольшим загрязнением</option>
                                                                <option value="2">Частично рабочее или сильно загрязненное</option>
                                                                <option  selected value="1">Полностью не рабочее</option>
                                                            @elseif ($quality ==2 )
                                                                <option value="">Оцените состояние</option>
                                                                <option value="5">Новое запакованное</option>
                                                                <option value="4">В отличном состоянии, но использовалось</option>
                                                                <option value="3">Рабочее, но с небольшими следами повреждений, небольшим загрязнением</option>
                                                                <option selected value="2">Частично рабочее или сильно загрязненное</option>
                                                                <option value="1">Полностью не рабочее</option>
                                                            @elseif ($quality ==3 )
                                                                <option value="">Оцените состояние</option>
                                                                <option value="5">Новое запакованное</option>
                                                                <option value="4">В отличном состоянии, но использовалось</option>
                                                                <option selected value="3">Рабочее, но с небольшими следами повреждений, небольшим загрязнением</option>
                                                                <option value="2">Частично рабочее или сильно загрязненное</option>
                                                                <option value="1">Полностью не рабочее</option>
                                                            @elseif ($quality ==4 )
                                                                <option value="">Оцените состояние</option>
                                                                <option value="5">Новое запакованное</option>
                                                                <option selected value="4">В отличном состоянии, но использовалось</option>
                                                                <option value="3">Рабочее, но с небольшими следами повреждений, небольшим загрязнением</option>
                                                                <option value="2">Частично рабочее или сильно загрязненное</option>
                                                                <option value="1">Полностью не рабочее</option>
                                                            @elseif ($quality ==5 )
                                                                <option value="">Оцените состояние</option>
                                                                <option selected value="5">Новое запакованное</option>
                                                                <option value="4">В отличном состоянии, но использовалось</option>
                                                                <option value="3">Рабочее, но с небольшими следами повреждений, небольшим загрязнением</option>
                                                                <option value="2">Частично рабочее или сильно загрязненное</option>
                                                                <option value="1">Полностью не рабочее</option>
                                                            @else
                                                                <option selected value="">Оцените состояние</option>
                                                                <option value="5">Новое запакованное</option>
                                                                <option value="4">В отличном состоянии, но использовалось</option>
                                                                <option value="3">Рабочее, но с небольшими следами повреждений, небольшим загрязнением</option>
                                                                <option value="2">Частично рабочее или сильно загрязненное</option>
                                                                <option value="1">Полностью не рабочее</option>
                                                            @endif
                                                        @else
                                                            <option selected value="">Оцените состояние</option>
                                                            <option value="5">Новое запакованное</option>
                                                            <option value="4">В отличном состоянии, но использовалось</option>
                                                            <option value="3">Рабочее, но с небольшими следами повреждений, небольшим загрязнением</option>
                                                            <option value="2">Частично рабочее или сильно загрязненное</option>
                                                            <option value="1">Полностью не рабочее</option>
                                                        @endif
                                                        {{--                    <option value="">Оцените состояние</option>--}}
                                                        {{--                    <option value="5">Новое запакованное</option>--}}
                                                        {{--                    <option value="4">В отличном состоянии, но использовалось</option>--}}
                                                        {{--                    <option value="3">Рабочее, но с небольшими следами повреждений, небольшим загрязнением</option>--}}
                                                        {{--                    <option value="2">Частично рабочее или сильно загрязненное</option>--}}
                                                        {{--                    <option value="1">Полностью не рабочее</option>--}}
                                                    </select>
                                                    {{--            <input class="form-control" type="text" name="quality" aria-label="quality" id="quality" value="{{ Input::old('depreciable_cost', \App\Helpers\Helper::formatCurrencyOutput($item->depreciable_cost)) }}" />--}}
                                                </div>
                                                <div class="col-md-9" style="padding-left: 0px;">
                                                    {!! $errors->first('quality', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <!-- life Cost -->
                                        <div class="form-group">
                                            <label for="life" class="col-md-3 control-label">Срок эксплуатации (прошло/рассчетный)</label>
                                            <div class="col-md-9">
                                                @php
                                                    if ($asset->purchase_date){
                                                         $now = new DateTime();
                                                         $d2 = new DateTime($asset->purchase_date);
                                                         $interval = $d2->diff($now);
                                                         $result =  $interval->m + 12*$interval->y;

                                                     }
                                                     if($asset->model->lifetime){
                                                          $lifetime = $asset->model->lifetime;
                                                     }else if($asset->model->category->lifetime){
                                                         $lifetime = $asset->model->category->lifetime;
                                                     }else{
                                                         $lifetime = 36;
                                                     }
                                                @endphp
                                                <div class="input-group col-md-4" style="padding-left: 0px;">
                                                    <input class="form-control float" type="text" disabled
                                                           value="{{$result}}/{{ $lifetime }}"/>
                                                    <span class="input-group-addon">Месяцев</span>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Purchase Cost -->
                                        <div class="form-group {{ $errors->has('purchase_cost') ? ' has-error' : '' }}">
                                            <label for="purchase_cost" class="col-md-3 control-label">Закупочная стоимость</label>
                                            <div class="col-md-9">
                                                <div class="input-group col-md-4" style="padding-left: 0px;">
                                                    <input class="form-control float" type="text"
                                                           name="purchase_cost" aria-label="Purchase_cost"
                                                           id="purchase_cost"
                                                           disabled
                                                           value="{{ Input::old('purchase_cost', \App\Helpers\Helper::formatCurrencyOutput($asset->purchase_cost)) }}"/>
                                                    <span class="input-group-addon">
                @if (isset($currency_type))
                                                            {{ $currency_type }}
                                                        @else
                                                            {{ $snipeSettings->default_currency }}
                                                        @endif
            </span>
                                                </div>

                                                <div class="col-md-9" style="padding-left: 0px;">
                                                    {!! $errors->first('depreciable_cost', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <!-- depreciable Cost -->
                                        <div class="form-group {{ $errors->has('depreciable_cost') ? ' has-error' : '' }}">
                                            <label for="purchase_cost" class="col-md-3 control-label">Старая остаточная
                                                стоимость</label>
                                            <div class="col-md-9">
                                                <div class="input-group col-md-4" style="padding-left: 0px;">
                                                    <input class="form-control float" type="text"
                                                           name="depreciable_cost" aria-label="depreciable_cost"
                                                           id="depreciable_cost"
                                                           disabled
                                                           value="{{ Input::old('depreciable_cost', \App\Helpers\Helper::formatCurrencyOutput($asset->depreciable_cost)) }}"/>
                                                    <span class="input-group-addon">
                @if (isset($currency_type))
                                                            {{ $currency_type }}
                                                        @else
                                                            {{ $snipeSettings->default_currency }}
                                                        @endif
            </span>
                                                </div>

                                                <div class="col-md-9" style="padding-left: 0px;">
                                                    {!! $errors->first('depreciable_cost', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
                                                </div>
                                            </div>
                                        </div>
                                        <!-- new depreciable Cost -->
                                        <div class="form-group {{ $errors->has('depreciable_cost') ? ' has-error' : '' }}">
                                            <label for="purchase_cost" class="col-md-3 control-label">Новая остаточная
                                                стоимость</label>
                                            <div class="col-md-9">
                                                <div class="input-group col-md-4" style="padding-left: 0px;">
                                                    <input class="form-control float" type="text"
                                                           name="new_depreciable_cost" aria-label="depreciable_cost"
                                                           id="new_depreciable_cost"
                                                           value="{{ Input::old('new_depreciable_cost', \App\Helpers\Helper::formatCurrencyOutput($asset->new_depreciable_cost)) }}"/>
                                                    <span class="input-group-addon">
                @if (isset($currency_type))
                                                            {{ $currency_type }}
                                                        @else
                                                            {{ $snipeSettings->default_currency }}
                                                        @endif
            </span>
                                                </div>

                                                <div class="col-md-9" style="padding-left: 0px;">
                                                    {{--                                    {!! $errors->first('new_depreciable_cost', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}--}}
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Note -->
                                        <div class="form-group {{ $errors->has('note') ? 'error' : '' }}">

                                            {{ Form::label('note', trans('admin/hardware/form.notes'), array('class' => 'col-md-3 control-label')) }}

                                            <div class="col-md-8">
                  <textarea class="col-md-6 form-control" id="note"
                            name="note">{{ Input::old('note', $asset->note) }}</textarea>
                                                {!! $errors->first('note', '<span class="alert-msg" aria-hidden="true"><i class="fa fa-times" aria-hidden="true"></i> :message</span>') !!}
                                            </div>
                                        </div>
                                        <div class="box-footer">
                                            <a class="btn btn-link"
                                               href="{{ URL::previous() }}"> {{ trans('button.cancel') }}</a>
                                            <button type="submit" class="btn btn-primary pull-right"><i
                                                        class="fa fa-check icon-white"
                                                        aria-hidden="true"></i> {{ trans('general.checkin') }}</button>
                                        </div>
                                    </form>
                    </div> <!--/.col-md-12-->
                </div> <!--/.box-body-->

            </div> <!--/.box.box-default-->
        </div>
    </div>

@stop

@section('moar_scripts')
    <script nonce="{{ csrf_token() }}">
        $(function () {
            var starRatingControl = new StarRating('.star-rating', {
                maxStars: 5,
                tooltip: 'Оцените состояние',
                clearable: false,
            });
            calculeteCoast();

            function calculeteCoast() {
                $buyVal = $("#purchase_cost").val();
                $quality = $("#quality").val();
                if ($buyVal > 0 && $quality > 0) {
                    //quality count
                    $quality_divider = 1;
                    switch (parseInt($quality)) {
                        case 4:
                            $quality_divider = 0.75
                            break;
                        case 3:
                            $quality_divider = 0.50
                            break;
                        case 2:
                            $quality_divider = 0.25
                            break;
                        case 1:
                            $quality_divider = 0
                            break;
                    }
                    //lifetime count
                    @if (isset($asset->model->lifetime))
                        $lifetime = {{$asset->model->lifetime}};
                    @elseif (isset($asset->model->category->lifetime))
                        $lifetime = {{$asset->model->category->lifetime}};
                    @else
                        $lifetime = 36;
                    @endif

                            @if (isset($asset->purchase_date))
                        $buydate = "{{$asset->purchase_date}}";
                    $buydate = new Date($buydate.substr(0, 10));
                    $usetime = monthDiff($buydate);
                    $time_divider = ($lifetime - $usetime) / $lifetime;
                    if ($time_divider < 0) {
                        $time_divider = 0;
                    }
                    @else
                        $time_divider = 1/3;
                    @endif

                    //final count
                    $newVal = $buyVal * $quality_divider * $time_divider;
                    $newVal = $newVal.toFixed(2);
                    $("#new_depreciable_cost").val($newVal);
                }
            }

            $("#quality").change(function () {
                calculeteCoast();
            });

            function monthDiff(dateFrom) {
                var dateTo = new Date();
                return dateTo.getMonth() - dateFrom.getMonth() +
                    (12 * (dateTo.getFullYear() - dateFrom.getFullYear()))
            }
        });
    </script>
@stop