@extends('layouts/default')

{{-- Page title --}}
@section('title')
        	{{ trans('admin/hardware/form.bulk_delete') }}

@parent
@stop

@section('header_right')
    <a href="{{ URL::previous() }}" class="btn btn-primary pull-right">
        {{ trans('general.back') }}</a>
@stop



{{-- Page content --}}

@section('content')

    <div class="row">


        <!-- left column -->
        <div class="col-md-12">

            <p>{{ trans('admin/hardware/form.bulk_delete_help') }}</p>

            <form class="form-horizontal" method="post" action="{{ route('hardware/bulkdelete') }}" autocomplete="off" role="form">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title" style="color: red">{{ trans('admin/hardware/form.bulk_delete_warn', ['asset_count' => count($assets)]) }}</h3>
                </div>
                <div class="box-body">

                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    <table class="table table-striped table-condensed">
                        <thead>
                        <tr>
                            <td></td>
                            <td>ID</td>
                            <td>Name</td>
                            <td>Location</td>
                            <td>Assigned To</td>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($assets as $asset)
                            <tr>
                                <td><input type="checkbox" name="bulk_edit[]" value="{{ $asset->id }}" checked="checked"></td>
                                <td>{{ $asset->id }}</td>
                                <td>{{ $asset->showAssetName() }}</td>
                                <td>
                                    @if ($asset->assetloc)
                                        {{ $asset->assetloc->name }}
                                    @endif
                                </td>
                                <td>
                                    @if ($asset->assigneduser)
                                        {{ $asset->assigneduser->fullName() }} ({{ $asset->assigneduser->username }})
                                    @endif
                                </td>
                            </tr>
                        @endforeach

                        </tbody>

                    </table>
      

        </div><!-- /.box-body -->
        <div class="box-footer text-right">
            <a class="btn btn-link" href="{{ URL::previous() }}" method="post" enctype="multipart/form-data">{{ trans('button.cancel') }}</a>
            <button type="submit" class="btn btn-success" id="submit-button"><i class="fa fa-check icon-white"></i> {{ trans('general.delete') }}</button>
        </div><!-- /.box-footer -->
    </div><!-- /.box -->
            </form>


    </div>
</div>
@stop
