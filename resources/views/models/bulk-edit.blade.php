@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('general.bluk_edit') }}
    @parent
@stop


{{-- Page content --}}
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">

            <form class="form-horizontal" method="post" action="{{ route('models.bulkedit.store') }}" autocomplete="off" role="form">
                {{ csrf_field() }}

                <div class="box box-default">
                    <div class="box-body">

                        <x-callout type="warning" icon="warning" live="assertive">
                            {{ trans_choice('admin/models/message.bulkedit.warn', count($models), ['model_count' => count($models)]) }}
                        </x-callout>


                        <table class="table table-striped">
                            @foreach ($models as $model)

                                <tr>
                                        <td>
                                            <i class="fa {!!  (($model->assets_count > 0 ) ? 'fa-warning text-warning fa-fw' : 'fa-check fa-fw text-success') !!}"></i>
                                            {{ $model->display_name }}

                                                @if ($model->model_number)
                                                    ({{ $model->model_number }})
                                                @endif
                                            </td>
                                            <td>{{ $model->assets_count }} assets
                                        </td>
                                </tr>

                        @endforeach
                        </table>

                        <div class="col-md-12" style="padding-top: 20px;">
                            <!-- manufacturer -->
                            @include ('partials.forms.edit.manufacturer-select', ['translated_name' => trans('general.manufacturer'), 'fieldname' => 'manufacturer_id'])

                            <!-- category -->
                            @include ('partials.forms.edit.category-select', ['translated_name' => trans('admin/categories/general.category_name'), 'fieldname' => 'category_id', 'required' => 'true', 'category_type' => 'asset'])

                            <!-- custom fields -->
                            <div class="form-group {{ $errors->has('fieldset_id') ? ' has-error' : '' }}">
                                <label for="category_id" class="col-md-3 control-label">
                                    {{ trans('admin/models/general.fieldset') }}
                                </label>
                                <div class="col-md-7">
                                    <x-input.select
                                        name="fieldset_id"
                                        :options="$fieldset_list"
                                        :selected="old('fieldset_id', 'NC')"
                                        class="js-fieldset-field"
                                        style="width:350px"
                                    />
                                    <x-form.error name="fieldset_id" />
                                </div>
                            </div>

                            <!-- depreciation -->

                            <div class="form-group {{ $errors->has('depreciation_id') ? ' has-error' : '' }}">
                                <label for="category_id" class="col-md-3 control-label">
                                    {{ trans('general.depreciation') }}
                                </label>
                                <div class="col-md-7">
                                    <x-input.select
                                        name="depreciation_id"
                                        :options="$depreciation_list"
                                        :selected="old('depreciation_id', 'NC')"
                                        style="width:350px"
                                    />
                                    <x-form.error name="depreciation_id" />
                                </div>
                            </div>

                            @include ('partials.forms.edit.minimum_quantity')
                            <!-- require serial boolean -->
                            <div class="form-group">
                                <label for="require_serial" class="col-md-3 control-label">
                                    {{ trans('admin/hardware/general.require_serial') }}
                                </label>

                                <div class="col-md-9">
                                    <div class="form-inline" style="display: flex; align-items: center; gap: 8px;">
                                        <input type="checkbox" name="require_serial" value="1" id="require_serial" aria-label="require_serial" />
                                        <x-form.tooltip>
                                            {{ trans('admin/hardware/general.require_serial_help') }}
                                        </x-form.tooltip>
                                    </div>
                                </div>
                            </div>

                            <!-- requestable -->
                            <x-form.radio-row
                                name="requestable"
                                selected=""
                                :options="[
                                    '' => trans('admin/hardware/general.requestable_status_warning'),
                                    '1' => trans('admin/hardware/general.requestable'),
                                    '0' => trans('admin/hardware/general.not_requestable'),
                                ]"
                            />

                            @foreach ($models as $model)
                                <input type="hidden" name="ids[{{ $model->id }}]" value="{{ $model->id }}">
                            @endforeach
                        </div>
                    </div> <!--/.box-body-->

                    <div class="box-footer text-right">
                        <a class="btn btn-link pull-left" href="{{ URL::previous() }}" method="post" enctype="multipart/form-data">{{ trans('button.cancel') }}</a>
                        <button type="submit" class="btn btn-success" id="submit-button"><x-icon type="checkmark" /> {{ trans('general.save') }}</button>
                    </div><!-- /.box-footer -->
                </div> <!--/.box.box-default-->
            </form>
        </div> <!--/.col-md-8-->
    </div>
@stop
