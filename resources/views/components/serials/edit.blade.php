@extends('layouts.default')

{{-- Page title --}}
@section('title')
    {{ $serial->serial_number }}
    @parent
@stop

@section('header_right')
    <a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
        {{ trans('general.back') }}</a>
@stop



{{-- Page content --}}

@section('content')

    <!-- row -->
    <div class="row">
        <!-- col-md-8 -->
        <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1 col-sm-12 col-sm-offset-0">

            <form id="update-form" class="form-horizontal" method="post" action="{{ route('components.serials.update', $serial->id) }}" autocomplete="off" role="form" enctype="multipart/form-data">

                <!-- box -->
                <div class="box box-default">
                    <!-- box-header -->
                    <div class="box-header with-border text-right">

                        <div class="col-md-12 box-title text-right" style="padding: 0px; margin: 0px;">

                            <div class="col-md-12" style="padding: 0px; margin: 0px;">
                                <div class="col-md-9 text-left">
                                    <h2 class="box-title text-left" style="padding-top: 8px;">
                                        {{ $serial->serial_number }}
                                    </h2>
                                </div>
                                <div class="col-md-3 text-right" style="padding-right: 10px;">
                                    <a class="btn btn-link text-left" href="{{ URL::previous() }}">
                                        {{ trans('button.cancel') }}
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-check icon-white" aria-hidden="true"></i>
                                        {{ trans('general.save') }}
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div><!-- /.box-header -->

                    <!-- box-body -->
                    <div class="box-body">

                        {{ method_field('PUT') }}

                        <!-- CSRF Token -->
                        {{ csrf_field() }}

                        {{-- Input fields --}}

                        <!-- Purchase Order -->
                        <div class="form-group {{ $errors->has('purchase_order') ? ' has-error' : '' }}">
                            <label for="purchase_order" class="col-md-3 control-label">
                                Purchase Order ID
                            </label>
                            <div class="col-md-7 col-sm-12">
                                <input class="form-control" type="text" name="purchase_order" id="purchase_order" value="{{ old('purchase_order', $serial->purchase_order) }}" />
                                {!! $errors->first('purchase_order', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                            </div>
                        </div>

                        <!-- Purchase Date -->
                        <div class="form-group {{ $errors->has('purchase_date') ? ' has-error' : '' }}">
                            <label for="purchase_date" class="col-md-3 control-label">
                                Purchase Date
                            </label>
                            <div class="col-md-7 col-sm-12">
                                <input class="form-control" type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date', $serial->purchase_date) }}" />
                                {!! $errors->first('purchase_date', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                            </div>
                        </div>

                        <!-- Purchase Cost -->
                        <div class="form-group {{ $errors->has('purchase_cost') ? ' has-error' : '' }}">
                            <label for="purchase_cost" class="col-md-3 control-label">
                                Purchase Cost
                            </label>
                            <div class="col-md-7 col-sm-12">
                                <input class="form-control" type="number" min="0" step="0.01" name="purchase_cost" id="purchase_cost" value="{{ old('purchase_cost', $serial->purchase_cost) }}" />
                                {!! $errors->first('purchase_cost', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                            </div>
                        </div>

                        <!-- Supplier -->
                        <div class="form-group {{ $errors->has('supplier_id') ? ' has-error' : '' }}">
                            <label for="supplier_id" class="col-md-3 control-label">
                                Supplier
                            </label>
                            <div class="col-md-7 col-sm-12">
                                <select class="form-control" name="supplier_id" id="supplier_id">
                                    <option value="" disabled>Select a Supplier</option>
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}" {{ (old('supplier_id', $serial->supplier_id) == $supplier->id) ? ' selected="selected"' : '' }}>
                                            {{ $supplier->name }}
                                        </option>
                                    @endforeach
                                </select>
                                {!! $errors->first('supplier_id', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                            </div>
                        </div>

                        <!-- Warranty Months -->
                        <div class="form-group {{ $errors->has('warranty_months') ? ' has-error' : '' }}">
                            <label for="warranty_months" class="col-md-3 control-label">
                                Warranty Months
                            </label>
                            <div class="col-md-7 col-sm-12">
                                @if(!empty($serial->warranty_date))
                                    <input class="form-control" type="number" min="0" name="warranty_months" id="warranty_months" value="{{ old('warranty_months', $serial->warranty_date->diffInMonths()) }}" />
                                    <p class="help-block text-right">
                                        <span id="warranty_months_count">{{ $serial->warranty_date->diffForHumans() }}</span>
                                    </p>
                                @else
                                    <input class="form-control" type="number" min="0" name="warranty_months" id="warranty_months" value="{{ old('warranty_months') }}" />
                                @endif
                                {!! $errors->first('warranty_months', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="form-group {{ $errors->has('notes') ? ' has-error' : '' }}">
                            <label for="notes" class="col-md-3 control-label">
                                Notes
                            </label>
                            <div class="col-md-7 col-sm-12">
                                <textarea class="col-md-12 form-control" id="notes" name="notes">{{ old('notes', $serial->notes) }}</textarea>
                                {!! $errors->first('notes', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                            </div>
                        </div>

                        <!-- Reset Fields -->
                        <div class="form-group {{ $errors->has('reset_fields') ? ' has-error' : '' }}">
                            <label for="reset_fields" class="col-md-3 control-label">
                                Reset Fields
                            </label>
                            <div class="col-md-7 col-sm-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="reset_fields" id="reset_fields" value="1" />
                                </div>
                                {!! $errors->first('reset_fields', '<span class="alert-msg"><i class="fa fa-times"></i> :message</span>') !!}
                            </div>
                        </div>

                        {{-- END Input fields --}}

                        @include('partials.forms.edit.submit')

                    </div> <!-- ./box-body -->
                </div> <!-- box -->
            </form>
        </div> <!-- col-md-8 -->

    </div><!-- ./row -->

@stop
