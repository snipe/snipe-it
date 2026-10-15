@extends('layouts/default')

{{-- Page title --}}
@section('title')
    {{ trans('admin/models/general.bulk_delete') }}
    @parent
@stop

@section('header_right')
    <a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
        {{ trans('general.back') }}</a>
@stop

{{-- Page content --}}
@section('content')
    <x-container class="col-md-8 col-md-offset-2">
        <p>{{ trans('admin/models/general.bulk_delete_help') }}</p>

        <x-form route="{{ route('models.bulkdelete.store') }}">
            <x-box>
                <x-slot:header>
                    <span style="color: red">
                        {{ trans_choice('admin/models/general.bulk_delete_warn', $valid_count, ['model_count' => $valid_count]) }}
                    </span>
                </x-slot:header>

                <table class="table table-striped table-condensed">
                    <thead>
                        <tr>
                            <td class="col-md-1">
                                <label>
                                    <input type="checkbox" id="checkAll" checked data-toggle="check-all">
                                </label>
                            </td>
                            <td class="col-md-1"><i class="fas fa-barcode" aria-hidden="true"></i></td>
                            <td class="col-md-10">{{ trans('general.name') }}</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($models as $model)
                            <tr{!! (($model->assets_count > 0) ? ' class="danger"' : '') !!}>
                                <td>
                                    <input type="checkbox" name="ids[]" value="{{ $model->id }}" {!! (($model->assets_count == 0) ? ' checked="checked"' : ' disabled') !!}>
                                </td>
                                <td>{{ $model->assets_count }}</td>
                                <td>{{ $model->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <x-slot:customfooter>
                    <div class="box-footer text-right">
                        <a class="btn btn-link pull-left" href="{{ URL::previous() }}">{{ trans('button.cancel') }}</a>
                        <button type="submit" class="btn btn-success" id="submit-button">
                            <x-icon type="checkmark" /> {{ trans('general.delete') }}
                        </button>
                    </div>
                </x-slot:customfooter>
            </x-box>
        </x-form>
    </x-container>
@stop
